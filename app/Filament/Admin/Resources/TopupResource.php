<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TopupResource\Pages;
use App\Filament\Admin\Resources\TopupResource\RelationManagers;
use App\Models\Customer;
use App\Models\Topup;
use AymanAlhattami\FilamentDateScopesFilter\DateScopeFilter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TopupResource extends Resource
{
    protected static ?string $model = Topup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Topup';

    protected static ?string $navigationGroup = 'Customers Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->required()
                            ->preload()
                            ->options(Customer::all()->pluck('name', 'id'))
                            ->searchable()
                            ->relationship('customer', 'name'),
                        Forms\Components\TextInput::make('balance')
                            ->label('Balance')
                            ->prefix('Rp. ')
                            ->numeric()
                            ->required(),
                    ])->columns(1);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('balance')
                    ->label('Balance')
                    ->prefix('Rp. ')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y H:i:s'),
            ])
            ->filters([
                DateScopeFilter::make('created_at')
                    ->label('Created At'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
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
            'index' => Pages\ListTopups::route('/'),
//            'create' => Pages\CreateTopup::route('/create'),
//            'edit' => Pages\EditTopup::route('/{record}/edit'),
//        'view' => Pages\ViewTopup::route('/{record}'),
        ];
    }
}
