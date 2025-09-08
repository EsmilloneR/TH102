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
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
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

                    Select::make('user_id')->relationship('user', 'name', modifyQueryUsing: fn ($query) => $query->where('role', 'renter'))->required()->searchable()->preload(),

                    Select::make('vehicle_id')
                    ->label('Vehicle')
                    ->relationship(
                        name: 'vehicle',
                        titleAttribute: 'model',
                        modifyQueryUsing: function ($query, callable $get) {
                            $start = $get('rental_start');
                            $end   = $get('rental_end');

                            if ($start && $end) {
                                $query->whereDoesntHave('rentals', function ($q) use ($start, $end) {
                                    $q->whereIn('status', ['reserved', 'ongoing']) // only block active rentals
                                    ->where(function ($q2) use ($start, $end) {
                                        $q2->whereBetween('rental_start', [$start, $end])
                                            ->orWhereBetween('rental_end', [$start, $end])
                                            ->orWhere(function ($q3) use ($start, $end) {
                                                $q3->where('rental_start', '<=', $start)
                                                    ->where('rental_end', '>=', $end);
                                            });
                                    });
                                });
                            }
                        }
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->make} {$record->model} {$record->year}")
                    ->required()
                    ->searchable()
                    ->preload(),


                    DateTimePicker::make('rental_start')->label('Start Date/Time')->required(),
                    DateTimePicker::make('rental_end')->label('End Date/Time')->required(),

                    TextInput::make('pickup_location')->maxLength(150)->required(),
                    TextInput::make('dropoff_location')->maxLength(150)->required(),

                    Select::make('trip_type')->options(['pickup_dropoff' => 'Pick Up & Drop Off Only', 'hrs' => 'Hour/s', 'roundtrip' => 'Round Trip Only (10hrs max)', '24hrs' => '24 Hours', 'days' => 'Days', 'week' => 'Week/weeks', 'month' => 'Month/months'])->required(),
                    TextInput::make('agreement_no')
                    ->disabled()
                    ->default(function () {
                        $date = now()->format('Ymd');
                        $count = Rental::whereDate('created_at', now())->count() + 1;
                        return 'AGR-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
                    }),
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
            ->columns([
                Split::make([
                    Stack::make([
                        TextColumn::make('user.name')->label('Renter')->searchable()->sortable(),
                        TextColumn::make('agreement_no')->weight('bold')->searchable()->sortable(),
                    ]),
                    Stack::make([
                        TextColumn::make('vehicle.make')
                            ->label('Vehicle')
                            ->getStateUsing(fn ($record) => "{$record->vehicle->make} {$record->vehicle->model}")
                            ->searchable()
                            ->sortable(),
                        TextColumn::make('vehicle.licensed_number')->label('Licensed Number')->searchable()->sortable(),
                    ]),
                    Stack::make([
                        TextColumn::make('status')
                            ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state)))
                            ->searchable()
                            ->sortable(),
                        TextColumn::make('total')->money('php'),
                    ]),
                    Stack::make([
                        TextColumn::make('rental_start')->dateTime()->label('Start')->sortable(),
                        TextColumn::make('rental_end')->dateTime()->label('End')->sortable(),
                    ]),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
