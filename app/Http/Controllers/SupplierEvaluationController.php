<?php

namespace App\Http\Controllers;

use App\Models\SupplierEvaluation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierEvaluationController extends Controller
{
    public function index()
    {
        \Log::info('Evaluation API: Fetching index');
        $evaluations = SupplierEvaluation::with(['supplier', 'institution', 'order'])
            ->orderBy('evaluation_date', 'desc')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $evaluations
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'institution_id' => 'required|exists:institutions,id',
            'evaluator_name' => 'required|string|max:255',
            'evaluation_date' => 'required|date',
            'criteria_quantity' => 'required|integer|min:1|max:7',
            'criteria_delivery' => 'required|integer|min:1|max:7',
            'criteria_price' => 'required|integer|min:1|max:7',
            'criteria_quality' => 'required|integer|min:1|max:7',
            'criteria_cooperation' => 'required|integer|min:1|max:7',
            'remarks' => 'nullable|string',
        ]);

        $totalScore = $validated['criteria_quantity'] + 
                      $validated['criteria_delivery'] + 
                      $validated['criteria_price'] + 
                      $validated['criteria_quality'] + 
                      $validated['criteria_cooperation'];
                      
        $percentage = ($totalScore / 35) * 100;
        
        $rating = 'Lemah';
        if ($percentage >= 81) {
            $rating = 'Cemerlang';
        } elseif ($percentage >= 51) {
            $rating = 'Sederhana';
        }

        $evaluation = SupplierEvaluation::create(array_merge($validated, [
            'total_score' => $totalScore,
            'percentage' => $percentage,
            'performance_rating' => $rating,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Penilaian prestasi berjaya disimpan.',
            'data' => $evaluation
        ]);
    }

    public function show($id)
    {
        $evaluation = SupplierEvaluation::with(['supplier', 'institution', 'order'])->find($id);
        
        if (!$evaluation) {
            return response()->json(['success' => false, 'message' => 'Penilaian tidak dijumpai.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $evaluation
        ]);
    }

    public function getStats()
    {
        \Log::info('Evaluation API: Fetching stats');
        $totalEvaluations = SupplierEvaluation::count();
        $avgPercentage = SupplierEvaluation::avg('percentage') ?? 0;
        
        $ratings = SupplierEvaluation::selectRaw('performance_rating, count(*) as count')
            ->groupBy('performance_rating')
            ->pluck('count', 'performance_rating');
            
        return response()->json([
            'success' => true,
            'stats' => [
                'total' => $totalEvaluations,
                'average' => round($avgPercentage, 1),
                'ratings' => $ratings
            ]
        ]);
    }

    public function getOrders()
    {
        // Fetch recent orders that need evaluation
        $orders = Order::with(['supplier', 'institution'])
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}
