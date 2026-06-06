<?php
$file = 'C:\Users\user\Downloads\mysipmac_mysipma2 (4) (1).sql';
$content = file_get_contents($file);
preg_match_all('/CREATE TABLE \`([a-zA-Z0-9_]+)\`/', $content, $matches);
$sql_tables = $matches[1];

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$db_tables = array_map('current', \Illuminate\Support\Facades\DB::select('SHOW TABLES'));

$missing_in_db = array_diff($sql_tables, $db_tables);

echo "Tables in SQL but not in DB:\n";
print_r($missing_in_db);
