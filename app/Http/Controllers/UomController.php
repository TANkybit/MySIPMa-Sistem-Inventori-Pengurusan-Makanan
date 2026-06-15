<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UomController extends Controller
{
    public function index()
    {
        $uoms = Uom::orderBy('code')->get();

        return response()->json([
            'success' => true,
            'data' => $uoms->map(function($uom) {
                return [
                    'id' => $uom->id,
                    'code' => $uom->code,
                    'description' => $uom->description ?? '',
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:uom,code',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ralat pengesahan data.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $uom = Uom::create($request->only(['code', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Unit ukuran baru berjaya ditambah.',
            'data' => [
                'id' => $uom->id,
                'code' => $uom->code,
                'description' => $uom->description ?? '',
            ],
        ]);
    }

    public function update(Request $request, Uom $uom)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string', 'max:50', Rule::unique('uom', 'code')->ignore($uom->id)],
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ralat pengesahan data.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $uom->update($request->only(['code', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Unit ukuran berjaya dikemaskini.',
            'data' => [
                'id' => $uom->id,
                'code' => $uom->code,
                'description' => $uom->description ?? '',
            ],
        ]);
    }

    public function destroy(Uom $uom)
    {
        try {
            $uom->delete();
            return response()->json([
                'success' => true,
                'message' => 'Unit ukuran berjaya dipadam.'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting UOM: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memadam kerana unit ukuran ini sedang digunakan pada item.'
            ], 400);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting UOM: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi ralat semasa memadam rekod unit ukuran.'
            ], 500);
        }
    }
}
