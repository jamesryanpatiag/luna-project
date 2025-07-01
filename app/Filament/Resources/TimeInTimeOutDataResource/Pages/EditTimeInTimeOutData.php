<?php

namespace App\Filament\Resources\TimeInTimeOutDataResource\Pages;

use App\Filament\Resources\TimeInTimeOutDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimeInTimeOutData extends EditRecord
{
    protected static string $resource = TimeInTimeOutDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
