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
        
        $user = Auth::user();
        $query = SupplierEvaluation::with(['supplier', 'institution', 'order']);
        
        if ($user->landingRouteName() === 'pengarah.institusi.dashboard') {
            $query->where('institution_id', $user->institution_id);
        } else {
            $query->where('status', 'Verified');
        }
        
        $evaluations = $query->orderBy('evaluation_date', 'desc')->get();
            
        return response()->json([
            'success' => true,
            'data' => $evaluations
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
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
            'status' => 'Pending',
            'is_verified' => false,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Penilaian prestasi berjaya disimpan sebagai menunggu pengesahan.',
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
        
        $user = Auth::user();
        $query = new SupplierEvaluation();
        
        if ($user->landingRouteName() === 'pengarah.institusi.dashboard') {
            $query = $query->where('institution_id', $user->institution_id);
        } else {
            $query = $query->where('status', 'Verified');
        }
        
        $totalEvaluations = $query->count();
        $avgPercentage = $query->avg('percentage') ?? 0;
        
        $ratings = (clone $query)->selectRaw('performance_rating, count(*) as count')
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
        $user = Auth::user();
        $query = Order::with(['supplier', 'institution']);
        
        if ($user->landingRouteName() === 'pengarah.institusi.dashboard') {
            $query->where('institution_id', $user->institution_id);
        }
        
        $orders = $query->orderBy('id', 'desc')->limit(100)->get();
            
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function verify($id)
    {
        $evaluation = SupplierEvaluation::find($id);
        if (!$evaluation) {
            return response()->json([
                'success' => false,
                'message' => 'Penilaian tidak dijumpai.'
            ], 404);
        }

        $user = Auth::user();
        if ($user->landingRouteName() === 'pengarah.institusi.dashboard' && $evaluation->institution_id != $user->institution_id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tiada kebenaran untuk mengesahkan penilaian institusi lain.'
            ], 403);
        }

        $evaluation->update([
            'status' => 'Verified',
            'is_verified' => true,
            'updated_by' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Penilaian prestasi pembekal berjaya disahkan.'
        ]);
    }

    public function getMonthlyData(Request $request)
    {
        $user = Auth::user();
        $year = intval($request->input('year', date('Y')));
        
        $query = SupplierEvaluation::with(['supplier'])
            ->whereYear('evaluation_date', $year);

        if ($user->landingRouteName() === 'pengarah.institusi.dashboard') {
            $query->where('institution_id', $user->institution_id);
        } else {
            $query->where('status', 'Verified');
        }
        
        $evaluations = $query->get();
        
        $grouped = $evaluations->groupBy('supplier_id');
        
        $data = [];
        foreach ($grouped as $supplierId => $items) {
            $supplier = $items->first()->supplier;
            if (!$supplier) continue;
            
            $monthlyScores = array_fill(1, 12, null);
            
            $byMonth = $items->groupBy(function($item) {
                return (int) $item->evaluation_date->format('m');
            });
            
            foreach ($byMonth as $month => $monthItems) {
                $monthlyScores[$month] = round($monthItems->avg('percentage'), 1);
            }
            
            $validScores = array_filter($monthlyScores, function($v) { return !is_null($v); });
            $avgScore = count($validScores) > 0 ? round(array_sum($validScores) / count($validScores), 1) : null;
            
            $rating = null;
            if (!is_null($avgScore)) {
                if ($avgScore >= 81) $rating = 'Cemerlang';
                elseif ($avgScore >= 51) $rating = 'Sederhana';
                else $rating = 'Lemah';
            }
            
            $data[] = [
                'supplier_id' => $supplier->id,
                'supplier_name' => $supplier->company_name,
                'monthly' => $monthlyScores,
                'average' => $avgScore,
                'rating' => $rating,
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
