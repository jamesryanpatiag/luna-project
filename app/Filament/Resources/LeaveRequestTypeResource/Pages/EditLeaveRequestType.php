<?php

namespace App\Filament\Resources\LeaveRequestTypeResource\Pages;

use App\Filament\Resources\LeaveRequestTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeaveRequestType extends EditRecord
{
    protected static string $resource = LeaveRequestTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
