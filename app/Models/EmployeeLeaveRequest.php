<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'remarks',
        'is_approve'
    ];
}
