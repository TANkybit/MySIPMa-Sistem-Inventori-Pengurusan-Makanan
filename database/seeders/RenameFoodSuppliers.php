<?php
chdir('C:/laragon/www/MySIPMA_2');
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$map = [
    1 => 'Maju Bahan Makanan Sdn. Bhd.',
    2 => 'Cemerlang Runcit Makanan (M) Sdn. Bhd.',
    3 => 'Aman Jaya Food Trading Sdn. Bhd.',
    4 => 'Johor Fresh Food Supply Sdn. Bhd.',
    5 => 'Mega Food Distributor (Kluang) Sdn. Bhd.',
    6 => 'Pertama Food Industries Sdn. Bhd.',
    7 => 'Pertubuhan Peladang Kebangsaan',
    8 => 'Kilang Beras Othman Jusoh Bersaudara (M) Sdn. Bhd.',
];

foreach ($map as $id => $name) {
    $updated = \Illuminate\Support\Facades\DB::table('suppliers')
        ->where('id', $id)
        ->update([
            'company_name' => $name,
            'updated_at' => now(),
            'updated_by' => 1,
        ]);
    echo "supplier#$id -> $name (" . ($updated ? 'OK' : 'NO ROW') . ")\n";
}

echo "\n=== VERIFY ===\n";
foreach (\Illuminate\Support\Facades\DB::table('suppliers')->orderBy('id')->get(['id', 'company_name']) as $s) {
    echo "id={$s->id} {$s->company_name}\n";
}