<?php

namespace App\Filament\Concerns;

use App\Models\Contracts\TranslatableContent;
use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Group;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Form helpers for a resource whose model is TranslatableContent (PackageResource, DestinationResource).
 *
 * The form holds every language at once; the language switch on the create/edit pages
 * (HasContentLocale) only changes which language is shown, via the data-content-locale /
 * data-locale-shared markers styled in resources/views/filament/content-locale-styles.blade.php.
 * Fields are hidden with CSS rather than ->hidden() because Filament does not save hidden fields.
 */
trait TranslatableForm
{
    /**
     * @return array<string, array{name: string, native: string}> locale => names, English first
     */
    public static function locales(): array
    {
        return LaravelLocalization::getSupportedLocales();
    }

    /**
     * One copy of a field per language, each tagged with its locale so only the active one shows.
     * English is required where $required; the other languages show the English beneath them.
     *
     * @param  Closure(string $path): \Filament\Forms\Components\Field  $make
     * @return list<Group>
     */
    public static function localized(string $name, Closure $make, bool $required = false, ?string $help = null): array
    {
        $source = TranslatableContent::SOURCE_LOCALE;
        $groups = [];

        foreach (static::locales() as $locale => $properties) {
            $field = $make("{$name}.{$locale}");

            if ($locale === $source) {
                $field->required($required)->helperText($help);
            } else {
                $field
                    ->label($field->getLabel().' · '.$properties['native'])
                    ->required(false)
                    ->placeholder(fn (Closure $get) => $get("{$name}.{$source}"))
                    ->helperText(fn (Closure $get) => filled($english = $get("{$name}.{$source}")) ? 'English: '.$english : 'No English text yet.')
                    ->hint(fn (Closure $get, $livewire) => static::isOutdated($livewire, $name, $locale, $get) ? 'English changed since this was translated' : null)
                    ->hintIcon(fn (Closure $get, $livewire) => static::isOutdated($livewire, $name, $locale, $get) ? 'heroicon-s-exclamation' : null)
                    ->hintColor('warning');
            }

            $groups[] = Group::make([$field])->extraAttributes(['data-content-locale' => $locale]);
        }

        return $groups;
    }

    /**
     * Fields that are the same in every language; they are only shown while editing English.
     */
    public static function shared(Component ...$components): Group
    {
        return Group::make($components)->extraAttributes(['data-locale-shared' => 'true']);
    }

    public static function isTranslating($livewire): bool
    {
        return ($livewire->activeLocale ?? TranslatableContent::SOURCE_LOCALE) !== TranslatableContent::SOURCE_LOCALE;
    }

    /**
     * A repeater item's label in the language being edited, falling back to English.
     */
    protected static function itemLabel(array $state, string $field, $livewire, string $fallback): string
    {
        $source = TranslatableContent::SOURCE_LOCALE;
        $locale = $livewire->activeLocale ?? $source;
        $text = $state[$field][$locale] ?? null;
        $label = filled($text) ? $text : (($state[$field][$source] ?? null) ?: $fallback);

        if ($locale !== $source && blank($text) && filled($state[$field][$source] ?? null)) {
            $label .= ' — not translated';
        }

        return $label;
    }

    /**
     * Whether the saved translation at this field was made from different English than the form now has.
     */
    private static function isOutdated($livewire, string $name, string $locale, Closure $get): bool
    {
        $record = $livewire->record ?? null;

        if (! $record instanceof TranslatableContent || blank($get("{$name}.{$locale}"))) {
            return false;
        }

        // Inside a repeater item the path includes the list name and item key.
        $key = $get('key');
        $path = $key ? $record::listPrefixFor($name)."{$key}.{$name}" : $name;

        return isset($record->translation_sources[$locale][$path])
            && $record->translation_sources[$locale][$path] !== sha1((string) $get("{$name}.".TranslatableContent::SOURCE_LOCALE));
    }
}
