<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\collable;

use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;

use App\Models\Category;
use App\Models\Subcategory;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
                Select::make('category_id')
                    ->label('Categoria')
                    ->options(Category::all()->pluck(value:'nombre', key:'id')->toArray())
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('subcategory_id', null)),

                Select::make( name: 'subcategory_id' )
                    ->label(label: 'SubCategoria')
                    ->options( function ( callable $get ) {
                        
                        $category = Category::find( $get('category_id'));

                        if(! $category){
                            return Subcategory::all()->pluck( value: 'nombre', key: 'id');
                        }
                        return $category->subcategories->pluck('nombre', 'id');

                    }),
   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                TextColumn::make('id')->sortable(),
                TextColumn::make('nombre')->sortable()->searchable()
               
               

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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }    
}
