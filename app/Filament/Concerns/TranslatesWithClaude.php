<?php

namespace App\Filament\Concerns;

use Anthropic\Core\Exceptions\APIException;
use App\Services\ClaudeTranslator;
use App\Services\ContentTranslations;
use App\Services\SiteTranslations;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use RuntimeException;

/**
 * The "Translate with Claude" button on the edit page of a TranslatableForm resource (with HasContentLocale).
 * It saves the form, translates the record's English with ContentTranslations and reloads the form.
 */
trait TranslatesWithClaude
{
    protected function getTranslateAction(string $noun): Action
    {
        return Action::make('translate')
            ->label('Translate with Claude')
            ->icon('heroicon-o-translate')
            ->visible(fn () => static::getResource()::canEdit($this->record))
            ->modalHeading("Translate this {$noun} with Claude")
            ->modalSubheading('Your changes are saved first. The English text is then translated and saved, and you can review and correct each language afterwards.')
            ->modalButton('Save & translate')
            ->form([
                CheckboxList::make('locales')
                    ->label('Languages')
                    ->options(fn () => app(SiteTranslations::class)->targetLocales())
                    ->default(fn () => static::getResource()::isTranslating($this)
                        ? [$this->activeLocale]
                        : array_keys(app(SiteTranslations::class)->targetLocales()))
                    ->required(),
                Radio::make('scope')
                    ->label('What to translate')
                    ->options([
                        'pending' => 'Only text that is not translated yet or whose English has changed (keeps your edits)',
                        'all' => 'All text (replaces the current translations, including your edits)',
                    ])
                    ->default('pending')
                    ->required(),
            ])
            ->action(fn (array $data) => $this->translate($data['locales'], $data['scope'] === 'all'));
    }

    /**
     * @param  list<string>  $locales
     */
    public function translate(array $locales, bool $includeUpToDate): void
    {
        abort_unless(static::getResource()::canEdit($this->record), 403);

        $this->save(shouldRedirect: false);
        set_time_limit(0);

        try {
            $results = app(ContentTranslations::class)->translate($this->record, $locales, $includeUpToDate);
        } catch (RuntimeException|APIException $e) {
            $this->reloadForm();

            Notification::make()
                ->danger()
                ->title('Translation stopped')
                ->body(ClaudeTranslator::describeError($e).' Anything translated before this was saved.')
                ->persistent()
                ->send();

            return;
        }

        $this->reloadForm();
        $this->activeLocale = $locales[0];

        $translated = array_sum(array_column($results, 'translated'));
        $failed = array_sum(array_map(fn (array $result) => count($result['failed']), $results));
        $names = implode(' and ', array_map(fn ($locale) => static::getResource()::locales()[$locale]['name'], $locales));

        if ($translated === 0 && $failed === 0) {
            Notification::make()->success()->title("{$names} is already up to date")->body('Nothing needed translating.')->send();

            return;
        }

        Notification::make()
            ->{$failed ? 'warning' : 'success'}()
            ->title("Translated {$translated} ".str('text')->plural($translated)." into {$names}")
            ->body($failed
                ? "{$failed} could not be translated and still show in English. Translate again to retry, or type them in."
                : 'Saved and live on the website. Review them here and correct anything you like.')
            ->persistent()
            ->send();
    }

    private function reloadForm(): void
    {
        $this->record->refresh();
        $this->fillForm();
    }
}
