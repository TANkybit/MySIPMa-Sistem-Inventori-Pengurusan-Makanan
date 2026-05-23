<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'contract_no',
        'institution_id',
        'supplier_id',
        'start_date',
        'end_date',
        'total_value',
        'status',
        'created_by',
        'updated_by',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
