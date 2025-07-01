<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Employee;
use App\Models\TimeInTimeOutData;
use Log;

class ValidateUserByEmpNumAndLastNameRule implements ValidationRule
{
    private $lastName;
    private $type;

    public function __construct($lastName, $type) {
        $this->lastName = $lastName;
        $this->type = $type;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = Employee::query()
                    ->whereRaw('lower(last_name) = ?', strtolower($this->lastName))->where('contractor_id_number', $value)->first();
        
        if (!$data) {
            $fail("Employee doesn't exist!");
        } else {
            $lastData = TimeInTimeOutData::where('user_id', $data->id)->orderByDesc('id')->first();

            if (!$lastData) {

                if ($this->type == "out") {
                    $fail("Time-in first before timing out");
                }
                
            } else {
    
                if ($lastData->end_time == null && $this->type == "in") {
                    $fail("You are already timed in. Time-out first before timing in again.");
                }

                if ($lastData->end_time != null && $this->type == "out") {
                    $fail("You are already timed out. Time-in first before timing out again.");
                }
    
            }
        }
    }
}
