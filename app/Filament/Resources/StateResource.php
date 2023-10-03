<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\State;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StateResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StateResource\RelationManagers;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationLabel = 'State';

    protected static ?string $ModelLabel = 'States';

    protected static ?string $navigationGroup = 'System Managament';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('country_id')->relationship('country', 'name')->searchable()->preload()->required(),
                TextInput::make('name')->required()->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('country.name')->sortable()->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('name')->label('State Name')->sortable()->searchable(isIndividual: true)->visible(!auth()->user()->email == 'eko@gmail.com'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('country.name', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }
}
