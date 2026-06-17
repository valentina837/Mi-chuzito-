<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'price',
        'stock',
        'minimum_stock',
        'status'

    ];

    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'producto_id');
    }
}
