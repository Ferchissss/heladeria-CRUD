@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Lista de Productos</h1>

    <a href="{{ route('admin.productos.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-4">
        Nuevo Producto
    </a>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                <tr>
                    <th class="p-3 border-b">ID</th>
                    <th class="p-3 border-b">Nombre</th>
                    <th class="p-3 border-b">Categoría</th>
                    <th class="p-3 border-b">Precio</th>
                    <th class="p-3 border-b">Disponible</th>
                    <th class="p-3 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800">
                @foreach($productos as $producto)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $producto->id }}</td>
                    <td class="p-3 border-b">{{ $producto->nombre }}</td>
                    <td class="p-3 border-b">{{ $producto->categoria?->nombre }}</td>
                    <td class="p-3 border-b">${{ number_format($producto->precio_base, 2) }}</td>
                    <td class="p-3 border-b">{{ $producto->disponible ? 'Sí' : 'No' }}</td>
                    <td class="p-3 border-b space-x-2">
                        <a href="{{ route('admin.productos.show', ['producto' => $producto->id]) }}"
                           class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs hover:bg-blue-200">Ver</a>
                        <a href="{{ route('admin.productos.edit', ['producto' => $producto->id]) }}"
                           class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs hover:bg-yellow-200">Editar</a>
                        <form action="{{ route('admin.productos.destroy', ['producto' => $producto->id]) }}"
                              method="POST" class="inline-block"
                              onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs hover:bg-red-200">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $productos->links() }}
    </div>
</div>
@endsection
