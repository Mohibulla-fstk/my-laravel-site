<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'amount',
        'coupon_id',
        'discount_amount',
        'shipping_charge',
        'customer_id',
        'user_id',
        'admin_note',
        'order_status',
        'note',
    ];
    
    public function orderdetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(OrderDetails::class, 'id', 'order_id')->select('id', 'order_id', 'product_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'id', 'order_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Coupon এর সাথে সম্পর্ক
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    // Order.php
    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    // Order Items (যদি থাকে)

}
