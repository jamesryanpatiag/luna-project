<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequestApprover extends Model
{
    protected $fillable = [
        'user_id',
        'department_id'
    ];

    /**
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     *
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
