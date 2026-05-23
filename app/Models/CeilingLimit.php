<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CeilingLimit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'institution_id',
        'contract_id',
        'contract_limit',
        'yearly_limit',
        'monthly_limit',
        'used_quantity',
        'status',
        'created_by',
        'updated_by',
    ];
}
