<?php

namespace App\Http\Controllers;

use App\Models\Logistica;
use App\Models\Order;
use Illuminate\Http\Request;

class LogisticaController extends Controller
{
    public function index()
    {
        $logisticas = Logistica::latest()->get();

        return inertia('Logistica/Index', [
            'logisticas' => $logisticas
        ]);
    }

    public function asignar($id)
    {
        $pedido = Order::findOrFail($id);

        Logistica::create([
            'pedido_id' => $pedido->id,

            'repartidor_nombre' => 'Carlos Gómez',

            'repartidor_telefono' => '3001234567',

            'ubicacion_repartidor' => 'Centro Medellín',

            'ubicacion_cliente' => $pedido->address,

            'ruta_sugerida' =>
            'Centro Medellín → ' . $pedido->address,

            'estado' => 'en_camino'
        ]);

        return redirect()->back();
    }

    public function cambiarEstado(
        Request $request,
        $id
    ) {
        $logistica = Logistica::findOrFail($id);

        $logistica->estado = $request->estado;

        $logistica->save();

        return redirect()->back();
    }
}
