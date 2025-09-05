<?php

namespace App\Filament\Resources\InspectionResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InspectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'inspections';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->options([
                        'out' => 'Check Out (Before)',
                        'in'  => 'Check In (After)',
                    ])
                    ->required()
                    ->label('Inspection Type'),

                TextInput::make('odometer')
                    ->numeric()
                    ->suffix(' km')
                    ->label('Odometer'),

                TextInput::make('fuel_level')
                    ->numeric()
                    ->suffix('%')
                    ->label('Fuel Level'),

                FileUpload::make('photos')
                    ->multiple()
                    ->image()
                    ->directory('inspections')
                    ->columnSpanFull()
                    ->label('Photos'),

                Textarea::make('condition_notes')
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->label('Condition Notes'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'warning' => 'check_out',
                        'success' => 'check_in',
                    ])
                    ->label('Type'),

                TextColumn::make('odometer')
                    ->suffix(' km')
                    ->sortable(),

                TextColumn::make('fuel_level')
                    ->suffix('%')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('M d, Y h:i A')
                    ->label('Inspected At')
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
