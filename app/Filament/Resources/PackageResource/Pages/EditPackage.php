<?php

namespace App\Filament\Resources\PackageResource\Pages;

use Anthropic\Core\Exceptions\APIException;
use App\Filament\Resources\PackageResource;
use App\Models\Package;
use App\Services\ClaudeTranslator;
use App\Services\PackageTranslations;
use App\Services\SiteTranslations;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use RuntimeException;

/**
 * @property Package $record
 */
class EditPackage extends EditRecord
{
    use HasContentLocale;

    protected static string $resource = PackageResource::class;

    protected static string $view = 'filament.resources.package-resource.edit-package';

    protected function getActions(): array
    {
        return [
            Actions\Action::make('translate')
                ->label('Translate with Claude')
                ->icon('heroicon-o-translate')
                ->visible(fn () => PackageResource::canEdit($this->record))
                ->modalHeading('Translate this package with Claude')
                ->modalSubheading('Your changes are saved first. The English text is then translated and saved, and you can review and correct each language afterwards.')
                ->modalButton('Save & translate')
                ->form([
                    CheckboxList::make('locales')
                        ->label('Languages')
                        ->options(fn () => app(SiteTranslations::class)->targetLocales())
                        ->default(fn () => PackageResource::isTranslating($this)
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
                ->action(fn (array $data) => $this->translate($data['locales'], $data['scope'] === 'all')),

            Actions\Action::make('view')
                ->label('View on website')
                ->icon('heroicon-o-external-link')
                ->color('secondary')
                ->url(fn () => LaravelLocalization::getLocalizedURL($this->activeLocale, route('packages.show', $this->record->slug), [], true))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->is_published),

            Actions\DeleteAction::make(),
        ];
    }

    /**
     * @param  list<string>  $locales
     */
    public function translate(array $locales, bool $includeUpToDate): void
    {
        abort_unless(PackageResource::canEdit($this->record), 403);

        $this->save(shouldRedirect: false);
        set_time_limit(0);

        try {
            $results = app(PackageTranslations::class)->translate($this->record, $locales, $includeUpToDate);
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
        $names = implode(' and ', array_map(fn ($locale) => PackageResource::locales()[$locale]['name'], $locales));

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
