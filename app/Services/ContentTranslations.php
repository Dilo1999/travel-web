<?php

namespace App\Services;

use App\Models\Contracts\TranslatableContent;
use Illuminate\Database\Eloquent\Model;

/**
 * Translates a package's or destination's text into the other site languages with Claude (via
 * ClaudeTranslator). Used only by the "Translate with Claude" button on their edit pages; the
 * website-wide Translator page leaves them alone. By default only missing and outdated
 * translations are sent, so edits made by hand in the editor are kept.
 */
class ContentTranslations
{
    public function __construct(private SiteTranslations $site) {}

    /**
     * Translate one record into the given locales and save after every API request.
     *
     * @param  TranslatableContent&Model  $record
     * @param  list<string>  $locales
     * @return array<string, array{translated: int, failed: array<string, string>}> by locale
     */
    public function translate(TranslatableContent $record, array $locales, bool $includeUpToDate = false): array
    {
        $results = [];

        foreach ($locales as $locale) {
            $results[$locale] = $this->translateLocale($record, $locale, $includeUpToDate);
        }

        return $results;
    }

    /**
     * @param  TranslatableContent&Model  $record
     * @return array{translated: int, failed: array<string, string>}
     */
    public function translateLocale(TranslatableContent $record, string $locale, bool $includeUpToDate = false): array
    {
        $pending = $record->pendingTranslations($locale, $includeUpToDate);

        if (! $pending) {
            return ['translated' => 0, 'failed' => []];
        }

        $items = [];
        foreach ($pending as $path => $english) {
            $items[$path] = ['text' => $english, 'context' => $record->describePath($path)];
        }

        $translated = 0;
        $failed = $this->site->translator()->translate(
            $items,
            $this->site->targetLocales()[$locale],
            $this->site->glossary($locale),
            function (array $done) use ($record, $locale, &$translated) {
                foreach ($done as $path => $text) {
                    $record->setTranslation($path, $locale, $text);
                }
                $record->save();
                $translated += count($done);
            },
        );

        return ['translated' => $translated, 'failed' => $failed];
    }
}
