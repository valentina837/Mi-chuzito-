<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logistica extends Model
{
    protected $fillable = [

        'pedido_id',
        'repartidor_nombre',
        'repartidor_telefono',
        'ubicacion_repartidor',
        'ubicacion_cliente',
        'ruta_sugerida',
        'estado'
    ];

    // Relación con pedido
    public function pedido()
    {
        return $this->belongsTo(Order::class, 'pedido_id');
    }
}
