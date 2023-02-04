<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($obj) {
            $obj->slug = str()->slug($obj->full_name_tm) . '-' . str()->random(10);
        });
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function year()
    {
        return $this->belongsTo(Year::class);
    }


    public function motor()
    {
        return $this->belongsTo(AttributeValue::class, 'motor_id', 'id');
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('id');
    }


    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_value')
            ->orderByPivot('sort_order');
    }


    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_product')
            ->orderBy('id', 'desc');
    }


    public function getFullName()
    {
        if (app()->getLocale() == 'en') {
            return $this->full_name_en ?: $this->full_name_tm;
        } else {
            return $this->full_name_tm;
        }
    }


    public function getName()
    {
        if (app()->getLocale() == 'en') {
            return $this->name_en ?: $this->name_tm;
        } else {
            return $this->name_tm;
        }
    }

    public function getImage()
    {
        return $this->image ? Storage::url('p/' . $this->image) : asset('img/product.jpg');
    }
}
