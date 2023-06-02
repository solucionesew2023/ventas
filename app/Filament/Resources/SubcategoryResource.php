<?php
namespace App\Filament\Resources;
use App\Models\Subcategory;
use App\Models\Category;

use App\Filament\Resources\SubcategoryResource\Pages;
use App\Filament\Resources\SubcategoryResource\RelationManagers;

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


class SubcategoryResource extends Resource
{
    protected static ?string $model = Subcategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup='Productos';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
               Card::make()->schema([
                    TextInput::make('nombre')->required()
                                           ->unique(ignoreRecord:true),
                    TextInput::make('slug')->required()
                                           ->unique(ignoreRecord:true),
                    Select::make('category_id')->label('Categoria')
    ->options(Category::all()->pluck('nombre', 'id'))
    ->searchable()
                                           ])



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              
                TextColumn::make('id')->sortable(),
                TextColumn::make('nombre')->sortable()->searchable(),
                TextColumn::make('category.nombre')->sortable()->searchable(),

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
            'index' => Pages\ManageSubcategories::route('/'),
        ];
    }    
}
