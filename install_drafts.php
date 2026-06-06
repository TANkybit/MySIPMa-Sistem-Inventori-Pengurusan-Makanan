<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Basic CREATE TABLE
    DB::statement("
        CREATE TABLE IF NOT EXISTS `borang_inden_drafts` (
          `id` bigint UNSIGNED NOT NULL,
          `user_id` int NOT NULL,
          `data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Add keys if they don't exist yet
    $keysExist = DB::select("SHOW KEYS FROM `borang_inden_drafts` WHERE Key_name = 'PRIMARY'");
    if (empty($keysExist)) {
        DB::statement("
            ALTER TABLE `borang_inden_drafts`
              ADD PRIMARY KEY (`id`),
              ADD UNIQUE KEY `borang_inden_drafts_user_id_unique` (`user_id`);
        ");

        DB::statement("
            ALTER TABLE `borang_inden_drafts`
              MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
        ");
        
        DB::statement("
            ALTER TABLE `borang_inden_drafts`
              ADD CONSTRAINT `borang_inden_drafts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
        ");
    }

    // Insert data (we should check if user 4 exists, if not maybe just insert the table without the row to prevent FK constraints issues)
    $user4 = DB::table('users')->where('id', 4)->first();
    if ($user4) {
        $exists = DB::table('borang_inden_drafts')->where('id', 2)->first();
        if (!$exists) {
            DB::insert("
                INSERT INTO `borang_inden_drafts` (`id`, `user_id`, `data`, `created_at`, `updated_at`) VALUES
                (2, 4, '{\"contract_id\":\"2\",\"tarikh_pesanan\":\"04/06/2026\",\"masa\":\"16:31\",\"sesi_kod\":\"draf test\",\"institution_id\":\"2\",\"supplier_id\":\"3\",\"wakil_pembekal\":\"Tuan Lee Wei Ming\",\"alamat_pembekal\":\"Wisma Subang, Jln USJ, Subang Jaya 47630\",\"muster_khas_daging\":\"0\",\"muster_ditolak_parol\":\"0\",\"parol\":\"0\",\"muster_penuh\":\"0\",\"tarikh_pembekal\":\"04/06/2026\",\"catatan_inden\":null,\"items\":[{\"contract_item_id\":\"4\",\"name\":\"Bola Sepak Saiz 5\",\"unit\":\"Biji\",\"orderQty\":\"0\",\"unitPrice\":\"85.00\"},{\"contract_item_id\":\"5\",\"name\":\"Raket Badminton Karbon\",\"unit\":\"Batang\",\"orderQty\":\"0\",\"unitPrice\":\"45.00\"},{\"contract_item_id\":\"6\",\"name\":\"Komputer Riba Core i5 8GB RAM\",\"unit\":\"Unit\",\"orderQty\":\"0\",\"unitPrice\":\"4500.00\"}]}', '2026-06-04 08:31:13', '2026-06-04 08:44:36')
            ");
            echo "Jadual borang_inden_drafts dan data berjaya dimasukkan!\n";
        } else {
            echo "Jadual sedia ada dan data telah diisi.\n";
        }
    } else {
        echo "Jadual borang_inden_drafts disiapkan. Tiada data dimasukkan kerana rekod user_id=4 tidak wujud di dalam sistem.\n";
    }

} catch (\Exception $e) {
    echo "Ralat: " . $e->getMessage() . "\n";
}
