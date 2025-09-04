<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Fleet Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Vehicle Details')
                    ->schema([
                        TextInput::make('make')->required()->maxLength(100),
                        TextInput::make('model')->required()->maxLength(100),
                        TextInput::make('year')->numeric()->minValue(1900)->maxValue(date('Y') + 1),
                        TextInput::make('licensed_number')->required()->unique(ignoreRecord: true)->label('License Plate Number'),
                        TextInput::make('color')->maxLength(50),
                        Forms\Components\Select::make('transmission')
                            ->options([
                                'automatic' => 'Automatic',
                                'manual' => 'Manual',
                            ])
                            ->required(),
                        TextInput::make('seats')->numeric()->minValue(2)->maxValue(20),
                    ])->columns(2),

                Section::make('Rates')
                    ->schema([
                       TextInput::make('rate_hour')->numeric()->prefix('₱'),
                       TextInput::make('rate_day')->numeric()->prefix('₱'),
                       TextInput::make('rate_week')->numeric()->prefix('₱'),
                    ])->columns(3),

                Toggle::make('active')->label('Available for rental')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('make')->sortable()->searchable(),
                TextColumn::make('model')->sortable()->searchable(),
                TextColumn::make('year')->sortable(),
                TextColumn::make('licensed_number')->sortable()->searchable(),
                TextColumn::make('color'),
                TextColumn::make('transmission'),
                TextColumn::make('seats'),
                IconColumn::make('active')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('active'),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
