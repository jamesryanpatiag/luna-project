<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\EmployeeLeaveRequest;
use App\Rules\ValidateIfEmployeeExist;

class Leavefiling extends Component
{
    public $leaveTypes;
    public $shifts;
    public $employeeNumber;
    public $lastname;
    public $leaveType;
    public $startDate;
    public $endDate;
    public $shift;
    public $notes;


    public function mount() {
        $this->leaveTypes = LeaveType::pluck('name', 'id');
        $this->shifts = ['AM', 'PM', 'Full Day'];
    }
    public function render()
    {
        return view('livewire.leavefiling')->title('Leave Filing');
    }

    public function submit() {
        $validate = $this->validate(
            [
                'employeeNumber'    =>  ['required', new ValidateIfEmployeeExist($this->lastname)],
                'lastname'          =>  ['required'],
                'leaveType'         =>  ['required'],
                'startDate'         =>  ['required', 'date', 'after:yesterday'],
                'endDate'           =>  ['required', 'date', 'after_or_equal:startDate'],
                'shift'             =>  ['required'],
                'notes'             =>  ['required']
            ],
            [
                'notes.required'    =>  ['The reason field is required']
            ]
        );

        $employee = Employee::query()->whereRaw('lower(last_name) = ?', strtolower($this->lastname))->where('contractor_id_number', $this->employeeNumber)->first();

        $employeeLeaveRequest = new EmployeeLeaveRequest();
        $employeeLeaveRequest->employee_id = $employee->id;
        $employeeLeaveRequest->leave_type_id = $this->leaveType;
        $employeeLeaveRequest->start_date = $this->startDate;
        $employeeLeaveRequest->end_date = $this->endDate;
        $employeeLeaveRequest->remarks = $this->notes;
        $employeeLeaveRequest->is_approve = false;
        $employeeLeaveRequest->shift = $this->shift;
        $employeeLeaveRequest->save();

        $this->employeeNumber = '';
        $this->lastname = '';
        $this->leaveType = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->shift = '';
        $this->notes = '';

        session()->flash('message', 'Leave filed successfully.');
    }
}
