<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== Mula Pasang order_sequences ===\n";

    DB::statement("
        CREATE TABLE IF NOT EXISTS `order_sequences` (
          `id` bigint UNSIGNED NOT NULL,
          `institution_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
          `category_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
          `year` int NOT NULL,
          `month` int NOT NULL,
          `sequence_no` int NOT NULL DEFAULT '0',
          `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    $keysExist = DB::select("SHOW KEYS FROM `order_sequences` WHERE Key_name = 'PRIMARY'");
    if (empty($keysExist)) {
        DB::statement("
            ALTER TABLE `order_sequences`
              ADD PRIMARY KEY (`id`),
              ADD UNIQUE KEY `uq_order_seq` (`institution_code`,`category_code`,`year`,`month`);
        ");

        DB::statement("
            ALTER TABLE `order_sequences`
              MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
        ");
        
        echo "Kunci dan AUTO_INCREMENT telah dikonfigurasi.\n";
    }

    echo "Selesai. Jadual order_sequences sedia digunakan.\n";

} catch (\Exception $e) {
    echo "Ralat: " . $e->getMessage() . "\n";
}
