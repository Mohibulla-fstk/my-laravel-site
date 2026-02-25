<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Collection extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
        'sort_order'
    ];

    public function items()
    {
        return $this->hasMany(CollectionItem::class);
    }
}

