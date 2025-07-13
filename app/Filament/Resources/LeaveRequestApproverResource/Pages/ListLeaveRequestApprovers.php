<?php

namespace App\Filament\Resources\LeaveRequestApproverResource\Pages;

use App\Filament\Resources\LeaveRequestApproverResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaveRequestApprovers extends ListRecords
{
    protected static string $resource = LeaveRequestApproverResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
