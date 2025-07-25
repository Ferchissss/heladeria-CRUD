@extends('layout.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Detalles del Pedido #{{ $pedido->id }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Información del Pedido --}}
        <div class="bg-white shadow rounded-lg">
            <div class="border-b px-4 py-2">
                <h2 class="text-lg font-semibold">Información del Pedido</h2>
            </div>
            <div class="p-4 space-y-2 text-sm text-gray-700">
                <p><span class="font-semibold">Cliente:</span> {{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}</p>
                <p><span class="font-semibold">Fecha:</span> {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}</p>
                <p>
                    <span class="font-semibold">Estado:</span>
                    <span class="inline-block px-2 py-1 rounded text-white text-xs 
                        @if($pedido->estado == 'pendiente') bg-yellow-500
                        @elseif($pedido->estado == 'preparando') bg-blue-500
                        @elseif($pedido->estado == 'entregado') bg-green-500
                        @else bg-red-500
                        @endif">
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </p>
                <p><span class="font-semibold">Método de Pago:</span> {{ ucfirst($pedido->metodo_pago) }}</p>
                <p><span class="font-semibold">Dirección de Entrega:</span> {{ $pedido->direccion_entrega ?? 'N/A' }}</p>
                <p><span class="font-semibold">Notas:</span> {{ $pedido->notas ?? 'Ninguna' }}</p>
            </div>
        </div>

        {{-- Resumen del Pedido --}}
        <div class="bg-white shadow rounded-lg">
            <div class="border-b px-4 py-2">
                <h2 class="text-lg font-semibold">Resumen del Pedido</h2>
            </div>
            <div class="p-4 text-sm text-gray-700">
                <div class="flex justify-between mb-2">
                    <span class="font-semibold">Subtotal:</span>
                    <span>${{ number_format($pedido->total, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold text-gray-900">
                    <span>Total:</span>
                    <span>${{ number_format($pedido->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Productos del Pedido --}}
    <div class="bg-white shadow rounded-lg mt-6">
        <div class="border-b px-4 py-2">
            <h2 class="text-lg font-semibold">Productos</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Producto</th>
                        <th class="px-4 py-3">Cantidad</th>
                        <th class="px-4 py-3">Precio Unitario</th>
                        <th class="px-4 py-3">Subtotal</th>
                        <th class="px-4 py-3">Instrucciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($pedido->detalles as $detalle)
                    <tr class="bg-white">
                        <td class="px-4 py-3">
                            @if($detalle->producto)
                                {{ $detalle->producto->nombre }}
                            @else
                                <span class="italic text-gray-400">Producto eliminado</span>
                            @endif
                            @if($detalle->ingredientes->count())
                                <br>
                                <small class="text-gray-500">
                                    <strong>Ingredientes:</strong> 
                                    {{ $detalle->ingredientes->pluck('nombre')->implode(', ') }}
                                </small>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $detalle->cantidad }}</td>
                        <td class="px-4 py-3">${{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td class="px-4 py-3">${{ number_format($detalle->subtotal, 2) }}</td>
                        <td class="px-4 py-3">{{ $detalle->instrucciones_especiales ?? 'Ninguna' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Acciones --}}
    <div class="mt-6 flex space-x-2">
        <a href="{{ route('admin.pedidos.edit', $pedido) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Editar Pedido
        </a>
        <a href="{{ route('admin.pedidos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Volver
        </a>
    </div>
</div>
@endsection
