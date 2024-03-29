<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    const UPDATED_AT = null;

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class)
            ->orderBy('id', 'desc');
    }


    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'customer_product')
            ->orderBy('id', 'desc');
    }
}
