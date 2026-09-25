<?php

namespace App\Filament\Resources\DestinationResource\Pages;

use App\Filament\Concerns\HasContentLocale;
use App\Filament\Resources\DestinationResource;
use App\Models\Destination;
use Filament\Resources\Pages\CreateRecord;

class CreateDestination extends CreateRecord
{
    use HasContentLocale;

    protected static string $resource = DestinationResource::class;

    protected static string $view = 'filament.content-locale.create-record';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sort_order'] = (int) Destination::query()->max('sort_order') + 1;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
