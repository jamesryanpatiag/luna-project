<?php

namespace App\Filament\Resources\EmployeeLeaveRequestResource\Pages;

use App\Filament\Resources\EmployeeLeaveRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeLeaveRequest extends CreateRecord
{
    protected static string $resource = EmployeeLeaveRequestResource::class;
}
