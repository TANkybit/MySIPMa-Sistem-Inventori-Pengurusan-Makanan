<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{
    /**
     * Store a newly created position in the database.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|max:50|unique:positions,code',
                'name' => 'required|string|max:255',
                'grade' => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ralat pengesahan data. Sila pastikan Kod Jawatan tidak diulang.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $position = Position::create([
                'code' => $request->code,
                'name' => $request->name,
                'grade' => $request->grade,
                'created_by' => auth()->id() ?? 1, // Fallback if no user is authenticated during creation test
                'updated_by' => auth()->id() ?? 1,
            ]);

            Log::info("New position registered successfully: {$position->code} - {$position->name}");

            return response()->json([
                'success' => true,
                'message' => 'Jawatan Baru Berjaya Disimpan!',
                'data' => $position
            ]);
        } catch (\Exception $e) {
            Log::error('Error registering position: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi ralat semasa menyimpan rekod.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
