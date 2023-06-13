<?php

namespace App\Filament\Resources\ProviderResource\Pages;

use App\Filament\Resources\ProviderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProviders extends ManageRecords
{
    protected static string $resource = ProviderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
