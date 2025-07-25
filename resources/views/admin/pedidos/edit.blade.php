@extends('layout.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Editar Pedido #{{ $pedido->id }}</h1>

    <form action="{{ route('admin.pedidos.update', $pedido) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Cliente --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Cliente</label>
                <input type="text" class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded px-3 py-2" 
                       value="{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}" readonly>
            </div>

            {{-- Estado --}}
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado *</label>
                <select name="estado" id="estado" required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 bg-white">
                    <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="preparando" {{ $pedido->estado == 'preparando' ? 'selected' : '' }}>Preparando</option>
                    <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            {{-- Método de Pago --}}
            <div>
                <label for="metodo_pago" class="block text-sm font-medium text-gray-700">Método de Pago *</label>
                <select name="metodo_pago" id="metodo_pago" required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 bg-white">
                    <option value="efectivo" {{ $pedido->metodo_pago == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="tarjeta" {{ $pedido->metodo_pago == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="qr" {{ $pedido->metodo_pago == 'qr' ? 'selected' : '' }}>QR</option>
                    <option value="transferencia" {{ $pedido->metodo_pago == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>

            {{-- Dirección --}}
            <div>
                <label for="direccion_entrega" class="block text-sm font-medium text-gray-700">Dirección de Entrega</label>
                <input type="text" name="direccion_entrega" id="direccion_entrega" 
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
                    value="{{ $pedido->direccion_entrega }}">
            </div>
        </div>

        {{-- Notas --}}
        <div>
            <label for="notas" class="block text-sm font-medium text-gray-700">Notas</label>
            <textarea name="notas" id="notas" rows="2"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">{{ $pedido->notas }}</textarea>
        </div>

        {{-- Productos --}}
        <h3 class="text-lg font-semibold mt-6">Productos</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white text-sm text-left mt-2 border border-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase">
                    <tr>
                        <th class="px-4 py-2 border">Producto</th>
                        <th class="px-4 py-2 border">Cantidad</th>
                        <th class="px-4 py-2 border">Precio Unitario</th>
                        <th class="px-4 py-2 border">Subtotal</th>
                        <th class="px-4 py-2 border">Instrucciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->detalles as $detalle)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                        <td class="px-4 py-2">{{ $detalle->cantidad }}</td>
                        <td class="px-4 py-2">${{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td class="px-4 py-2">${{ number_format($detalle->subtotal, 2) }}</td>
                        <td class="px-4 py-2">{{ $detalle->instrucciones_especiales ?? 'Ninguna' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Total --}}
        <div class="mt-4">
            <h4 class="text-xl font-bold">Total: ${{ number_format($pedido->total, 2) }}</h4>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex space-x-3">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                Actualizar Pedido
            </button>
            <a href="{{ route('admin.pedidos.show', $pedido) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
