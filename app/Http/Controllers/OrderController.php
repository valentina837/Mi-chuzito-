<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Logistica;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::create([
            'total' => $request->total,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => 'En proceso'
        ]);

        // Guardar productos del pedido
        foreach ($request->items as $item) {

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['cantidad'],
                'price' => $item['price'],
                'salsas' => implode(', ', $item['salsas'] ?? []),
                'acompanamientos' => implode(', ', $item['acompanamientos'] ?? [])
            ]);
        }

        // Crear automáticamente logística
        Logistica::create([

            'pedido_id' => $order->id,

            'repartidor_nombre' => 'Carlos Gómez',

            'repartidor_telefono' => '3001234567',

            'ubicacion_repartidor' => 'Centro Medellín',

            'ubicacion_cliente' => $order->address,

            'ruta_sugerida' =>
            'Centro Medellín → ' . $order->address,

            'estado' => 'asignado'
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
