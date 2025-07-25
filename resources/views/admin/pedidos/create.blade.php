@extends('layout.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Crear Nuevo Pedido</h1>

    <form action="{{ route('admin.pedidos.store') }}" method="POST" id="pedidoForm" class="space-y-6">
        @csrf

        {{-- Datos del Cliente y Pedido --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente *</label>
                <select name="cliente_id" id="cliente_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->cliente_id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado *</label>
                <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="pendiente" selected>Pendiente</option>
                    <option value="preparando">Preparando</option>
                    <option value="entregado">Entregado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>

            <div>
                <label for="metodo_pago" class="block text-sm font-medium text-gray-700">Método de Pago *</label>
                <select name="metodo_pago" id="metodo_pago" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="qr">QR</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>

            <div>
                <label for="direccion_entrega" class="block text-sm font-medium text-gray-700">Dirección de Entrega</label>
                <input type="text" name="direccion_entrega" id="direccion_entrega" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        {{-- Notas --}}
        <div>
            <label for="notas" class="block text-sm font-medium text-gray-700">Notas</label>
            <textarea name="notas" id="notas" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
        </div>

        {{-- Productos --}}
        <h3 class="text-lg font-semibold mt-4">Productos</h3>
        <div id="productos-container" class="space-y-4">
            <div class="producto-item grid md:grid-cols-5 gap-4 items-end">
                <select name="productos[0][id]" class="producto-select col-span-2 border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Seleccione un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_base }}">{{ $producto->nombre }} (${{ number_format($producto->precio_base, 2) }})</option>
                    @endforeach
                </select>

                <input type="number" name="productos[0][cantidad]" value="1" min="1" class="cantidad border-gray-300 rounded-md shadow-sm" required>

                <input type="number" step="0.01" name="productos[0][precio]" class="precio border-gray-300 rounded-md shadow-sm" required>

                <button type="button" class="btn-remove-producto bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">Eliminar</button>

                <div class="col-span-5">
                    <input type="text" name="productos[0][instrucciones]" placeholder="Instrucciones especiales" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        </div>

        {{-- Botón Añadir Producto --}}
        <button type="button" id="btn-add-producto" class="bg-gray-700 hover:bg-gray-800 text-white text-sm px-4 py-2 rounded mt-2">
            Añadir Producto
        </button>

        {{-- Total --}}
        <div class="mt-6 text-lg font-semibold">
            Total: $<span id="total-pedido">0.00</span>
        </div>

        {{-- Botones de acción --}}
        <div class="flex gap-4 mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Guardar Pedido
            </button>
            <a href="{{ route('admin.pedidos.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded">
                Cancelar
            </a>
        </div>
    </form>
</div>

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    let productoCounter = 1;

    // Añadir nuevo producto
    document.getElementById('btn-add-producto').addEventListener('click', function() {
        const template = document.querySelector('.producto-item').cloneNode(true);
        template.innerHTML = template.innerHTML.replace(/productos\[0\]/g, `productos[${productoCounter}]`);
        template.querySelector('.cantidad').value = 1;
        template.querySelector('.precio').value = '';
        template.querySelector('.producto-select').selectedIndex = 0;
        document.getElementById('productos-container').appendChild(template);
        productoCounter++;
        calcularTotal();
    });

    // Eliminar producto
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-producto')) {
            const items = document.querySelectorAll('.producto-item');
            if (items.length > 1) {
                e.target.closest('.producto-item').remove();
                calcularTotal();
            }
        }
    });

    // Selección de producto
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('producto-select')) {
            const precio = e.target.selectedOptions[0]?.dataset.precio || 0;
            e.target.closest('.producto-item').querySelector('.precio').value = parseFloat(precio).toFixed(2);
            calcularTotal();
        }
    });

    // Cambios en cantidad o precio
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('cantidad') || e.target.classList.contains('precio')) {
            calcularTotal();
        }
    });

    // Calcular total
    function calcularTotal() {
        let total = 0;
        document.querySelectorAll('.producto-item').forEach(item => {
            const cantidad = parseFloat(item.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(item.querySelector('.precio').value) || 0;
            total += cantidad * precio;
        });
        document.getElementById('total-pedido').textContent = total.toFixed(2);
    }

    calcularTotal();
});
</script>
@endsection
