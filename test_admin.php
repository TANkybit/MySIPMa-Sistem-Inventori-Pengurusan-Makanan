<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Create or Find Position 'Admin Institusi'
$position = App\Models\Position::firstOrCreate(
    ['code' => 'ADMI'],
    ['name' => 'Admin Institusi']
);

// 2. We need an Institution ID, let's use the first one available
$institution = App\Models\Institution::first();

// 3. We need a Role, let's use the Admin role if possible or just User
$role = App\Models\Role::first();

// 4. Create the User
$user = App\Models\User::firstOrCreate(
    ['email' => 'admin.institusi@example.com'],
    [
        'name' => 'Dr. Admin Institusi',
        'password' => \Hash::make('password'),
        'institution_id' => $institution->id,
        'position_id' => $position->id,
        'role_id' => $role->id,
        'phone_number' => '012-3456789',
        'status' => 1,
    ]
);

echo "Dummy user created.\n";
echo "Email: " . $user->email . "\n";
echo "Password: password\n";
