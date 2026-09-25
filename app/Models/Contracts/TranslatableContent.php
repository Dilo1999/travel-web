<?php

namespace App\Models\Contracts;

/**
 * Content edited in the admin panel in every site language and translated with Claude
 * (Package, Destination). Implemented with App\Models\Concerns\HasTranslatableText.
 */
interface TranslatableContent
{
    /** The language everything is written in first and translated from. */
    public const SOURCE_LOCALE = 'en';

    /**
     * @return array<string, array<string, string>> path => [locale => text]
     */
    public function textEntries(): array;

    /**
     * @return array<string, string> path => English
     */
    public function pendingTranslations(string $locale, bool $includeUpToDate = false): array;

    /**
     * @return array{total: int, missing: int, outdated: int}
     */
    public function translationSummary(string $locale): array;

    public function setTranslation(string $path, string $locale, string $text): void;

    /**
     * Where a path appears, in words, sent to Claude as context for the translation.
     */
    public function describePath(string $path): string;
}
