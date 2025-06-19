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
        'first_name',
        'last_name',
        'is_active',
        'email',
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
    public function contractorType()
    {
        return $this->belongsTo(ContractorType::class, 'contractor_type_id');
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class, 'user_id', 'id');
    }
}
