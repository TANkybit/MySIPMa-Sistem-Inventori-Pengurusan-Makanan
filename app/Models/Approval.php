<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approvals';
    public $timestamps = false;
    
    protected $fillable = [
        'order_id',
        'approved_by',
        'approval_date',
        'status',
        'remarks',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    protected $casts = [
        'approval_date' => 'date',
        'status' => 'integer'
    ];

    /**
     * Relationship: Approval belongs to Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship: Approval belongs to User (approved_by)
     */
    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    /**
     * Scope: Get pending approvals
     */
    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope: Get approved items
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }
}
