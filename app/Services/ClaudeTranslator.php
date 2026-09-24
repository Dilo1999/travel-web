<?php

namespace App\Services;

use Anthropic\Client;
use RuntimeException;

/**
 * Translates English site copy into another locale with the Claude API.
 * Used by the admin Translator page; nothing calls this when serving the site.
 */
class ClaudeTranslator
{
    // Keep each request's output well under maxTokens; Devanagari/Tamil run several tokens per word.
    private const BATCH_ITEMS = 40;
    private const BATCH_CHARS = 5000;

    private Client $client;

    public function __construct(private string $model, ?string $apiKey, private string $brand)
    {
        if (! $apiKey) {
            throw new RuntimeException('ANTHROPIC_API_KEY is not set in .env.');
        }

        $this->client = new Client(apiKey: $apiKey);
    }

    /**
     * @param  array<string, array{text: string, context: string}>  $items  id => English source
     * @param  array<string, string>  $glossary  English => existing translation, for consistent terminology
     * @param  callable(array<string, string>): void  $onBatch  receives id => translation after each request
     * @return array<string, string> id => reason, for items that still failed after one retry
     */
    public function translate(array $items, string $language, array $glossary, callable $onBatch): array
    {
        $system = $this->systemPrompt($language, $glossary);
        $failed = [];

        foreach ($this->batches($items) as $batch) {
            $failed += $this->run($batch, $system, $onBatch);
        }

        if (! $failed) {
            return [];
        }

        // One retry for anything that was dropped or failed validation, telling Claude what went wrong.
        $retry = [];
        foreach ($failed as $id => $reason) {
            $retry[$id] = $items[$id] + ['note' => "A previous translation was rejected: {$reason}"];
        }

        $stillFailed = [];
        foreach ($this->batches($retry) as $batch) {
            $stillFailed += $this->run($batch, $system, $onBatch);
        }

        return $stillFailed;
    }

    /**
     * Send one batch, report the good translations, and return id => reason for the rest.
     */
    private function run(array $batch, string $system, callable $onBatch): array
    {
        $payload = [];
        foreach ($batch as $id => $item) {
            $payload[] = ['id' => $id] + $item;
        }

        $message = $this->client->beta->messages->create(
            model: $this->model,
            maxTokens: 16000,
            system: [
                ['type' => 'text', 'text' => $system, 'cacheControl' => ['type' => 'ephemeral']],
            ],
            messages: [
                ['role' => 'user', 'content' => json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)],
            ],
            outputConfig: [
                'format' => [
                    'type' => 'json_schema',
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'translations' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => ['type' => 'string'],
                                        'text' => ['type' => 'string'],
                                    ],
                                    'required' => ['id', 'text'],
                                    'additionalProperties' => false,
                                ],
                            ],
                        ],
                        'required' => ['translations'],
                        'additionalProperties' => false,
                    ],
                ],
            ],
            // If the model declines on policy grounds, the API retries on its default fallback model.
            fallbacks: 'default',
            betas: ['server-side-fallback-2026-07-01'],
        );

        if ($message->stopReason === 'max_tokens') {
            if (count($batch) === 1) {
                return [array_key_first($batch) => 'response was cut off at the token limit'];
            }

            // Output didn't fit: split the batch and try each half.
            [$first, $second] = array_chunk($batch, (int) ceil(count($batch) / 2), true);

            return $this->run($first, $system, $onBatch) + $this->run($second, $system, $onBatch);
        }

        if ($message->stopReason === 'refusal') {
            return array_fill_keys(array_keys($batch), 'the model declined to translate this batch');
        }

        $json = '';
        foreach ($message->content as $block) {
            if ($block->type === 'text') {
                $json .= $block->text;
            }
        }

        $returned = [];
        foreach (json_decode($json, true)['translations'] ?? [] as $row) {
            $returned[$row['id']] = $row['text'];
        }

        $done = [];
        $failed = [];
        foreach ($batch as $id => $item) {
            $problem = isset($returned[$id])
                ? $this->validate($item['text'], $returned[$id])
                : 'it was missing from the response';

            if ($problem === null) {
                $done[$id] = trim($returned[$id]);
            } else {
                $failed[$id] = $problem;
            }
        }

        if ($done) {
            $onBatch($done);
        }

        return $failed;
    }

    /**
     * Mechanical checks that a translation is safe to publish; returns the problem or null.
     */
    private function validate(string $source, string $translation): ?string
    {
        if (trim($translation) === '') {
            return 'the translation was empty';
        }

        // Laravel replaces :name placeholders at runtime; a missing one silently drops data.
        preg_match_all('/:[A-Za-z_]+/', $source, $placeholders);
        foreach (array_unique($placeholders[0]) as $placeholder) {
            if (! str_contains($translation, $placeholder)) {
                return "the placeholder {$placeholder} was missing";
            }
        }

        if (str_contains($source, $this->brand) && ! str_contains($translation, $this->brand)) {
            return "the brand name \"{$this->brand}\" was not kept in Latin script";
        }

        preg_match_all('/<\/?[a-z][^>]*>/i', $source, $sourceTags);
        preg_match_all('/<\/?[a-z][^>]*>/i', $translation, $translatedTags);
        sort($sourceTags[0]);
        sort($translatedTags[0]);
        if ($sourceTags[0] !== $translatedTags[0]) {
            return 'the HTML tags did not match the English';
        }

        return null;
    }

    /**
     * Split items into batches by count and by total English length; each batch is one API request.
     */
    public function batches(array $items): array
    {
        $batches = [];
        $current = [];
        $chars = 0;

        foreach ($items as $id => $item) {
            $length = mb_strlen($item['text']);

            if ($current && (count($current) >= self::BATCH_ITEMS || $chars + $length > self::BATCH_CHARS)) {
                $batches[] = $current;
                $current = [];
                $chars = 0;
            }

            $current[$id] = $item;
            $chars += $length;
        }

        if ($current) {
            $batches[] = $current;
        }

        return $batches;
    }

    private function systemPrompt(string $language, array $glossary): string
    {
        $prompt = <<<PROMPT
        You translate website copy for {$this->brand}, a Sri Lankan travel company. It runs tours across Sri Lanka and books holidays abroad, mostly for families, couples and groups travelling from India.

        Translate each item from English into {$language} as it would read on a professionally localised travel website: natural, warm and concise rather than word-for-word. Use the vocabulary Indian travellers actually use. Where an English loanword is more natural in {$language} than a formal native coinage (words like safari, resort or check-in), write the loanword in {$language} script.

        Each item has an id, the English text, and a context saying where it appears on the site (a UI key such as site.nav.home, or a content path such as travel.packages.3.blurb). Use the context to judge length and register: navigation and button labels stay short, descriptions can read as full sentences. An item may also carry a note explaining why an earlier translation was rejected; fix that problem.

        These must come through unchanged, because the site depends on them:
        - Laravel placeholders such as :name, :count or :package, including the leading colon. They are replaced with values at render time. Move them to wherever the grammar needs them, but never translate, respell or drop them.
        - The brand name "{$this->brand}", kept in Latin script.
        - HTML tags, email addresses and URLs.
        Keep numbers, prices, dates and times accurate.

        Return one entry per input item with the same id and the translated text.
        PROMPT;

        if ($glossary) {
            $lines = [];
            foreach ($glossary as $english => $translated) {
                $lines[] = "{$english} => {$translated}";
            }

            $prompt .= "\n\nThe site already uses these translations. Keep terminology consistent with them:\n".implode("\n", $lines);
        }

        return $prompt;
    }
}
