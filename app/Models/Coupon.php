<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount',
        'min_order_total',
        'max_uses',
        'used_by',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Coupon currently valid কিনা সেটা চেক করবে
     */
    public function isCurrentlyValid(float $orderSubtotal): bool
    {
        $now = Carbon::now();

        if (! $this->is_active) {
            return false;
        }
        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }
        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }
        if ($this->max_uses && $this->times_used >= $this->max_uses) {
            return false;
        }
        if ($orderSubtotal < (float) $this->min_order_total) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount based on coupon type
     */
    public function calculate(float $subtotal, float $shipping = 0): array
    {
        $discount = 0.0;
        $shipOff = 0.0;

        if ($this->type === 'percent') {
            $discount = round(($subtotal * ($this->value / 100)), 2);
            if ($this->max_discount) {
                $discount = min($discount, (float) $this->max_discount);
            }
        } elseif ($this->type === 'fixed') {
            $discount = min($subtotal, (float) $this->value);
        } elseif ($this->type === 'free_shipping') {
            $shipOff = $shipping; // পুরো শিপিং ফ্রি
        }

        return [$discount, $shipOff];
    }

    /**
     * সম্পর্ক: এক কুপন অনেক অর্ডারে ব্যবহার হতে পারে
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
