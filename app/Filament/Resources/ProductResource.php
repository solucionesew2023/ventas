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
use App\Models\Size;
use App\Models\Tax;
use App\Models\Brand;

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
use Filament\Forms\Components\Radio;
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

       TextInput::make('name')->required()
                ->unique(ignoreRecord:true)
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set)=> $set('slug',Str::slug($state))),
       TextInput::make('slug')->required()
                 ->unique(ignoreRecord:true),
       Select::make('tax_id')
                 ->label('Taxes')
                 ->required()
                 ->options(Tax::all()->pluck(value:'name', key:'id')->toArray()),
       Select::make('brand_id')
                 ->label('Brands')
                 ->required()
                 ->options(Brand::all()->pluck(value:'name', key:'id')->toArray()),
        TextInput::make('price_buys')->required()
                 ->Numeric(),
        TextInput::make('profit_percentage')->required()
                 ->Numeric(),
    
       Card::make()
                 ->schema([
                    RichEditor::make('description')->required(),
                 ])->columns(1),

       
               
       Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->options(Category::all()->pluck(value:'name', key:'id')->toArray())
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('subcategory_id', null)),

       Select::make( name: 'subcategory_id' )
                    ->label(label: 'SubCategory')
                    ->required()
                    ->options( function ( callable $get ) {
                        
                        $category = Category::find( $get('category_id'));

                        if($category){
                            return $category->subcategories->pluck('name', 'id');
                        }
                       

                    }),

       Radio::make( name: 'tienecolor')
                    ->label(label: '¿The product has color?')
                    ->options([
                        'yes' => 'Yes',
                        'no' => 'No',])
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('color_id', null))
                    ->required()
                    ->inline(),
   
       Select::make( name: 'color_id' )
                    ->label(label: 'Colores')
                    ->options( function ( callable $get ) {
                        
                       if($get('tienecolor')=='yes'){
                            return Color::all()->pluck( value: 'name', key: 'id');
                        }
                      


                    }),
       Radio::make( name: 'tienetalla')
                    ->label(label: '¿The product has size?')
                    ->options([
                        'yes' => 'Yes',
                        'no' => 'No',])
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('size_id', null))
                    ->required()
                    ->inline(),
   
    Select::make( name: 'size_id' )
                    ->label(label: 'Tallas')
                    ->options( function ( callable $get ) {
                        
                       if($get('tienetalla')=='yes'){
                            return Size::all()->pluck( value: 'name', key: 'id');
                        }
                      


                    }),
 
    
        TextInput::make('quantity')->required()
                                           ->Numeric(),

        FileUpload::make('image')->image()->multiple(),
                    
   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('subcategory.name')->sortable()->searchable(),
                TextColumn::make('subcategory.category.name')->sortable()->searchable(),
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
