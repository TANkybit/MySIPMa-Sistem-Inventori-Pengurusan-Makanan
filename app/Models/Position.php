<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = [
        'code',
        'name',
        'grade',
        'created_by',
        'updated_by',
    ];

    // Optional: Cast dates if MySQL complains about datetime being written to DATE field.
    // Generally Eloquent saves 'Y-m-d H:i:s' and MySQL cuts it to DATE.
    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];
}
