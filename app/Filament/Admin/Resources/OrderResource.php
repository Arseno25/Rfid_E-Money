<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Widgets\OrderOverview;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\States\OrderStatus\Failed;
use App\Models\States\OrderStatus\Success;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Shop';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::ofToday()->where('status', Failed::$name)->count();
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
                //
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
                    ->icon(fn(string $state): string => match ($state) {
                        Success::$name => 'heroicon-o-check',
                        Failed::$name => 'heroicon-o-x-mark',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        Success::$name => 'success',
                        Failed::$name => 'danger',
                        default => 'primary',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('price')
                    ->prefix('Rp. ')
                    ->label('Price'),
                Tables\Columns\TextColumn::make('price_before_discount')
                    ->prefix('Rp. ')
                    ->label('Total Before Discount'),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->label('Discount')
                    ->prefix('-Rp. '),
                Tables\Columns\TextColumn::make('total')
                    ->prefix('Rp. ')
                    ->label('Total'),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\ViewAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make('table')->fromTable()->withFilename(date('Y-m-d') . ' - export'),
                ])->color('success')->label('Export Exel'),
            ])
            ->groupedbulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Invoices')
                ->icon('heroicon-m-shopping-bag')
                ->schema([
                    TextEntry::make('customer.name')->label('Name'),
                    TextEntry::make('customer.uid')->label('UID'),
                    TextEntry::make('product.name')->label('Product'),
                    TextEntry::make('product.category.name')->label('Category'),
                    TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            Success::$name => 'success',
                            Failed::$name => 'danger',
                            default => 'primary',
                        }),
                    TextEntry::make('quantity')->label('Quantity'),
                    TextEntry::make('price')->label('Price')->prefix('Rp. '),
                    TextEntry::make('price_before_discount')->label('Total Before Discount')->prefix('Rp. '),
                    TextEntry::make('discount_amount')->label('Discount')->prefix('-Rp. '),
                    TextEntry::make('total')->label('Total')->prefix('Rp. '),
                    TextEntry::make('created_at')->label('Payment Time')->dateTime('D, d M Y H:i:s'),
                ])
                    ->columns(3)
                    ->compact(),
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
