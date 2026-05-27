<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'institution_id',
        'role_id',
        'position_id',
        'name',
        'email',
        'phone_number',
        'password',
        'image',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'status' => 'boolean',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission(string $feature): bool
    {
        if ($this->role?->role_name === 'Admin') return true;

        return match ($this->position?->code) {
            'PP' => in_array($feature, ['dashboard', 'senarai_inden', 'pengesahan_inden']),
            'PR' => in_array($feature, ['dashboard', 'senarai_inden', 'penerimaan_inden']),
            'PS' => in_array($feature, ['dashboard', 'senarai_inden', 'borang_inden']),
            default => false,
        };
    }

    public function getPositionCode(): string
    {
        return $this->position?->code ?? '';
    }

    public function getPositionName(): string
    {
        return $this->position?->name ?? '';
    }
}
