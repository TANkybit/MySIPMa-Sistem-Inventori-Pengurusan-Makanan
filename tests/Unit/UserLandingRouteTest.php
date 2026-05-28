<?php

namespace Tests\Unit;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserLandingRouteTest extends TestCase
{
    public function test_admin_negeri_lands_on_pengarah_negeri_dashboard(): void
    {
        $user = $this->userWithPosition('Admin', 'ADN', 'Admin Negeri');

        $this->assertSame('pengarah.negeri.dashboard', $user->landingRouteName());
    }

    public function test_admin_institusi_lands_on_pengarah_institusi_dashboard(): void
    {
        $user = $this->userWithPosition('Admin', 'ADI', 'Admin Institusi');

        $this->assertSame('pengarah.institusi.dashboard', $user->landingRouteName());
    }

    public function test_admin_hq_lands_on_hq_dashboard(): void
    {
        $user = $this->userWithPosition('Admin', 'ADHQ', 'Admin HQ');

        $this->assertSame('admin.dashboard', $user->landingRouteName());
    }

    public function test_regular_user_lands_on_user_dashboard(): void
    {
        $user = $this->userWithPosition('User', 'PS', 'Pegawai Stor');

        $this->assertSame('user.dashboard', $user->landingRouteName());
    }

    public function test_pengarah_institusi_with_user_role_is_treated_as_admin(): void
    {
        $user = $this->userWithPosition('User', 'P006', 'Pengarah Institusi');

        $this->assertSame('pengarah.institusi.dashboard', $user->landingRouteName());
        $this->assertSame('Admin', $user->effectiveRoleName());
        $this->assertTrue($user->hasPermission('borang_inden'));
    }

    private function userWithPosition(string $roleName, string $positionCode, string $positionName): User
    {
        $user = new User();

        $user->setRelation('role', new Role(['role_name' => $roleName]));
        $user->setRelation('position', new Position([
            'code' => $positionCode,
            'name' => $positionName,
        ]));

        return $user;
    }
}
