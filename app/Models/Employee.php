<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;

class Employee extends Model
{
    protected $fillable = [
        'contractor_id_number',
        'first_name',
        'last_name',
        'is_active',
        'email',
        'department_id',
        'contractor_type_id',
        'contractor_position',
        'date_hired',
        'regularization_date',
        'hmo_active',
        'slack_username',
        'gender',
        'birth_date',
        'contact_number',
        'current_home_address',
        'citizenship',
        'personal_email',
        'marital_status',
        'tin_number',
        'emergency_contact_person',
        'emergency_contact_number',
        'emergency_contact_person_address',
        'relationship_to_emergency_contact',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'email_verified_at',
        'image'
    ];



    /**
     *
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     *
     * @return BelongsTo
     */
    public function contractorType()
    {
        return $this->belongsTo(ContractorType::class, 'contractor_type_id');
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class, 'employee_id', 'id');
    }
}
