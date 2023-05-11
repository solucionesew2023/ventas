<?php
namespace App\Filament\Resources;
use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    // lineas para los iconos
    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup='Admin Management';


    public static function form(Form $form): Form
    {
        //aqui agregamoos un nuevo permiso
        return $form
            ->schema([
               Card::make()
               ->schema([
                TextInput::make('name')
                ->unique()
                ->required()
               ])
            ]);
    }

    public static function table(Table $table): Table
    {
        //listamos todos los permisos, con esta propiedad generamos campo de busqueda sortable()->searchable(),
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->searchable(),

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
            'index' => Pages\ManagePermissions::route('/'),
        ];
    }    
}
