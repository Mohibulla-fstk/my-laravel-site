<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Combo relation
    public function combo()
    {
        return $this->belongsTo(Combo::class, 'combo_id');
    }

    // Customer relation (optional, যদি guard 'customer' ব্যবহার করো)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
