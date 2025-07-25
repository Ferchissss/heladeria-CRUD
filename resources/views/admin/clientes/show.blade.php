@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Detalles del Cliente</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">{{ $cliente->nombre }} {{ $cliente->apellido }}</h2>

        <ul class="divide-y divide-gray-200 text-sm text-gray-800">
            <li class="py-2">
                <strong class="text-gray-700">Email:</strong> {{ $cliente->email }}
            </li>
            <li class="py-2">
                <strong class="text-gray-700">Teléfono:</strong> {{ $cliente->telefono ?? 'N/A' }}
            </li>
            <li class="py-2">
                <strong class="text-gray-700">Dirección:</strong> {{ $cliente->direccion ?? 'N/A' }}
            </li>
            <li class="py-2">
                <strong class="text-gray-700">Fecha Registro:</strong> {{ \Carbon\Carbon::parse($cliente->fecha_registro)->format('d/m/Y') }}
            </li>
            <li class="py-2">
                <strong class="text-gray-700">Último Login:</strong> {{ $cliente->ultimo_login ? $cliente->ultimo_login->format('d/m/Y H:i') : 'Nunca' }}
            </li>
            <li class="py-2">
                <strong class="text-gray-700">Estado:</strong>
                <span class="{{ $cliente->activo ? 'text-green-600' : 'text-red-600' }}">
                    {{ $cliente->activo ? 'Activo' : 'Inactivo' }}
                </span>
            </li>
        </ul>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('admin.clientes.edit', $cliente) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Editar
            </a>
            <a href="{{ route('admin.clientes.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </div>
</div>
@endsection
