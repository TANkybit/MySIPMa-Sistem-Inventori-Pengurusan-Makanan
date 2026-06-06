<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::with(['role', 'position'])->take(15)->get();
foreach ($users as $u) {
    echo str_pad($u->email, 30) . ' | role: ' . str_pad(optional($u->role)->name, 15) . ' | pos: ' . str_pad(optional($u->position)->code, 6) . ' | route: ' . $u->landingRouteName() . "\n";
}
