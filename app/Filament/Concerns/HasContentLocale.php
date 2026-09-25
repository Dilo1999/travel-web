<?php

namespace App\Filament\Concerns;

use App\Models\Contracts\TranslatableContent;
use Illuminate\Validation\ValidationException;

/**
 * The language switch on the create/edit pages of a TranslatableForm resource. The form always
 * holds every language and saving saves them all; switching only changes which language is shown.
 * The page's view includes filament.content-locale.switcher above the form.
 */
trait HasContentLocale
{
    public string $activeLocale = TranslatableContent::SOURCE_LOCALE;

    /**
     * Keep the language in the address (?language=hi) so a refresh or shared link opens it.
     */
    protected function queryStringHasContentLocale(): array
    {
        return ['activeLocale' => ['except' => TranslatableContent::SOURCE_LOCALE, 'as' => 'language']];
    }

    public function mountHasContentLocale(): void
    {
        if (! array_key_exists($this->activeLocale, static::getResource()::locales())) {
            $this->activeLocale = TranslatableContent::SOURCE_LOCALE;
        }
    }

    /**
     * An error in a field that is hidden in this language (English or a shared setting) would be
     * invisible, so go back to English to show it.
     */
    protected function onValidationError(ValidationException $exception): void
    {
        $suffix = '.'.$this->activeLocale;

        foreach (array_keys($exception->errors()) as $key) {
            if (! str_ends_with($key, $suffix)) {
                $this->activeLocale = TranslatableContent::SOURCE_LOCALE;
                break;
            }
        }

        parent::onValidationError($exception);
    }

    public function setActiveLocale(string $locale): void
    {
        if (! array_key_exists($locale, static::getResource()::locales()) || $locale === $this->activeLocale) {
            return;
        }

        // The other languages are translations of the English, so it has to be complete first.
        if ($this->activeLocale === TranslatableContent::SOURCE_LOCALE) {
            $this->form->validate();
        }

        $this->activeLocale = $locale;
    }

    /**
     * @return array<string, array{native: string, name: string, pending: ?int, detail: ?string}> for the switch
     */
    public function getContentLocales(): array
    {
        $record = property_exists($this, 'record') ? $this->record : null;
        $locales = [];

        foreach (static::getResource()::locales() as $code => $properties) {
            $pending = null;
            $detail = null;

            if ($record instanceof TranslatableContent && $code !== TranslatableContent::SOURCE_LOCALE) {
                $summary = $record->translationSummary($code);
                $pending = $summary['missing'] + $summary['outdated'];
                $detail = $pending
                    ? "{$summary['missing']} not translated, {$summary['outdated']} outdated"
                    : 'All text translated';
            }

            $locales[$code] = ['native' => $properties['native'], 'name' => $properties['name'], 'pending' => $pending, 'detail' => $detail];
        }

        return $locales;
    }
}
