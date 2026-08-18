<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DietSuggestionService
{
    public function calculate(object $guideline, int $contractId, Carbon $date, string $session, array $counts): array
    {
        $cycle = $this->resolveCycle($guideline, $date);
        $day = $date->dayOfWeek;
        $categories = DB::table('diet_recipient_categories')->where('is_active', true)->get()->keyBy('code');
        $scaleRates = DB::table('diet_scale_rates as dsr')
            ->join('diet_scale_items as dsi', 'dsi.id', '=', 'dsr.diet_scale_item_id')
            ->where('dsi.guideline_version_id', $guideline->id)
            ->select('dsi.source_number', 'dsi.item_name as scale_item_name', 'dsr.category_code', 'dsr.quantity', 'dsr.unit')
            ->get()
            ->keyBy(fn ($rate) => $rate->source_number . '|' . $rate->category_code);
        $additionalRates = DB::table('diet_additional_rations')
            ->where('guideline_version_id', $guideline->id)
            ->get()
            ->keyBy(fn ($rate) => $this->normalise($rate->item_name));

        $requirements = [];
        $menus = [];
        foreach ($counts as $categoryCode => $headcount) {
            $headcount = (int) $headcount;
            $category = $categories->get($categoryCode);
            if (!$category || $headcount <= 0) {
                continue;
            }

            if ($categoryCode === 'restricted') {
                $this->addRequirement($requirements, 'Roti Putih', 500 * $headcount, 'g', $category->name, 'Diet terhad 500g seorang');
                $this->addRequirement($requirements, 'Susu Tepung Penuh Krim', 50 * $headcount, 'g', $category->name, 'Diet terhad 50g seorang');
                continue;
            }

            $entries = DB::table('diet_menu_entries')
                ->where('guideline_version_id', $guideline->id)
                ->where('menu_group', $category->menu_group)
                ->where('week_cycle', $cycle)
                ->where('day_of_week', $day)
                ->where('meal_session', $session)
                ->orderBy('display_order')
                ->pluck('dish_name');
            $menus[$categoryCode] = $entries->values()->all();

            $recipeIds = DB::table('diet_recipes')
                ->where('guideline_version_id', $guideline->id)
                ->whereIn('name', $entries)
                ->pluck('id');
            $ingredients = DB::table('diet_recipe_ingredients')
                ->whereIn('diet_recipe_id', $recipeIds)
                ->orderBy('diet_recipe_id')
                ->orderBy('id')
                ->get();

            $seenMain = [];
            $seenSeasoning = [];
            $seenFixed = [];
            foreach ($ingredients as $ingredient) {
                if ($this->isExcludedForCategory($ingredient->item_name, $categoryCode)) {
                    continue;
                }

                if ($ingredient->ingredient_role === 'main') {
                    $dedupeKey = $ingredient->scale_source_number . '|' . $this->normalise($ingredient->item_name);
                    if (isset($seenMain[$dedupeKey])) continue;
                    $seenMain[$dedupeKey] = true;
                    $rate = $scaleRates->get($ingredient->scale_source_number . '|' . $categoryCode);
                    if (!$rate) continue;
                    $this->addRequirement(
                        $requirements,
                        $ingredient->item_name,
                        (float) $rate->quantity * $headcount,
                        $rate->unit,
                        $category->name,
                        $this->formatRate($rate->quantity, $rate->unit, $headcount)
                    );
                    continue;
                }

                if ($ingredient->ingredient_role === 'seasoning') {
                    $key = $this->normalise($ingredient->item_name);
                    if (isset($seenSeasoning[$key])) continue;
                    $seenSeasoning[$key] = true;
                    $rate = $additionalRates->get($key);
                    if (!$rate) continue;
                    $this->addRequirement(
                        $requirements,
                        $ingredient->item_name,
                        (float) $rate->quantity * $headcount,
                        $rate->unit,
                        $category->name,
                        $this->formatRate($rate->quantity, $rate->unit, $headcount)
                    );
                    continue;
                }

                $key = $this->normalise($ingredient->item_name);
                if (isset($seenFixed[$key])) continue;
                $seenFixed[$key] = true;
                $quantity = (float) $ingredient->quantity_override;
                if ($categoryCode === 'child_baby' && $key === $this->normalise('Gula')) {
                    $quantity = 5;
                }
                $this->addRequirement(
                    $requirements,
                    $ingredient->item_name,
                    $quantity * $headcount,
                    $ingredient->unit_override ?: 'g',
                    $category->name,
                    $this->formatRate($quantity, $ingredient->unit_override ?: 'g', $headcount)
                );
            }

            if ($session === 'M4') {
                $this->addCategoryAdditions($requirements, $categoryCode, $category->name, $headcount);
            }
        }

        $contractItems = DB::table('contract_items as ci')
            ->join('items as i', 'i.id', '=', 'ci.item_id')
            ->join('contracts as c', 'c.id', '=', 'ci.contract_id')
            ->leftJoin('uom as u', 'u.id', '=', 'ci.uom_id')
            ->where('ci.contract_id', $contractId)
            ->select('ci.id as contract_item_id', 'ci.item_id', 'c.institution_id', 'i.name', 'u.code as unit')
            ->get();
        $contractByName = $contractItems->keyBy(fn ($item) => $this->normalise($item->name));
        $contractByItemId = $contractItems->keyBy('item_id');
        $institutionId = optional($contractItems->first())->institution_id;
        $explicitMappings = $institutionId
            ? DB::table('diet_catalogue_mappings')
                ->where('guideline_version_id', $guideline->id)
                ->where('institution_id', $institutionId)
                ->pluck('item_id', 'diet_item_name')
                ->mapWithKeys(fn ($itemId, $name) => [$this->normalise($name) => $itemId])
            : collect();

        $suggestions = [];
        $missing = [];
        $resolvedRequirements = [];
        foreach ($requirements as $requirement) {
            $normalisedName = $this->normalise($requirement['item_name']);
            $mappedItemId = $explicitMappings->get($normalisedName);
            $contractItem = $mappedItemId
                ? $contractByItemId->get($mappedItemId)
                : $contractByName->get($normalisedName);
            $quantity = $requirement['unit'] === 'g'
                ? $requirement['quantity'] / 1000
                : $requirement['quantity'];
            $suggestedQuantity = $requirement['unit'] === 'g'
                ? ceil($quantity * 1000) / 1000
                : ceil($quantity);
            $calculation = implode(' + ', array_unique($requirement['breakdown']));
            $resolvedRequirements[] = [
                'item_name' => $requirement['item_name'],
                'contract_item_id' => $contractItem?->contract_item_id,
                'quantity' => $suggestedQuantity,
                'unit' => $requirement['unit'] === 'g' ? ($contractItem?->unit ?: 'kg') : ($contractItem?->unit ?: $requirement['unit']),
                'calculation' => $calculation,
            ];
            if (!$contractItem) {
                $missing[] = $requirement['item_name'];
                continue;
            }
            $suggestions[$contractItem->contract_item_id] = [
                'quantity' => $suggestedQuantity,
                'basis' => 'official_categories',
                'rate_per_person' => null,
                'rate_unit' => $requirement['unit'],
                'muster_used' => array_sum($counts),
                'calculation' => $calculation,
                'source' => $guideline->code . ' · ' . $cycle . ' · ' . $session,
            ];
        }

        return [
            'cycle' => $cycle,
            'menus' => $menus,
            'suggestions' => $suggestions,
            'requirements' => $resolvedRequirements,
            'required_items_missing_contract' => array_values(array_unique($missing)),
        ];
    }

    private function resolveCycle(object $guideline, Carbon $date): string
    {
        if (($guideline->week_number_method ?? null) === 'excel_weeknum') {
            // Excel WEEKNUM(date, 2): weeks start Monday and the week containing
            // 1 January is week 1. This mirrors PRISM 4.93 exactly.
            $jan1 = $date->copy()->startOfYear();
            $offsetBeforeFirstMonday = $jan1->dayOfWeekIso - 1;
            $weekNumber = intdiv(($date->dayOfYear - 1) + $offsetBeforeFirstMonday, 7) + 1;
            $oddCycle = $guideline->odd_week_cycle ?? 'M1-3';
            return $weekNumber % 2 === 1
                ? $oddCycle
                : ($oddCycle === 'M1-3' ? 'M2-4' : 'M1-3');
        }

        $anchor = Carbon::parse($guideline->cycle_anchor_date ?: $guideline->effective_from)->startOfWeek(Carbon::MONDAY);
        $orderWeek = $date->copy()->startOfWeek(Carbon::MONDAY);
        $offset = (int) floor(abs($anchor->diffInDays($orderWeek, false)) / 7);
        $anchorCycle = $guideline->cycle_anchor_week ?: 'M1-3';
        return $offset % 2 === 0 ? $anchorCycle : ($anchorCycle === 'M1-3' ? 'M2-4' : 'M1-3');
    }

    private function addRequirement(array &$requirements, string $item, float $quantity, string $unit, string $category, string $calculation): void
    {
        $key = $this->normalise($item) . '|' . $unit;
        $requirements[$key] ??= ['item_name' => $item, 'quantity' => 0.0, 'unit' => $unit, 'breakdown' => []];
        $requirements[$key]['quantity'] += $quantity;
        $requirements[$key]['breakdown'][] = $category . ': ' . $calculation;
    }

    private function addCategoryAdditions(array &$requirements, string $code, string $name, int $headcount): void
    {
        if (in_array($code, ['pregnant', 'breastfeeding', 'hiv_aids'], true)) {
            $this->addRequirement($requirements, 'Susu Tepung Penuh Krim', 30 * $headcount, 'g', $name, "30 g × {$headcount}");
        }
        if ($code === 'breastfeeding') {
            $this->addRequirement($requirements, 'Roti Ban', 50 * $headcount, 'g', $name, "50 g × {$headcount}");
            $this->addRequirement($requirements, 'Sayur Berdaun', 50 * $headcount, 'g', $name, "50 g × {$headcount}");
        }
    }

    private function isExcludedForCategory(string $item, string $category): bool
    {
        $normal = $this->normalise($item);
        if ($category === 'vegetarian' && in_array($normal, [$this->normalise('Ikan Bilis'), $this->normalise('Belacan')], true)) {
            return true;
        }
        if ($category === 'child_baby') {
            $excluded = ['Cili','Cili Kering','Cili Padi','Cuka','Serbuk Cili','Serbuk Lada Sulah','Rempah Kari','Rempah Kurma','Rempah Sup'];
            return in_array($normal, array_map(fn ($value) => $this->normalise($value), $excluded), true);
        }
        return false;
    }

    private function formatRate(float|string $quantity, string $unit, int $headcount): string
    {
        return rtrim(rtrim(number_format((float) $quantity, 3, '.', ''), '0'), '.') . " {$unit} × {$headcount}";
    }

    private function normalise(string $name): string
    {
        $name = strtolower(trim($name));
        $name = str_replace(
            ['telor', 'ikan basah ', ' (fresh fish)', 'kembung', 'nanas', 'kobis cina panjang', 'petola', 'daging lembu/kerbau (beku)', 'daging lembu'],
            ['telur', '', '', 'kembong', 'nenas', 'kobis panjang', 'ketola', 'daging', 'daging'],
            $name
        );
        return preg_replace('/[^a-z0-9]+/u', '', $name);
    }
}
