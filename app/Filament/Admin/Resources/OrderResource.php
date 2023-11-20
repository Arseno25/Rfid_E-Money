<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Product;
use App\Models\States\OrderStatus\Failed;
use App\Models\States\OrderStatus\Success;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Shop';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', Failed::$name)->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('status', Failed::$name)->count() > 0 ? 'danger' : 'primary';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['customer.name', 'price'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state){
                        if ($state !== null) {
                            $product = Product::find($state);
                            return $set('price', $product->price) ?? $set('total', $product->price);
                        }
                        return $set('total', null) ?? $set('price', null);
                    })
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->default(0)
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state){
                     if ($state <= 0) {
                         return $set('total', $get('price'));
                     }
                         $set('total', $state * $get('price'));
                    }
                    )
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->reactive()
                    ->afterStateUpdated(fn (Get $get, Set $set, ?string $state) => $set('total', $state))
                    ->required(),
                Forms\Components\TextInput::make('total')
                    ->readOnly()
                    ->label('Total')
                    ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.category.name')
                    ->label('Category'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Success::$name => 'success',
                        Failed::$name => 'danger',
                        default => 'primary',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedbulkActions([
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
            'index' => \App\Filament\Admin\Resources\OrderResource\Pages\ListOrders::route('/'),
//            'create' => \App\Filament\Admin\Resources\OrderResource\Pages\CreateOrder::route('/create'),
//            'edit' => \App\Filament\Admin\Resources\OrderResource\Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}