<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CustomerResource\Pages;
use App\Models\Customer;
use App\Models\States\Status\Active;
use App\Models\States\Status\Inactive;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Customers Management';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'phone', 'uid'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('Phone')
                    ->tel(),
                Forms\Components\TextInput::make('uid')
                    ->label('UID')
                    ->required(),
                Forms\Components\TextInput::make('balance')
                    ->label('Balance')
                    ->prefix('Rp. ')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->searchable()
                    ->preload()
                ->default(Active::$name)
                    ->options([
                        Active::$name => Active::$name,
                        Inactive::$name => Inactive::$name
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uid')
                    ->label('UID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->label('Balance')
                    ->searchable(),
              Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                  ->icon(fn (string $state): string => match ($state) {
                      'active' => 'heroicon-o-check-circle',
                      'inactive' => 'heroicon-o-x-circle',
                  })
                ->color( fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'inactive' => 'danger',
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\BulkAction::make('Active')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (Collection $records) => $records->each->update(['status' => Active::$name])),
                Tables\Actions\BulkAction::make('Inactive')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn (Collection $records) => $records->each->update(['status' => Inactive::$name])),
                Tables\Actions\DeleteBulkAction::make(),
            ])->defaultSort('created_at', 'desc');
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
            'index' => \App\Filament\Admin\Resources\CustomerResource\Pages\ListCustomers::route('/'),
            'create' => \App\Filament\Admin\Resources\CustomerResource\Pages\CreateCustomer::route('/create'),
//            'edit' => \App\Filament\Admin\Resources\CustomerResource\Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
