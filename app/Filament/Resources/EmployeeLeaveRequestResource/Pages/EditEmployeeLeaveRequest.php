<?php

namespace App\Filament\Resources\EmployeeLeaveRequestResource\Pages;

use App\Filament\Resources\EmployeeLeaveRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;
use Auth;
use Log;

class EditEmployeeLeaveRequest extends EditRecord
{
    protected static string $resource = EmployeeLeaveRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        if ($this->record->wasChanged('status')) {
            $employee = $this->record->employee;
            if ($this->record->employee->department->leave_slack_hook != null) {
                try {
                    $data = [
                        "text" =>
                            "<!channel> \n" .
                            "Requestor: *" . $employee->name . "* \n" .
                            "When: *" . $this->record->start_date . " to " . $this->record->end_date . "* \n" .
                            "Status: *" . $this->record->status . "* \n" . 
                            "Shift: " . $this->record->shift . "\n" .
                            "Leave Type: " . $this->record->leaveType->name . "\n" .
                            "Reason: " . $this->record->remarks . "\n" .
                            "Approved By: " . Auth::user()->name
                    ];
                    $hook = $employee->department->leave_slack_hook;
                    $response = Http::post($hook, $data);
                } catch (Exception $e) {
                    Log::info($e);
                }
            }
        }
    }
}
