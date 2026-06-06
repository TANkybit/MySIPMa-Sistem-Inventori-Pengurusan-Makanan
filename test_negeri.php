<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Mula Kemas Kini Database ===\n\n";

// 1. Daftarkan Jawatan Pengarah Negeri
$position = App\Models\Position::firstOrCreate(
    ['code' => 'ADN'],
    ['name' => 'Pengarah Negeri']
);
echo "Jawatan: [{$position->id}] {$position->name} (ADN)\n";

// 2. Cari Role pertama yang ada
$role = App\Models\Role::first();
if (!$role) {
    echo "RALAT: Tiada Role dalam database.\n";
    exit;
}
echo "Role: [{$role->id}] {$role->name}\n";

// 3. Cari Negeri Kedah
$stateKedah = App\Models\State::where('name', 'like', '%Kedah%')->first();
if ($stateKedah) {
    echo "Negeri Kedah: [{$stateKedah->id}] {$stateKedah->name}\n";
} else {
    echo "AMARAN: Negeri Kedah tidak dijumpai. Cuba gunakan negeri lain...\n";
    $stateKedah = App\Models\State::first();
    if ($stateKedah) {
        echo "Guna negeri pertama: [{$stateKedah->id}] {$stateKedah->name}\n";
    }
}

// 4. Cari institusi yang ada pesanan aktif
$institutionIdsWithOrders = App\Models\Order::select('institution_id')
    ->whereNotNull('institution_id')
    ->distinct()
    ->pluck('institution_id')
    ->toArray();

echo "\nInstitusi dengan pesanan: " . implode(', ', $institutionIdsWithOrders) . "\n";

// 5. Kemas kini institution state_id untuk institusi yang ada pesanan
$updatedCount = 0;
if ($stateKedah && count($institutionIdsWithOrders) > 0) {
    // Hanya kemas kini yang belum ada state_id
    $updatedCount = App\Models\Institution::whereIn('id', $institutionIdsWithOrders)
        ->whereNull('state_id')
        ->update(['state_id' => $stateKedah->id]);
    echo "Institusi dikemas kini state_id: {$updatedCount} rekod\n";

    // Tunjuk senarai institusi tersebut
    $institutions = App\Models\Institution::whereIn('id', $institutionIdsWithOrders)->get(['id', 'name', 'state_id']);
    foreach ($institutions as $inst) {
        echo "  - [{$inst->id}] {$inst->name} (state_id: {$inst->state_id})\n";
    }
}

// 6. Pilih satu institusi dari negeri terkait untuk ditetapkan kepada akaun ujian
$testInstitution = App\Models\Institution::whereIn('id', $institutionIdsWithOrders)
    ->where('state_id', $stateKedah ? $stateKedah->id : null)
    ->first();

if (!$testInstitution) {
    $testInstitution = App\Models\Institution::first();
}
echo "\nInstitusi untuk akaun ujian: [{$testInstitution->id}] {$testInstitution->name}\n";

// 7. Cipta/kemas kini akaun Pengarah Negeri ujian
$user = App\Models\User::firstOrCreate(
    ['email' => 'pengarah.negeri@example.com'],
    [
        'name'           => 'Dato Pengarah Negeri',
        'password'       => \Hash::make('password'),
        'institution_id' => $testInstitution->id,
        'position_id'    => $position->id,
        'role_id'        => $role->id,
        'phone_number'   => '012-3456789',
        'status'         => 1,
    ]
);

// Kemas kini jika sudah wujud
$user->update([
    'password'       => \Hash::make('password'),
    'position_id'    => $position->id,
    'institution_id' => $testInstitution->id,
    'status'         => 1,
]);

echo "\n=== Akaun Ujian Pengarah Negeri ===\n";
echo "Email    : {$user->email}\n";
echo "Password : password\n";
echo "Negeri   : " . ($stateKedah ? $stateKedah->name : '-') . "\n";
echo "Institusi: {$testInstitution->name}\n";
echo "\n=== Selesai ===\n";
