<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Rental Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('rental_id')->relationship('rental', 'agreement_no')->required()->label('Rental Agreement')->required()->searchable()->preload(),

                Select::make('payment_method')
                    ->options([
                        'cash' => 'Cash',
                        // 'gcash' => 'GCash',
                        // 'paymaya' => 'PayMaya',
                        // 'card' => 'Card',
                    ])
                    ->required()
                    ->label('Payment Method')->default('cash'),

                    TextInput::make('amount')->numeric()->required()->label('Amount')->prefix('₱')->minValue(0),

                    TextInput::make('transaction_reference')->label('Reference Number')->maxLength(255),
                    Select::make('status')->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ])->default('pending')->required()->label('Status'),
            ]);
    }

   public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('rental.agreement_no')
                ->label('Agreement No.')
                ->sortable()
                ->searchable(),

            TextColumn::make('rental.user.name')
                ->label('Name')
                ->sortable()
                ->searchable(),

            TextColumn::make('payment_method')->badge()->sortable(),

            TextColumn::make('amount')
                ->money('PHP', true)
                ->sortable()
                ->label('Amount'),

            TextColumn::make('transaction_reference')
                ->label('Reference No.')
                ->sortable()
                ->searchable(),

            BadgeColumn::make('status')
                ->colors([
                    'warning' => 'pending',
                    'success' => 'completed',
                    'danger' => 'failed',
                ])
                ->sortable()
                ->searchable(),

            TextColumn::make('created_at')
                ->dateTime('M d, Y h:i A')
                ->label('Paid At')
                ->sortable(),
        ])
        ->filters([
            //
        ])
        ->actions([
            ActionGroup::make([
                Tables\Actions\Action::make('receipt')
                    ->label('Download Receipt')
                    ->url(fn ($record) => route('payments.receipt', $record->id))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document-arrow-down'),

                EditAction::make(),
                DeleteAction::make(),
            ]),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'success' : 'danger';
    }
}
