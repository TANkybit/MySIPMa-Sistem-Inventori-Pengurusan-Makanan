<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_guideline_versions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('source_reference')->nullable();
            $table->date('effective_from')->nullable();
            $table->date('cycle_anchor_date')->nullable();
            $table->string('cycle_anchor_week', 10)->default('M1-3');
            $table->string('status', 20)->default('active');
            $table->timestamps();
        });

        Schema::create('diet_menu_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guideline_version_id')->constrained('diet_guideline_versions')->cascadeOnDelete();
            $table->string('week_cycle', 10);
            $table->unsignedTinyInteger('day_of_week');
            $table->string('meal_session', 10)->nullable();
            $table->string('item_name');
            $table->decimal('rate_per_person', 10, 3);
            $table->string('unit', 10)->default('g');
            $table->string('muster_basis', 30)->default('ditolak_parol');
            $table->timestamps();
            $table->unique(['guideline_version_id', 'week_cycle', 'day_of_week', 'item_name', 'muster_basis'], 'diet_menu_rule_unique');
        });

        Schema::create('diet_item_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_menu_rule_id')->constrained('diet_menu_rules')->cascadeOnDelete();
            // The existing items table uses a signed INT primary key.
            $table->integer('item_id');
            $table->timestamps();
            $table->unique(['diet_menu_rule_id', 'item_id'], 'diet_rule_item_unique');
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
        });

        // Keep the already imported PRISM scale, but promote it from a Kajang
        // data set into one national guideline baseline.
        DB::table('diet_guideline_versions')->updateOrInsert(
            ['code' => 'SKALA-DIET-2025'],
            [
                'name' => 'Garis Panduan Skala Diet Jabatan Penjara Malaysia 2025',
                'source_reference' => 'PRISM 4.93 / Garis Panduan Skala Diet 2025',
                'effective_from' => '2025-01-01',
                // This anchor preserves the existing PRISM rotation while making
                // the calendar explicit and configurable rather than ISO-parity code.
                'cycle_anchor_date' => '2025-01-06',
                'cycle_anchor_week' => 'M2-4',
                'status' => 'active',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $guidelineId = DB::table('diet_guideline_versions')->where('code', 'SKALA-DIET-2025')->value('id');
        $legacyRules = DB::table('prism_diet_rules')
            ->select('week_cycle', 'day_of_week', 'item_name', 'rate_per_person', 'unit', 'muster_basis')
            ->orderBy('id')
            ->get()
            ->unique(fn ($rule) => implode('|', [$rule->week_cycle, $rule->day_of_week, $rule->item_name, $rule->muster_basis]));

        foreach ($legacyRules as $rule) {
            DB::table('diet_menu_rules')->updateOrInsert(
                [
                    'guideline_version_id' => $guidelineId,
                    'week_cycle' => $rule->week_cycle,
                    'day_of_week' => $rule->day_of_week,
                    'item_name' => $rule->item_name,
                    'muster_basis' => $rule->muster_basis,
                ],
                [
                    'rate_per_person' => $rule->rate_per_person,
                    'unit' => $rule->unit,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $normalise = static function (string $name): string {
            $name = strtolower(trim($name));
            $name = str_replace(
                ['telor', 'ikan basah ', ' (fresh fish)', 'kembung', 'nanas mauritius', 'kobis panjang', 'petola', 'daging lembu/kerbau (beku)'],
                ['telur', '', '', 'kembong', 'nenas mauritius', 'kobis cina panjang', 'ketola', 'daging lembu'],
                $name
            );
            return preg_replace('/[^a-z0-9]+/u', '', $name);
        };

        $itemsByName = DB::table('items')->select('id', 'name')->get()
            ->groupBy(fn ($item) => $normalise($item->name));

        foreach (DB::table('diet_menu_rules')->where('guideline_version_id', $guidelineId)->get() as $menuRule) {
            foreach ($itemsByName->get($normalise($menuRule->item_name), collect()) as $item) {
                DB::table('diet_item_mappings')->updateOrInsert(
                    ['diet_menu_rule_id' => $menuRule->id, 'item_id' => $item->id],
                    ['updated_at' => now(), 'created_at' => now()]
                );
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_item_mappings');
        Schema::dropIfExists('diet_menu_rules');
        Schema::dropIfExists('diet_guideline_versions');
    }
};
