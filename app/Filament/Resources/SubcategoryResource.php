<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubcategoryResource\Pages;
use App\Filament\Resources\SubcategoryResource\RelationManagers;
use App\Models\Subcategory;
use App\Models\Categories;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;



class SubcategoryResource extends Resource
{
    protected static ?string $model = Subcategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form


        ->schema([
            
            Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
            Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),

            Select::make('category_id')
                        ->label('Seleccionar categoria')
                        ->options(Categories::all()->pluck('nombre', 'id'))
                        ->searchable(),
     


        ]);



            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                


                Tables\Columns\TextColumn::make('nombre')->sortable()->searchable(),
                
               //Tables\Columns\TextColumn::make('Categories.nombre')->sortable()->searchable(),





            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            
            'category'

        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSubcategories::route('/'),
        ];
    }    
}
