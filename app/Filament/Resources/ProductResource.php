<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;

use Illuminate\Support\Str;

use App\Filament\Resources\collable;

use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Color;

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
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;

use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup='Productos';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

       TextInput::make('nombre')->required()
                ->unique(ignoreRecord:true)
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set)=> $set('slug',Str::slug($state))),
       TextInput::make('slug')->required()
                 ->unique(ignoreRecord:true),


                 Card::make()
                 ->schema([
                    RichEditor::make('descripcion')->required(),
                 ])->columns(1),

       
               
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

        Select::make('color_id')->label('Color')
                    ->options(Color::all()->pluck('nombre', 'id'))
                    ->searchable(),
        TextInput::make('cantidad')->required()
                                           ->Numeric(),

        FileUpload::make('image')->image()->multiple(),
                    
   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                TextColumn::make('id')->sortable(),
                TextColumn::make('nombre')->sortable()->searchable(),
                TextColumn::make('subcategory.nombre')->sortable()->searchable(),
                TextColumn::make('subcategory.category.nombre')->sortable()->searchable(),
                TextColumn::make('products.withPivot.cantidad')->sortable()->searchable(),
               

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
