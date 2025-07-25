@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl">
    <h1 class="text-2xl font-bold mb-6">Editar Producto</h1>

    <form action="{{ route('admin.productos.update', $producto) }}" method="POST" class="space-y-6 bg-white shadow-md rounded px-6 py-8">
        @csrf
        @method('PUT')

        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="nombre" required
                   value="{{ $producto->nombre }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $producto->descripcion }}</textarea>
        </div>

        <div>
            <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
            <select name="categoria_id" id="categoria_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="precio_base" class="block text-sm font-medium text-gray-700">Precio Base</label>
            <input type="number" step="0.01" name="precio_base" id="precio_base" required
                   value="{{ $producto->precio_base }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="imagen_url" class="block text-sm font-medium text-gray-700">URL de la Imagen</label>
            <input type="url" name="imagen_url" id="imagen_url"
                   value="{{ $producto->imagen_url }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <input type="checkbox" name="disponible" id="disponible" value="1"
                       {{ $producto->disponible ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="disponible" class="ml-2 text-sm text-gray-700">Disponible</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="es_personalizado" id="es_personalizado" value="1"
                       {{ $producto->es_personalizado ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="es_personalizado" class="ml-2 text-sm text-gray-700">Es Personalizable</label>
            </div>
        </div>

        <div>
            <label for="calorias" class="block text-sm font-medium text-gray-700">Calorías</label>
            <input type="number" name="calorias" id="calorias"
                   value="{{ $producto->calorias }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="tiempo_preparacion" class="block text-sm font-medium text-gray-700">Tiempo de Preparación (minutos)</label>
            <input type="number" name="tiempo_preparacion" id="tiempo_preparacion"
                   value="{{ $producto->tiempo_preparacion }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Ingredientes</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($ingredientes as $ingrediente)
                <div class="flex items-center">
                    <input type="checkbox" name="ingredientes[]" id="ingrediente_{{ $ingrediente->id }}"
                           value="{{ $ingrediente->id }}"
                           {{ $producto->ingredientes->contains($ingrediente->id) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="ingrediente_{{ $ingrediente->id }}" class="ml-2 text-sm text-gray-700">
                        {{ $ingrediente->nombre }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Actualizar Producto
            </button>
            <a href="{{ route('admin.productos.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
