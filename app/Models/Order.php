<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public $timestamps = false;

    protected $fillable = [
        'order_no',
        'institution_id',
        'supplier_id',
        'contract_id',
        'order_date',
        'total_amount',
        'status',
        'remarks',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
