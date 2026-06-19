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

    private ?string $_effRole = null;
    private array $_permCache = [];

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
        if (isset($this->_permCache[$feature])) return $this->_permCache[$feature];

        $result = $this->computePermission($feature);

        $this->_permCache[$feature] = $result;
        return $result;
    }

    private function computePermission(string $feature): bool
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
            $this->isAdminInstitusi($positionCode, $positionName)
                => 'admin.institusi.dashboard',
            $this->isPengarahInstitusiAdmin($positionCode, $positionName)
                => 'pengarah.institusi.dashboard',
            $this->role?->role_name === 'admin hq' || in_array($positionCode, ['ADHQ', 'P001'], true) || $this->role_id == 1
                => 'admin.dashboard',
            default
                => 'user.dashboard',
        };
    }

    public function effectiveRoleName(): string
    {
        if ($this->_effRole !== null) return $this->_effRole;

        $this->loadMissing(['role', 'position']);

        $positionCode = strtoupper($this->getPositionCode());
        $positionName = strtolower($this->getPositionName());

        $this->_effRole = match (true) {
            $this->role?->role_name === 'admin hq',
            $this->role_id === 1 || $this->role_id === '1',
            in_array($positionCode, ['ADHQ', 'P001'], true),
            $this->isAdminInstitusi($positionCode, $positionName),
            $this->isPengarahInstitusiAdmin($positionCode, $positionName),
            $this->isPengarahNegeriAdmin($positionCode, $positionName) => 'Admin',
            default => $this->role?->role_name ?? 'User',
        };

        return $this->_effRole;
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
        $posName = strtolower($positionName);
        $userName = strtolower($this->name);
        
        return in_array($positionCode, ['ADI', 'P006'], true)
            || str_contains($posName, 'pengarah institusi')
            || (
                   (str_contains($posName, 'pengarah') || str_contains($userName, 'pengarah'))
                   && !str_contains($posName, 'negeri') && !str_contains($userName, 'negeri')
                   && !str_contains($posName, 'hq') && !str_contains($userName, 'hq')
                   && !str_contains($userName, 'utama')
               );
    }

    private function isAdminInstitusi(string $positionCode, string $positionName): bool
    {
        return str_contains($positionName, 'admin institusi');
    }

    private function isPengarahNegeriAdmin(string $positionCode, string $positionName): bool
    {
        return in_array($positionCode, ['ADN', 'P007'], true)
            || str_contains($positionName, 'pengarah negeri')
            || str_contains($positionName, 'admin negeri');
    }
}
