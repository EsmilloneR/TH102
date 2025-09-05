<?php

namespace App\Filament\Resources;
// use App\Filament\Tables\Actions\ExportAction;
use App\Filament\Exports\RentalExporter;
use App\Filament\Resources\InspectionResource\RelationManagers\InspectionsRelationManager;
use App\Filament\Resources\RentalResource\Pages;
use App\Models\Rental;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RentalResource extends Resource
{
    protected static ?string $model = Rental::class;

     protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Rental Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Rental Information')->schema([

                    Select::make('customer_id')->relationship('customer', 'first_name')->required(),

                    Select::make('vehicle_id')
                    ->relationship('vehicle', fn ($query) => $query->select('id', 'make', 'model'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->make} {$record->model}")
                    ->required(),


                    DateTimePicker::make('rental_start')->label('Start Date/Time')->required(),
                    DateTimePicker::make('rental_end')->label('Start Date/Time')->required(),

                    TextInput::make('pickup_location')->maxLength(150)->required(),
                    TextInput::make('dropoff_location')->maxLength(150)->required(),

                    Select::make('trip_type')->options(['pickup_dropoff' => 'Pick Up & Drop Off Only', 'hrs' => 'Hour/s', 'roundtrip' => 'Round Trip Only (10hrs max)', '24hrs' => '24 Hours', 'days' => 'Days', 'week' => 'Week/weeks', 'month' => 'Month/months'])->required(),
                    TextInput::make('agreement_no')->unique(ignoreRecord: true)->required(),
                ])->columns(2),


                Section::make('Fuel Levels')->schema([
                    TextInput::make('fuel_level_out')->numeric()->suffix('%'),
                    TextInput::make('fuel_level_in')->numeric()->suffix('%')
                ])->columns(2),

                Section::make('Financials')->schema([
                    TextInput::make('base_amount')->numeric()->prefix('₱')->default(0),
                    TextInput::make('deposit')->numeric()->prefix('₱')->default(0),
                    TextInput::make('extra_charges')->numeric()->prefix('₱')->default(0),
                    TextInput::make('penalties')->numeric()->prefix('₱')->default(0),
                ])->columns(3),
                Section::make('Status')->schema([
                    Select::make('status')->options([
                        'reserved' => 'Reserved',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled'
                    ])->default('reserved')->required()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
    Tables\Actions\ExportAction::make()
        ->exporter(RentalExporter::class),
])
            ->columns([
                // Tables\Actions\ExportAction::make()->exporter(RentalExporter::class),

                TextColumn::make('agreement_no')->sortable()->searchable(),
                TextColumn::make('customer.name')->label('Customer')->sortable()->searchable(),
                TextColumn::make('vehicle.licensed_number')->label('Vehicle'),
                TextColumn::make('rental_start')->dateTime(),
                TextColumn::make('rental_end')->dateTime(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'reserved',
                        'info' => 'ongoing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                TextColumn::make('total')->money('php'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

                // ExportBulkAction::make()->exporter(RentalExporter::class)
            ]);

    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'success' : 'danger';
    }

    public static function getRelations(): array
    {
        return [
            InspectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentals::route('/'),
            'create' => Pages\CreateRental::route('/create'),
            'edit' => Pages\EditRental::route('/{record}/edit'),
        ];
    }


}
