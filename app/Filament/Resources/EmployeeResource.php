<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;


class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Employee Managament';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Relationship')->schema([
                    Select::make('country_id')->relationship('country', 'name')->searchable()->preload()->required(),
                    Select::make('state_id')->relationship('state', 'name')->searchable()->preload()->required(),
                    Select::make('city_id')->relationship('city', 'name')->searchable()->preload()->required(),
                    Select::make('department_id')->relationship('department', 'name')->searchable()->preload()->required(),
                ])->columns(2),
                Section::make('User Name')->description('Put The user Name Detail')->schema([
                    TextInput::make('first_name')->required()->maxLength(255),
                    TextInput::make('last_name')->required()->maxLength(255),
                    TextInput::make('middle_name')->required()->maxLength(255),
                ])->columns(3),
                Section::make('User Address')->schema([
                    TextInput::make('address')->required()->maxLength(255),
                    TextInput::make('zip_code')->required()->maxLength(255),
                ])->columns(2),
                Section::make('Dates')->schema([
                    DatePicker::make('date_of_birth')->required(),
                    DatePicker::make('date_hired')->required(),
                ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
