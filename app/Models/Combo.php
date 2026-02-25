<?php

namespace App\Models;
use App\Models\Comboimage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'min_products',
        'max_products',
        'price',
        'new_price',
        'old_price',
        'description',
        'brand_id',
        'note',
        'stock',
        'stockstatus',
        'image',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'combo_products', 'combo_id', 'product_id');
    }


    // app/Models/Combo.php
   public function images()
    {
        return $this->hasMany(ComboImage::class)->orderBy('id', 'asc');
    }
    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class, 'brand_id');
    }


}
