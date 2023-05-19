<?php

namespace App\Filament\Resources\SubcategoryResource\Pages;

use App\Filament\Resources\SubcategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSubcategories extends ManageRecords
{
    protected static string $resource = SubcategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
