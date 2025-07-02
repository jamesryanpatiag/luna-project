<?php

namespace App\Filament\Resources\LeaveRequestTypeResource\Pages;

use App\Filament\Resources\LeaveRequestTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaveRequestTypes extends ListRecords
{
    protected static string $resource = LeaveRequestTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
