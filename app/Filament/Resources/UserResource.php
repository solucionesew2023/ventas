<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Pages\Page;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup='Admin Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_admin')->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord:true),
               
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(static fn(null|string $state):
                                        null|string=>
                                        filled($state)?Hash::make($state):null,
                                         )->required(static fn(Page $livewire): string=>
                                         $livewire instanceof CreateUser,
                                         )->dehydrated(static fn(null|string $state):bool=>
                                         filled($state),
                                         
                                         )->label(static fn(Page $livewire): string =>
                                         ($livewire instanceof EditUser)?'New Password':'Password'
                                         ),
                 CheckboxList::make('roles')
                 ->relationship('roles','name')
                 ->columns(2)
                 ->helperText('Only Choose One!')
                 ->required()   
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean(),
                Tables\Columns\TextColumn::make('roles.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime(),
                    TextColumn::make('deleted_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->searchable(),
                    TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->searchable(),
                
            ])
            ->filters([
                TernaryFilter::make('is_admin')
    ->label('Administrators only?')
    ->indicator('Administrators')
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
