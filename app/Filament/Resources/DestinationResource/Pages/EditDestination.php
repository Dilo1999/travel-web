<?php

namespace App\Filament\Resources\DestinationResource\Pages;

use App\Filament\Concerns\HasContentLocale;
use App\Filament\Concerns\TranslatesWithClaude;
use App\Filament\Resources\DestinationResource;
use App\Models\Destination;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * @property Destination $record
 */
class EditDestination extends EditRecord
{
    use HasContentLocale;
    use TranslatesWithClaude;

    protected static string $resource = DestinationResource::class;

    protected static string $view = 'filament.content-locale.edit-record';

    protected function getActions(): array
    {
        return [
            $this->getTranslateAction('destination'),

            Actions\Action::make('view')
                ->label('View on website')
                ->icon('heroicon-o-external-link')
                ->color('secondary')
                ->url(fn () => LaravelLocalization::getLocalizedURL($this->activeLocale, route('destinations', ['kind' => $this->record->kind]), [], true))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->is_published),

            Actions\DeleteAction::make(),
        ];
    }
}
