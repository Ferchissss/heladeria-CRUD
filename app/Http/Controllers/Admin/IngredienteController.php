<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class IngredienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Ingrediente::query();

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
            $query->where('disponible', 0);
        } elseif ($estado === '1') {
            $query->where('disponible', 1);
        }

        $ingredientes = $query->paginate(10);

        return view('admin.ingredientes.index', compact('ingredientes'));
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:50|unique:ingredientes,nombre',
                'descripcion' => 'nullable|string|max:500',
                'precio_extra' => 'required|numeric|min:0',
                'disponible' => 'required|boolean',
                'tipo' => 'required|string|max:100',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $imagenPath = null;
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = Str::slug($validated['nombre']) . '-' . time() . '.' . $imagen->getClientOriginalExtension();
                $imagenPath = $imagen->storeAs('ingredientes', $nombreImagen, 'public');
            }

            $ingrediente = Ingrediente::create([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'],
                'precio_extra' => $validated['precio_extra'],
                'disponible' => $request->has('disponible'),
                'tipo' => $request->has('tipo'),
                'imagen_url' => $imagenPath
            ]);

            return response()->json(['success' => true,'message' => 'Ingrediente creada exitosamente','data' => $ingrediente]);

        }   catch (\Exception $e) {
                return response()->json(['success' => false,'message' => $e->getMessage()], 500);
            }
    }
    public function show($id) {
        $ingrediente = Ingrediente::findOrFail($id);
        return view('admin.ingredientes._modal-show', compact('ingrediente'));
    }
    public function edit($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        return view('admin.ingredientes._modal-edit', compact('ingrediente'));
    }
    public function update(Request $request, $id) 
    {
        try {
            $ingrediente = Ingrediente::findOrFail($id);
            
            $validated = $request->validate([
                'nombre' => 'required|string|max:255|unique:ingredientes,nombre,'.$ingrediente->id,
                'descripcion' => 'nullable|string|max:500',
                'orden_display' => 'required|integer|min:0',
                'activa' => 'required|boolean',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'eliminar_imagen' => 'nullable|boolean'
            ]);

            // Procesar imagen
            if($request->has('eliminar_imagen') && $request->eliminar_imagen) {
                if($ingrediente->imagen_url) {
                    Storage::disk('public')->delete($ingrediente->imagen_url);
                }
                $validated['imagen_url'] = null;
            } elseif($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if($ingrediente->imagen_url) {
                    Storage::disk('public')->delete($ingrediente->imagen_url);
                }
                // Guardar nueva imagen
                $imagen = $request->file('imagen');
                $nombreImagen = Str::slug($validated['nombre']) . '-' . time() . '.' . $imagen->getClientOriginalExtension();
                $validated['imagen_url'] = $imagen->storeAs('ingredientes', $nombreImagen, 'public');
            }
            
            $ingrediente->update($validated);

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
    public function destroy(Ingrediente $ingrediente)
    {
        try {
            // Eliminar la imagen si existe
            if ($ingrediente->imagen_url) {
                Storage::disk('public')->delete($ingrediente->imagen_url);
            }

            $ingrediente->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categoría eliminada correctamente',
                'id' => $ingrediente->id
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
