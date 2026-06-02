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
        if ($this->effectiveRoleName() === 'Admin') return true;

        return match ($this->position?->code) {
            'PP' => in_array($feature, ['dashboard', 'senarai_inden', 'pengesahan_inden']),
            'PR' => in_array($feature, ['dashboard', 'senarai_inden', 'penerimaan_inden']),
            'PS' => in_array($feature, ['dashboard', 'senarai_inden', 'borang_inden']),
            default => false,
        };
    }

    public function landingRouteName(): string
    {
        $this->loadMissing(['role', 'position']);

        $positionCode = strtoupper($this->getPositionCode());
        $positionName = strtolower($this->getPositionName());

        return match (true) {
            $this->isPengarahNegeriAdmin($positionCode, $positionName)
                => 'pengarah.negeri.dashboard',
            $this->isPengarahInstitusiAdmin($positionCode, $positionName)
                => 'pengarah.institusi.dashboard',
            $this->role?->role_name === 'admin hq' || $positionCode === 'ADHQ'
                => 'admin.dashboard',
            default
                => 'user.dashboard',
        };
    }

    public function effectiveRoleName(): string
    {
        $this->loadMissing(['role', 'position']);

        $positionCode = strtoupper($this->getPositionCode());
        $positionName = strtolower($this->getPositionName());

        if (
            $this->role?->role_name === 'admin hq' ||
            $positionCode === 'ADHQ' ||
            $this->isPengarahInstitusiAdmin($positionCode, $positionName) ||
            $this->isPengarahNegeriAdmin($positionCode, $positionName)
        ) {
            return 'Admin';
        }

        return $this->role?->role_name ?? 'User';
    }

    public function getPositionCode(): string
    {
        return $this->position?->code ?? '';
    }

    public function getPositionName(): string
    {
        return $this->position?->name ?? '';
    }

    private function isPengarahInstitusiAdmin(string $positionCode, string $positionName): bool
    {
        return in_array($positionCode, ['ADI', 'P006'], true)
            || str_contains($positionName, 'pengarah institusi')
            || str_contains($positionName, 'admin institusi');
    }

    private function isPengarahNegeriAdmin(string $positionCode, string $positionName): bool
    {
        return in_array($positionCode, ['ADN', 'P007'], true)
            || str_contains($positionName, 'pengarah negeri')
            || str_contains($positionName, 'admin negeri');
    }
}
