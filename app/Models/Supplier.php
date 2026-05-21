<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone_number',
        'address',
        'postcode',
        'status',
        'district_id',
        'state_id',
        'created_by',
        'updated_by',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
