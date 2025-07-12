<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Employee;

class ValidateIfEmployeeExist implements ValidationRule
{
    private $lastName;

    public function __construct($lastName) {
        $this->lastName = $lastName;
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
        }
    }
}
