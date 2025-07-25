@extends('layout.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Lista de Pedidos</h1>

    <a href="{{ route('admin.pedidos.create') }}"
       class="inline-block mb-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        Nuevo Pedido
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Cliente</th>
                    <th class="px-4 py-2 border">Fecha</th>
                    <th class="px-4 py-2 border">Total</th>
                    <th class="px-4 py-2 border">Estado</th>
                    <th class="px-4 py-2 border">Método Pago</th>
                    <th class="px-4 py-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $pedido->id }}</td>
                    <td class="px-4 py-2">{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">${{ number_format($pedido->total, 2) }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($pedido->estado == 'pendiente') bg-yellow-100 text-yellow-800
                            @elseif($pedido->estado == 'preparando') bg-blue-100 text-blue-800
                            @elseif($pedido->estado == 'entregado') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ ucfirst($pedido->metodo_pago) }}</td>
                    <td class="px-4 py-2 space-x-1">
                        <a href="{{ route('admin.pedidos.show', $pedido) }}"
                           class="inline-block bg-cyan-600 text-white px-2 py-1 rounded text-xs hover:bg-cyan-700">
                            Ver
                        </a>
                        <a href="{{ route('admin.pedidos.edit', $pedido) }}"
                           class="inline-block bg-indigo-600 text-white px-2 py-1 rounded text-xs hover:bg-indigo-700">
                            Editar
                        </a>
                        <form action="{{ route('admin.pedidos.destroy', $pedido) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('¿Eliminar este pedido?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700">
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
        {{ $pedidos->links() }}
    </div>
</div>
@endsection
