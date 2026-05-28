<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Carbon\Carbon;

class SeedSuppliersFromPdf extends Seeder
{
    /**
     * Seed supplier companies extracted from:
     * LAPORAN KONTRAK BULAN 1 2025 — Penjara Sungai Petani, Kedah
     *
     * State IDs (from states table):
     *   Kedah    => 2
     *   Selangor => 14
     */
    public function run(): void
    {
        $now = Carbon::now();

        $suppliers = [
            [
                'company_name'   => 'PERTAMA PROJEK',
                'contact_person' => null,
                'email'          => null,
                'phone_number'   => null,
                'address'        => 'NO. 113 TK2, JALAN MAWAR 2/3, TAMAN PEKAN BARU, SUNGAI PETANI',
                'postcode'       => '08000',
                'state_id'       => 2,   // Kedah
                'district_id'    => null,
                'status'         => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'company_name'   => 'PERTUBUHAN PELADANG KEBANGSAAN',
                'contact_person' => null,
                'email'          => null,
                'phone_number'   => null,
                'address'        => 'PETALING JAYA',
                'postcode'       => null,
                'state_id'       => 14,  // Selangor
                'district_id'    => null,
                'status'         => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'company_name'   => 'KILANG BERAS OTHMAN JUSOH BERSAUDARA (M) SDN BHD',
                'contact_person' => null,
                'email'          => null,
                'phone_number'   => null,
                'address'        => 'KAMPUNG BEMBAN, MUKIM GELONG, KUBANG PASU, JITRA',
                'postcode'       => '06000',
                'state_id'       => 2,   // Kedah
                'district_id'    => null,
                'status'         => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ];

        foreach ($suppliers as $data) {
            // Avoid duplicates — skip if company_name already exists
            $exists = Supplier::where('company_name', $data['company_name'])->exists();
            if (!$exists) {
                Supplier::create($data);
                $this->command->info("  ✓ Inserted: {$data['company_name']}");
            } else {
                $this->command->warn("  ⚠ Skipped (already exists): {$data['company_name']}");
            }
        }
    }
}
