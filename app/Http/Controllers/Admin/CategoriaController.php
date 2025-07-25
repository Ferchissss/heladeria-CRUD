<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        $estado = $request->input('estado', '1');
        if ($estado === '0') {
            $query->where('activa', 0);
        } elseif ($estado === '1') {
            $query->where('activa', 1);
        }

        // Ordenar por defecto
        $query->orderBy('orden_display');

        $categorias = $query->paginate(10);

        return view('admin.categorias.index', compact('categorias'));
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:50|unique:categorias,nombre',
                'descripcion' => 'nullable|string|max:500',
                'orden' => 'required|integer|min:0',
                'activa' => 'nullable|boolean',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $imagenPath = null;
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = Str::slug($validated['nombre']) . '-' . time() . '.' . $imagen->getClientOriginalExtension();
                $imagenPath = $imagen->storeAs('categorias', $nombreImagen, 'public');
            }

            $categoria = Categoria::create([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'],
                'orden_display' => $validated['orden'],
                'activa' => $request->has('activa'),
                'imagen_url' => $imagenPath
            ]);

            return response()->json(['success' => true,'message' => 'Categoría creada exitosamente','data' => $categoria]);

        }   catch (\Exception $e) {
                return response()->json(['success' => false,'message' => $e->getMessage()], 500);
            }
    }
    public function show($id) {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias._modal-show', compact('categoria'));
    }
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias._modal-edit', compact('categoria'));
    }
    public function update(Request $request, $id) 
    {
        try {
            $categoria = Categoria::findOrFail($id);
            
            $validated = $request->validate([
                'nombre' => 'required|string|max:255|unique:categorias,nombre,'.$categoria->id,
                'descripcion' => 'nullable|string|max:500',
                'orden_display' => 'required|integer|min:0',
                'activa' => 'required|boolean',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'eliminar_imagen' => 'nullable|boolean'
            ]);

            // Procesar imagen
            if($request->has('eliminar_imagen') && $request->eliminar_imagen) {
                if($categoria->imagen_url) {
                    Storage::disk('public')->delete($categoria->imagen_url);
                }
                $validated['imagen_url'] = null;
            } elseif($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if($categoria->imagen_url) {
                    Storage::disk('public')->delete($categoria->imagen_url);
                }
                // Guardar nueva imagen
                $imagen = $request->file('imagen');
                $nombreImagen = Str::slug($validated['nombre']) . '-' . time() . '.' . $imagen->getClientOriginalExtension();
                $validated['imagen_url'] = $imagen->storeAs('categorias', $nombreImagen, 'public');
            }
            
            $categoria->update($validated);

            return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada correctamente'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'errors' => $e->errors ?? null
        ], 500);
    }}
    public function destroy(Categoria $categoria)
    {
        try {
            // Eliminar la imagen si existe
            if ($categoria->imagen_url) {
                Storage::disk('public')->delete($categoria->imagen_url);
            }

            $categoria->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categoría eliminada correctamente',
                'id' => $categoria->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno al eliminar la categoría',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

