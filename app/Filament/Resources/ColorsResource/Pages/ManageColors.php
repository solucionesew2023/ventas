<?php

namespace App\Filament\Resources\ColorsResource\Pages;

use App\Filament\Resources\ColorsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageColors extends ManageRecords
{
    protected static string $resource = ColorsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
