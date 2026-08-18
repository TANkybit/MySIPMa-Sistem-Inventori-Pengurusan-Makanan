<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('diet_recipient_categories')->updateOrInsert(
            ['code' => 'restricted'],
            [
                'name' => 'Diet Terhad', 'menu_group' => 'restricted',
                'display_order' => 8, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ]
        );

        $recipeId = DB::table('diet_recipes')->where('name', 'Petola / Kundur Masak Air')->value('id');
        if ($recipeId) {
            DB::table('diet_recipe_ingredients')
                ->where('diet_recipe_id', $recipeId)
                ->where('item_name', 'Ketola')
                ->update(['item_name' => 'Ketola / Kundur', 'is_menu_choice' => true, 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        DB::table('diet_recipient_categories')->where('code', 'restricted')->delete();
        $recipeId = DB::table('diet_recipes')->where('name', 'Petola / Kundur Masak Air')->value('id');
        if ($recipeId) {
            DB::table('diet_recipe_ingredients')
                ->where('diet_recipe_id', $recipeId)
                ->where('item_name', 'Ketola / Kundur')
                ->update(['item_name' => 'Ketola', 'is_menu_choice' => false, 'updated_at' => now()]);
        }
    }
};
