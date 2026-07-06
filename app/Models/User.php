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
        $positionCode = strtoupper($this->getPositionCode());

        if (in_array($this->role_id, [1, 2, 3]) || $this->role?->role_name === 'admin hq' || $this->role?->role_name === 'Admin' || in_array($positionCode, ['ADHQ', 'ADN', 'ADI', 'P001'], true)) {
            return in_array($feature, ['view_order_only', 'penilaian_prestasi']);
        }

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

        return match (true) {
            $this->role_id == 2 || $positionCode === 'ADN'
                => 'pengarah.negeri.dashboard',
            $this->role_id == 3 || $positionCode === 'ADI'
                => 'pengarah.institusi.dashboard',
            $this->role_id == 1 || $positionCode === 'ADHQ' || $this->role?->role_name === 'admin hq'
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

        $this->_effRole = match (true) {
            $this->role_id == 1 || $this->role_id == 2 || $this->role_id == 3
                => 'Admin',
            in_array($positionCode, ['ADHQ', 'ADN', 'ADI'], true)
                => 'Admin',
            $this->role?->role_name === 'admin hq'
                => 'Admin',
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

}
