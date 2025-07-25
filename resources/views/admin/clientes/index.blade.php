@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Lista de Clientes</h1>

    <a href="{{ route('admin.clientes.create') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-4">
        Nuevo Cliente
    </a>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                <tr>
                    <th class="p-3 border-b">ID</th>
                    <th class="p-3 border-b">Nombre</th>
                    <th class="p-3 border-b">Email</th>
                    <th class="p-3 border-b">Teléfono</th>
                    <th class="p-3 border-b">Registro</th>
                    <th class="p-3 border-b">Estado</th>
                    <th class="p-3 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800">
                @foreach($clientes as $cliente)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $cliente->id }}</td>
                    <td class="p-3 border-b">{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                    <td class="p-3 border-b">{{ $cliente->email }}</td>
                    <td class="p-3 border-b">{{ $cliente->telefono ?? 'N/A' }}</td>
                    <td class="p-3 border-b">{{ \Carbon\Carbon::parse($cliente->fecha_registro)->format('d/m/Y') }}</td>
                    <td class="p-3 border-b">
                        <span class="{{ $cliente->activo ? 'text-green-600' : 'text-red-600' }}">
                            {{ $cliente->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="p-3 border-b space-x-2 whitespace-nowrap">
                        <a href="{{ route('admin.clientes.show', ['cliente' => $cliente->id]) }}"
                           class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs hover:bg-blue-200">
                            Ver
                        </a>
                        <a href="{{ route('admin.clientes.edit', ['cliente' => $cliente->id]) }}"
                           class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs hover:bg-yellow-200">
                            Editar
                        </a>
                        <form action="{{ route('admin.clientes.destroy', ['cliente' => $cliente->id]) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('¿Eliminar este cliente?')">
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
        {{ $clientes->links() }}
    </div>
</div>
@endsection
