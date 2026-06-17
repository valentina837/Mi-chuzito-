<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventarios';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'nivel_minimo',
        'estado'
    ];

    // Relación con products
    public function producto()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}