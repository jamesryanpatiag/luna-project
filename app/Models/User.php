<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\HasName;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use App\Models\Department;
use App\Models\ContractorType;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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
        'password',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@mindnation.com') && $this->hasVerifiedEmail();
    }

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
        return $this->hasMany(UserDocument::class, 'user_id', 'id');
    }
}
