<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\InventoryMovement;
use App\Models\Order;

class InventarioController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $movements = InventoryMovement::with('product')
            ->latest()
            ->get();

        return Inertia::render('Inventario', [

            'products' => $products,

            'movements' => $movements

        ]);
    }
    public function update(Request $request, Product $inventario)
    {
        $inventario->update([
            'stock' => $request->stock
        ]);

        if ($inventario->stock <= 0) {
            $inventario->update([
                'status' => 'Agotado'
            ]);
        } else {
            $inventario->update([
                'status' => 'Disponible'
            ]);
        }
        return back();
    }
    public function cierreVentas()
    {
        $orders = Order::where('closed', false)
            ->with('items.product')
            ->get();

        foreach ($orders as $order) {

            foreach ($order->items as $item) {

                $product = $item->product;

                if ($product) {

                    // Descontar stock
                    $product->stock -= $item->quantity;

                    // Evitar negativos
                    if ($product->stock < 0) {
                        $product->stock = 0;
                    }

                    // Cambiar estado
                    $product->status = $product->stock <= 0
                        ? 'Agotado'
                        : 'Disponible';

                    $product->save();

                    // Registrar movimiento
                    \App\Models\InventoryMovement::create([

                        'product_id' => $product->id,

                        'quantity' => $item->quantity,

                        'type' => 'Salida'

                    ]);
                }
            }

            // Marcar pedido como cerrado
            $order->closed = true;
            $order->save();
        }

        return back();
    }
}
