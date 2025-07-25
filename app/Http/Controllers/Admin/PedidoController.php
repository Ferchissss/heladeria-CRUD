<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Promocion;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'detalles.producto'])
                        ->orderBy('fecha_pedido', 'desc')
                        ->paginate(10);
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->get();
        $productos = Producto::where('disponible', true)->get();
        $promociones = Promocion::where('activa', true)->get();
        
        return view('admin.pedidos.create', compact('clientes', 'productos', 'promociones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,cliente_id',
            'estado' => 'required|in:pendiente,preparando,entregado,cancelado',
            'direccion_entrega' => 'required_if:metodo_pago,efectivo,tarjeta,qr,transferencia|string',
            'metodo_pago' => 'required|in:efectivo,tarjeta,qr,transferencia',
            'notas' => 'nullable|string',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'productos.*.instrucciones' => 'nullable|string',
        ]);

        // Calcular total
        $total = collect($request->productos)->sum(function($producto) {
            return $producto['cantidad'] * $producto['precio'];
        });

        // Crear pedido
        $pedido = Pedido::create([
            'cliente_id' => $request->cliente_id,
            'estado' => $request->estado,
            'total' => $total,
            'direccion_entrega' => $request->direccion_entrega,
            'metodo_pago' => $request->metodo_pago,
            'notas' => $request->notas,
        ]);

        // Crear detalles del pedido
        foreach ($request->productos as $producto) {
            $pedido->detalles()->create([
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio'],
                'subtotal' => $producto['cantidad'] * $producto['precio'],
                'instrucciones_especiales' => $producto['instrucciones'] ?? null,
            ]);
        }

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido creado correctamente');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'detalles.producto', 'detalles.ingredientes']);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::where('activo', true)->get();
        $productos = Producto::where('disponible', true)->get();
        $promociones = Promocion::where('activa', true)->get();
        $pedido->load('detalles.producto');
        
        return view('admin.pedidos.edit', compact('pedido', 'clientes', 'productos', 'promociones'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,preparando,entregado,cancelado',
            'direccion_entrega' => 'required_if:metodo_pago,efectivo,tarjeta,qr,transferencia|string',
            'metodo_pago' => 'required|in:efectivo,tarjeta,qr,transferencia',
            'notas' => 'nullable|string',
        ]);

        $pedido->update([
            'estado' => $request->estado,
            'direccion_entrega' => $request->direccion_entrega,
            'metodo_pago' => $request->metodo_pago,
            'notas' => $request->notas,
        ]);

        return redirect()->route('admin.pedidos.show', $pedido)->with('success', 'Pedido actualizado correctamente');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido eliminado correctamente');
    }
}