<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'review_id',
        'coupon_name',
        'coupon_discount_amount',
        'combo_id',
        'product_name',
        'purchase_price',
        'sale_price',
        'qty',
        'product_color',
        'product_size',
        'discount_amount',
        'product_type'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function image()
    {
        return $this->belongsTo(Productimage::class, 'product_id', 'product_id')->select('id', 'product_id', 'image');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'order_id', 'order_id')->select('id', 'order_id', 'name', 'phone', 'address');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->select('id', 'invoice_id');
    }
    public function combo()
    {
        return $this->belongsTo(Combo::class, 'combo_id', 'id')->with('images');
    }


}
