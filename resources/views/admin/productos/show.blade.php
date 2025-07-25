@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Detalles del Producto</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-2">{{ $producto->nombre }}</h2>
        <p class="text-gray-700 mb-4">{{ $producto->descripcion }}</p>

        <ul class="divide-y divide-gray-200">
            <li class="py-2"><strong class="text-gray-800">Categoría:</strong> {{ $producto->categoria->nombre }}</li>
            <li class="py-2"><strong class="text-gray-800">Precio Base:</strong> ${{ number_format($producto->precio_base, 2) }}</li>
            <li class="py-2"><strong class="text-gray-800">Disponible:</strong> {{ $producto->disponible ? 'Sí' : 'No' }}</li>
            <li class="py-2"><strong class="text-gray-800">Personalizable:</strong> {{ $producto->es_personalizado ? 'Sí' : 'No' }}</li>
            <li class="py-2"><strong class="text-gray-800">Calorías:</strong> {{ $producto->calorias ?? 'N/A' }}</li>
            <li class="py-2"><strong class="text-gray-800">Tiempo Preparación:</strong> {{ $producto->tiempo_preparacion ? $producto->tiempo_preparacion . ' minutos' : 'N/A' }}</li>
            <li class="py-2">
                <strong class="text-gray-800">Ingredientes:</strong>
                <ul class="list-disc list-inside mt-1 text-gray-700">
                    @forelse($producto->ingredientes as $ingrediente)
                        <li>{{ $ingrediente->nombre }}</li>
                    @empty
                        <li>No hay ingredientes registrados</li>
                    @endforelse
                </ul>
            </li>
        </ul>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('admin.productos.edit', $producto) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Editar
            </a>
            <a href="{{ route('admin.productos.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection
