<?php

namespace App\Services;

use App\Models\Package;

/**
 * Translates package text into the other site languages with Claude (via ClaudeTranslator).
 * Used only by the "Translate with Claude" button on a package's edit page; the website-wide
 * Translator page leaves packages alone. By default only missing and outdated translations
 * are sent, so edits made by hand in the package editor are kept.
 */
class PackageTranslations
{
    public function __construct(private SiteTranslations $site) {}

    /**
     * Translate one package into the given locales and save after every API request.
     *
     * @param  list<string>  $locales
     * @return array<string, array{translated: int, failed: array<string, string>}> by locale
     */
    public function translate(Package $package, array $locales, bool $includeUpToDate = false): array
    {
        $results = [];

        foreach ($locales as $locale) {
            $results[$locale] = $this->translateLocale($package, $locale, $includeUpToDate);
        }

        return $results;
    }

    /**
     * @return array{translated: int, failed: array<string, string>}
     */
    public function translateLocale(Package $package, string $locale, bool $includeUpToDate = false): array
    {
        $pending = $package->pendingTranslations($locale, $includeUpToDate);

        if (! $pending) {
            return ['translated' => 0, 'failed' => []];
        }

        $items = [];
        foreach ($pending as $path => $english) {
            $items[$path] = ['text' => $english, 'context' => $package->describePath($path)];
        }

        $translated = 0;
        $failed = $this->site->translator()->translate(
            $items,
            $this->site->targetLocales()[$locale],
            $this->site->glossary($locale),
            function (array $done) use ($package, $locale, &$translated) {
                foreach ($done as $path => $text) {
                    $package->setTranslation($path, $locale, $text);
                }
                $package->save();
                $translated += count($done);
            },
        );

        return ['translated' => $translated, 'failed' => $failed];
    }
}
