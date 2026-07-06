<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with(['state', 'district', 'createdBy'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $suppliers->map(function($supplier) {
                return [
                    'id' => $supplier->id,
                    'company_name' => $supplier->company_name,
                    'contact_person' => $supplier->contact_person,
                    'email' => $supplier->email,
                    'phone_number' => $supplier->phone_number,
                    'address' => $supplier->address,
                    'postcode' => $supplier->postcode,
                    'status' => $supplier->status,
                    'state' => $supplier->state ? $supplier->state->name : 'N/A',
                    'district' => $supplier->district ? $supplier->district->name : 'N/A',
                    'created_at' => $supplier->created_at ? $supplier->created_at->toDateString() : null,
                    'is_hq' => $supplier->createdBy?->effectiveRoleName() === 'Admin',
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:suppliers',
            'phone_number' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'postcode' => 'required|string|max:20',
            'state_id' => 'required|integer|exists:states,id',
            'district_id' => 'required|integer|exists:districts,id',
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ralat pengesahan data.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $supplier = Supplier::create(array_merge($request->only([
            'company_name',
            'contact_person',
            'email',
            'phone_number',
            'address',
            'postcode',
            'state_id',
            'district_id',
        ]), [
            'status' => in_array($request->status, ['active', '1'], true) ? 1 : 0,
            'created_at' => now(),
            'created_by' => auth()->id(),
            'updated_at' => now(),
            'updated_by' => auth()->id(),
        ]));

        $supplier->load(['state', 'district']);

        return response()->json([
            'success' => true,
            'message' => 'Pembekal baru berjaya ditambah.',
            'data' => [
                'id' => $supplier->id,
                'company_name' => $supplier->company_name,
                'contact_person' => $supplier->contact_person,
                'email' => $supplier->email,
                'phone_number' => $supplier->phone_number,
                'address' => $supplier->address,
                'postcode' => $supplier->postcode,
                'status' => $supplier->status,
                'state_id' => $supplier->state_id,
                'district_id' => $supplier->district_id,
                'state' => $supplier->state ? $supplier->state->name : 'N/A',
                'district' => $supplier->district ? $supplier->district->name : 'N/A',
                'created_at' => $supplier->created_at ? $supplier->created_at->toDateString() : null,
                'is_hq' => $supplier->createdBy?->effectiveRoleName() === 'Admin',
            ],
        ]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('suppliers', 'email')->ignore($supplier->id)],
            'phone_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'postcode' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:50',
            'state_id' => 'nullable|integer|exists:states,id',
            'district_id' => 'nullable|integer|exists:districts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ralat pengesahan data.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only([
            'company_name',
            'contact_person',
            'email',
            'phone_number',
            'address',
            'postcode',
            'state_id',
            'district_id',
        ]);
        if ($request->has('status')) {
            $data['status'] = in_array($request->status, ['active', '1'], true) ? 1 : 0;
        }
        $data['updated_at'] = now();
        $data['updated_by'] = auth()->id();
        $supplier->update($data);

        $supplier->load(['state', 'district']);

        return response()->json([
            'success' => true,
            'message' => 'Maklumat pembekal berjaya dikemaskini.',
            'data' => [
                'id' => $supplier->id,
                'company_name' => $supplier->company_name,
                'contact_person' => $supplier->contact_person,
                'email' => $supplier->email,
                'phone_number' => $supplier->phone_number,
                'address' => $supplier->address,
                'postcode' => $supplier->postcode,
                'status' => $supplier->status,
                'state_id' => $supplier->state_id,
                'district_id' => $supplier->district_id,
                'state' => $supplier->state ? $supplier->state->name : 'N/A',
                'district' => $supplier->district ? $supplier->district->name : 'N/A',
                'created_at' => $supplier->created_at ? $supplier->created_at->toDateString() : null,
                'is_hq' => $supplier->createdBy?->effectiveRoleName() === 'Admin',
            ],
        ]);
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return response()->json([
                'success' => true,
                'message' => 'Pembekal berjaya dipadam.'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting supplier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memadam kerana pembekal ini sedang digunakan (Terdapat rekod pesanan yang berkaitan).'
            ], 400);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting supplier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi ralat semasa memadam rekod pembekal.'
            ], 500);
        }
    }
}
