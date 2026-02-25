<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comboimage extends Model
{
    use HasFactory;

    protected $fillable = [
        'combo_id',
        'image',
    ];

    public function combo()
    {
        return $this->belongsTo(Combo::class, 'combo_id');
    }
}
