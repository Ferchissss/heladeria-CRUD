<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->paginate(10);
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        return view('admin.productos.create', compact('categorias', 'ingredientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_base' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|url',
            'disponible' => 'boolean',
            'es_personalizado' => 'boolean',
            'calorias' => 'nullable|integer',
            'tiempo_preparacion' => 'nullable|integer',
            'ingredientes' => 'nullable|array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ]);

        $producto = Producto::create($request->except('ingredientes'));

        if ($request->has('ingredientes')) {
            $ingredientesSync = [];
            foreach ($request->ingredientes as $ingredienteId) {
                $ingredientesSync[$ingredienteId] = ['es_default' => true];
            }
            $producto->ingredientes()->sync($ingredientesSync);
        }

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente');
    }

    public function show(Producto $producto)
    {
        $producto->load('categoria', 'ingredientes');
        return view('admin.productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        $producto->load('ingredientes');
        return view('admin.productos.edit', compact('producto', 'categorias', 'ingredientes'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_base' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|url',
            'disponible' => 'boolean',
            'es_personalizado' => 'boolean',
            'tiempo_preparacion' => 'nullable|integer',
            'ingredientes' => 'nullable|array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ]);

        $producto->update($request->except('ingredientes'));

        $ingredientesSync = [];
        if ($request->has('ingredientes')) {
            foreach ($request->ingredientes as $ingredienteId) {
                $ingredientesSync[$ingredienteId] = ['es_default' => true];
            }
        }
        $producto->ingredientes()->sync($ingredientesSync);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente');
    }
}