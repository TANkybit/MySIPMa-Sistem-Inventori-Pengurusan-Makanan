<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('prism_diet_rules')->updateOrInsert(
            [
                'institution_id' => 11,
                'week_cycle' => 'M2-4',
                'day_of_week' => 4,
                'item_name' => 'Daging Lembu',
            ],
            [
                'rate_per_person' => 70,
                'unit' => 'g',
                'muster_basis' => 'khas',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('prism_diet_rules')
            ->where('institution_id', 11)
            ->where('week_cycle', 'M2-4')
            ->where('day_of_week', 4)
            ->where('item_name', 'Daging Lembu')
            ->delete();
    }
};
