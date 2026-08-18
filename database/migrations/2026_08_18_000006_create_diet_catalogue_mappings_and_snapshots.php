<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_catalogue_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guideline_version_id')->constrained('diet_guideline_versions')->cascadeOnDelete();
            $table->integer('institution_id');
            $table->string('diet_item_name');
            $table->integer('item_id');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['guideline_version_id', 'institution_id', 'diet_item_name'], 'diet_catalogue_mapping_unique');
            $table->foreign('institution_id')->references('id')->on('institutions')->cascadeOnDelete();
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
        });

        Schema::create('order_diet_calculation_snapshots', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->foreignId('guideline_version_id')->constrained('diet_guideline_versions');
            $table->integer('contract_item_id')->nullable();
            $table->string('diet_item_name');
            $table->decimal('suggested_quantity', 15, 3);
            $table->string('unit', 30);
            $table->text('calculation')->nullable();
            $table->string('source')->nullable();
            $table->json('menu_context')->nullable();
            $table->timestamps();
            $table->index(['order_id', 'contract_item_id'], 'diet_snapshot_order_item_idx');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('contract_item_id')->references('id')->on('contract_items')->nullOnDelete();
        });

        $guidelineId = DB::table('diet_guideline_versions')->where('code', 'SKALA-DIET-2025')->value('id');
        $kajangId = DB::table('institutions')->where('name', 'like', '%Kajang%')->value('id');
        $eggId = DB::table('items')->where('name', 'like', 'Telur Ayam%Gred B%')->value('id');

        if ($guidelineId && $kajangId && $eggId) {
            DB::table('diet_catalogue_mappings')->insert([
                'guideline_version_id' => $guidelineId,
                'institution_id' => $kajangId,
                'diet_item_name' => 'Telur',
                'item_id' => $eggId,
                'notes' => 'Padanan item generik skala diet kepada item kontrak Kajang 2026.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_diet_calculation_snapshots');
        Schema::dropIfExists('diet_catalogue_mappings');
    }
};
