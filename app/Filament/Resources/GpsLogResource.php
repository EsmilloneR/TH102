<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GpsLogResource\Pages;
use App\Filament\Resources\GpsLogResource\Widgets\VehicleMapWidget;
use App\Models\GpsLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GpsLogResource extends Resource
{
    protected static ?string $model = GpsLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Car Log';
    protected static ?string $navigationGroup = 'Tracking';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('vehicle_id')
                    ->relationship('vehicle', 'model')
                    ->searchable()
                    ->required()->preload()->searchable()->getOptionLabelFromRecordUsing(fn ($record) => "{$record->make} {$record->model} {$record->year}"),

                Forms\Components\TextInput::make('latitude')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('longitude')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('speed')
                    ->numeric()
                    ->label('Speed (km/h)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vehicle.model')
                    ->label('Car')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('latitude')
                    ->sortable(),

                Tables\Columns\TextColumn::make('longitude')
                    ->sortable(),

                Tables\Columns\TextColumn::make('speed')
                    ->label('Speed (km/h)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Logged At')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGpsLogs::route('/'),
            'create' => Pages\CreateGpsLog::route('/create'),
            'edit' => Pages\EditGpsLog::route('/{record}/edit'),
        ];
    }

}
