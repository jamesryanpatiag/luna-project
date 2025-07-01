<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class TimeInTimeOutData extends Model
{
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
    ];

    /**
     *
     * @return BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }
}
