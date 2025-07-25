@extends('layout.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Editar Cliente</h1>

    <form action="{{ route('admin.clientes.update', $cliente) }}" method="POST" class="space-y-6 bg-white shadow-md rounded px-6 py-8">
        @csrf
        @method('PUT')

        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ $cliente->nombre }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="{{ $cliente->apellido }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ $cliente->email }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input type="text" name="telefono" id="telefono" value="{{ $cliente->telefono }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
            <textarea name="direccion" id="direccion" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $cliente->direccion }}</textarea>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña <span class="text-gray-400 text-xs">(dejar en blanco para no cambiar)</span></label>
            <input type="password" name="password" id="password"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="activo" id="activo" value="1" {{ $cliente->activo ? 'checked' : '' }}
                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="activo" class="ml-2 text-sm text-gray-700">Activo</label>
        </div>

        <div class="flex justify-between pt-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Actualizar Cliente
            </button>
            <a href="{{ route('admin.clientes.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
