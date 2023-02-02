<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public $timestamps = false;


    public function location()
    {
        return $this->belongsTo(Location::class);
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
