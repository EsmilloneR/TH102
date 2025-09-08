<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $recordTitleAttribute = 'name';
    protected static int $globalSearchResultsLimit = 10;

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        Section::make('Rental Identification')->schema([
                TextInput::make('name')
                ->required()
                ->maxLength(100),


            TextInput::make('email')
                ->email()
                ->required()
                ->unique('users', 'email', ignoreRecord: true)
                ->maxLength(150),

            TextInput::make('phone_number')
                ->tel()
                ->required()
                ->maxLength(length: 20),
            Select::make('role')
                ->label('User Role')
                ->options([
                    'renter' => 'Renter',
                    'admin' => 'Admin',
                ])
                ->required(),
            TextInput::make('nationality')
            ->maxLength(50),

            Textarea::make('address')->columnSpanFull(),
        ])->columns(2),

            Section::make('Valid ID')->schema([
                Select::make('id_type')
                ->options([
                    'passport' => 'Passport',
                    'driver_license' => 'Driver License',
                    'national_id' => 'National ID',
                    'others' => 'Others'
                ])->label('ID Type')->required(),

            TextInput::make('id_number')
                ->maxLength(128)->label('ID Number')->required(),

            FileUpload::make('id_pictures')->directory('customers')->multiple()->reorderable()->maxFiles(2)->appendFiles()->label('ID Pictures - Front / Back')->required(),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    // ImageColumn::make('avatar')
                    //     ->circular(),
                    Stack::make([
                        TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->searchable()
                        ->sortable(),
                        TextColumn::make('role')->searchable()->sortable()->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state))),
                    ]),
                    Stack::make([
                        TextColumn::make('phone_number')
                            ->icon('heroicon-m-phone'),
                        TextColumn::make('email')
                            ->icon('heroicon-m-envelope'),
                    ]),
                ])
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
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
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'role'];
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
