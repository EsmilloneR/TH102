<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Customer Management';

    protected static ?int $navigationSort = 2;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('first_name')
                ->required()
                ->maxLength(100),

            TextInput::make('last_name')
                ->required()
                ->maxLength(100),

            TextInput::make('email')
                ->email()
                ->required()
                ->unique('customers', 'email', ignoreRecord: true)
                ->maxLength(150),

            TextInput::make('phone')
                ->tel()
                ->required()
                ->maxLength(20),

            Textarea::make('address')
                ->rows(2),

            TextInput::make('nationality')
                ->maxLength(50),

            Select::make('id_type')
                ->options([
                    'passport' => 'Passport',
                    'driver_license' => 'Driver License',
                    'national_id' => 'National ID',
                ]),

            TextInput::make('id_number')
                ->maxLength(50),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Full Name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable()->label('User Email'),
                TextColumn::make('phone'),
                TextColumn::make('nationality'),
                TextColumn::make('id_type')->label('ID Type'),
                TextColumn::make('id_number')->label('ID No.'),
            ])
            ->filters([
                SelectFilter::make('id_type')
                    ->options([
                        'driver_license' => 'Driver’s License',
                        'passport' => 'Passport',
                        'national_id' => 'National ID',
                        'others' => 'Others',
                    ]),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
