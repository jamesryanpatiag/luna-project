<?php

namespace App\Filament\Resources\TimeInTimeOutDataResource\Pages;

use App\Filament\Resources\TimeInTimeOutDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimeInTimeOutData extends ListRecords
{
    protected static string $resource = TimeInTimeOutDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
