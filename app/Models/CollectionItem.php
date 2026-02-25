<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    protected $fillable = [
        'collection_id',
        'item_id',
        'item_type',
        'item_badge'
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'item_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'item_id');
    }

    public function childcategory()
    {
        return $this->belongsTo(Childcategory::class, 'item_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    public function combo()
    {
        return $this->belongsTo(Combo::class, 'item_id');
    }
}
