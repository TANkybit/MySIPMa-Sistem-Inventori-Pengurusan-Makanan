<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Order;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'contract_item_id',
        'item_id',
        'status',
        'ordered_quantity',
        'unit_price',
        'ordered_total_price',
        'received_quantity',
        'received_total_price',
        'remarks',
        'created_by',
        'updated_by',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
