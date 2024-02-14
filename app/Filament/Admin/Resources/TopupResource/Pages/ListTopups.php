<?php

namespace App\Filament\Admin\Resources\TopupResource\Pages;

use App\Filament\Admin\Resources\TopupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTopups extends ListRecords
{
    protected static string $resource = TopupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
