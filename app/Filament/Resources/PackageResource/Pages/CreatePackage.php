<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use App\Models\Package;
use Filament\Resources\Pages\CreateRecord;

class CreatePackage extends CreateRecord
{
    use HasContentLocale;

    protected static string $resource = PackageResource::class;

    protected static string $view = 'filament.resources.package-resource.create-package';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sort_order'] = (int) Package::query()->max('sort_order') + 1;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
