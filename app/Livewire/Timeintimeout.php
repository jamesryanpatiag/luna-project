<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeInTimeOutData;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Rules\ValidateUserByEmpNumAndLastNameRule;
use Log;
use Exception;

class Timeintimeout extends Component
{
    public $employeeNumber;
    public $lastname;
    public $type;
    public $notes;

    public function render()
    {
        return view('livewire.timeintimeout')
        ->title('Time-In/Time-Out');
    }

    public function in() {
        $validate = $this->validate(
            [
                'employeeNumber'    => ['required', new ValidateUserByEmpNumAndLastNameRule($this->lastname,'in')],
                'lastname'          => ['required']
            ]
        );
        $employee = Employee::query()->whereRaw('lower(last_name) = ?', strtolower($this->lastname))->where('contractor_id_number', $this->employeeNumber)->first();

        $userTimeIn = new TimeInTimeOutData();
        $userTimeIn->user_id = $employee->id;
        $userTimeIn->start_time = Carbon::now();
        $userTimeIn->notes = $this->notes ?? '';
        $userTimeIn->save();

        $this->lastname = '';
        $this->employeeNumber = '';
        $this->notes;

        try {
            if ($this->notes != null) {
                $data = [
                    'text' => "Time-in: " . $employee->first_name . " " . $employee->last_name . " \n[" . Carbon::now('Asia/Manila') . "] : (" . $this->notes . ")"
                ];
            } else {
                $data = [
                    'text' => "Time-in: " . $employee->first_name . " " . $employee->last_name . " \n[" . Carbon::now('Asia/Manila') . "]"
                ];
            }            

            $hook = $employee->department->slack_hook;
            $response = Http::post($hook, $data);

        } catch (\Exception $e) {
            //
        }

        session()->flash('message', 'Time-in Success.');

    }

    public function out() {
        $validate = $this->validate(
            [
                'employeeNumber'    => ['required', new ValidateUserByEmpNumAndLastNameRule($this->lastname,'out')],
                'lastname'          => ['required']
            ]
        );

        $employee = Employee::query()
                    ->whereRaw('lower(last_name) =  ?', strtolower($this->lastname))->where('contractor_id_number', $this->employeeNumber)->first();

        $lastData = TimeInTimeOutData::where('user_id', $employee->id)->orderByDesc('id')->first();
        $lastData->end_time = Carbon::now();
        $lastData->checkout_notes = $this->notes ?? '';
        $lastData->save();

        $this->lastname = '';
        $this->employeeNumber = '';
        $this->notes;

        try {
            if ($this->notes != null) {
                $data = [
                    'text' => "Time-out: " . $employee->first_name . " " . $employee->last_name . " \n[" . Carbon::now('Asia/Manila') . "] : (" . $this->notes . ")"
                ];
            } else {
                $data = [
                    'text' => "Time-out: " . $employee->first_name . " " . $employee->last_name . " \n[" . Carbon::now('Asia/Manila') . "]"
                ];
            }
            $hook = $employee->department->slack_hook;
            $response = Http::post($hook, $data);
            
        } catch (\Exception $e) {
            //
        }

        session()->flash('message', 'Time-out Success.');

    }
}
