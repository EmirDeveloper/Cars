<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];


    public $timestamps = false;


    public function products() 
    {
        return $this->hasMany(Product::class)
            ->orderBy('id', 'desc');
    }


    public function getName()
    {
        return $this->name;
    }
}
