<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productimage extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'image',  // mass assignment allowed
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
