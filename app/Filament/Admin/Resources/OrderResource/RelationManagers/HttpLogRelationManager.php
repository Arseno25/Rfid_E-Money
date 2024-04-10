<?php

namespace App\Filament\Admin\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parallax\FilamentSyntaxEntry\SyntaxEntry;

class HttpLogRelationManager extends RelationManager
{
    protected static string $relationship = 'HttpLog';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
               //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('order_id')
            ->columns([
                Tables\Columns\TextColumn::make('method')
                    ->label('Method')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'GET' => 'success',
                    'POST' => 'primary',
                    default => 'warning',
                }),
                Tables\Columns\TextColumn::make('status_code')
                ->color(fn(string $state): string => match ($state) {
                    '200' => 'success',
                    '400' => 'danger',
                    default => 'primary',
                }),
                Tables\Columns\TextColumn::make('url')
                    ->label('Url'),
                Tables\Columns\TextColumn::make('ip')
                    ->label('Ip'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At'),
            ])
            ->filters([
                //
            ])
//            ->headerActions([
//                Tables\Actions\CreateAction::make(),
//            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('method')
                    ->columnSpanFull(),
                TextEntry::make('status_code'),
                TextEntry::make('url'),
                TextEntry::make('ip'),
                Section::make()
                    ->columns(2)
                    ->schema([

                SyntaxEntry::make('request'),
                    ]),
               SyntaxEntry::make('response')
                   ->columnSpanFull()
                   ->theme('xcode')
                   ->language('json'),
            ]);
    }
}
