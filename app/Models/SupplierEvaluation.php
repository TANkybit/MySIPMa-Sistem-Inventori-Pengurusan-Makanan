<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierEvaluation extends Model
{
    use HasFactory;

    protected $table = 'supplier_evaluations';

    protected $fillable = [
        'order_id',
        'supplier_id',
        'institution_id',
        'evaluator_name',
        'evaluation_date',
        'criteria_quantity',
        'criteria_delivery',
        'criteria_price',
        'criteria_quality',
        'criteria_cooperation',
        'total_score',
        'percentage',
        'performance_rating',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'percentage' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
