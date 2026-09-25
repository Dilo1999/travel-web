<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use App\Models\Package;
use Illuminate\Validation\ValidationException;

/**
 * The language switch on the package create/edit pages. The form always holds every language
 * and saving saves them all; switching only changes which language is shown.
 */
trait HasContentLocale
{
    public string $activeLocale = Package::SOURCE_LOCALE;

    /**
     * Keep the language in the address (?language=hi) so a refresh or shared link opens it.
     */
    protected function queryStringHasContentLocale(): array
    {
        return ['activeLocale' => ['except' => Package::SOURCE_LOCALE, 'as' => 'language']];
    }

    public function mountHasContentLocale(): void
    {
        if (! array_key_exists($this->activeLocale, PackageResource::locales())) {
            $this->activeLocale = Package::SOURCE_LOCALE;
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
                $this->activeLocale = Package::SOURCE_LOCALE;
                break;
            }
        }

        parent::onValidationError($exception);
    }

    public function setActiveLocale(string $locale): void
    {
        if (! array_key_exists($locale, PackageResource::locales()) || $locale === $this->activeLocale) {
            return;
        }

        // The other languages are translations of the English, so it has to be complete first.
        if ($this->activeLocale === Package::SOURCE_LOCALE) {
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

        foreach (PackageResource::locales() as $code => $properties) {
            $pending = null;
            $detail = null;

            if ($record instanceof Package && $code !== Package::SOURCE_LOCALE) {
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
