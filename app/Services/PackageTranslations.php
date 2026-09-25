<?php

namespace App\Services;

use App\Models\Package;

/**
 * Translates package text into the other site languages with Claude (via ClaudeTranslator).
 * Used by the "Translate with Claude" button on a package and by the Translator page's
 * website-wide run. By default only missing and outdated translations are sent, so edits
 * made by hand in the package editor are kept.
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
     * The next package and locale with anything to translate, skipping "id|locale" pairs given up on.
     *
     * @param  list<string>  $skipped
     * @return array{0: Package, 1: string}|null
     */
    public function next(array $skipped = []): ?array
    {
        foreach (Package::query()->ordered()->get() as $package) {
            foreach (array_keys($this->site->targetLocales()) as $locale) {
                if (! in_array("{$package->id}|{$locale}", $skipped, true) && $package->pendingTranslations($locale)) {
                    return [$package, $locale];
                }
            }
        }

        return null;
    }

    /**
     * How many package texts still need translating, across all packages and target locales.
     */
    public function pendingCount(array $skipped = []): int
    {
        $count = 0;

        foreach (Package::query()->get() as $package) {
            foreach (array_keys($this->site->targetLocales()) as $locale) {
                if (! in_array("{$package->id}|{$locale}", $skipped, true)) {
                    $count += count($package->pendingTranslations($locale));
                }
            }
        }

        return $count;
    }

    /**
     * @return array<string, array{total: int, current: int}> by locale, across all packages
     */
    public function status(): array
    {
        $status = array_map(fn () => ['total' => 0, 'current' => 0], $this->site->targetLocales());

        foreach (Package::query()->get() as $package) {
            foreach (array_keys($status) as $locale) {
                $summary = $package->translationSummary($locale);
                $status[$locale]['total'] += $summary['total'];
                $status[$locale]['current'] += $summary['total'] - $summary['missing'] - $summary['outdated'];
            }
        }

        return $status;
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
