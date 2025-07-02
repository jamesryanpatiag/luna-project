<?php

namespace App\Filament\Resources\EmployeeLeaveRequestResource\Pages;

use App\Filament\Resources\EmployeeLeaveRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeLeaveRequest extends EditRecord
{
    protected static string $resource = EmployeeLeaveRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
