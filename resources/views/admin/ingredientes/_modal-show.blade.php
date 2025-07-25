<div id="modalVerIngrediente" class="modal-bg fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded shadow-lg relative">
        <!-- Botón cerrar -->
        <button onclick="closeModal('modalVerIngrediente')" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

        <h2 class="text-xl font-bold mb-4">Detalles del Ingrediente</h2>

        <div class="space-y-4">
            <!-- Imagen -->
            @if($ingrediente->imagen_url)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $ingrediente->imagen_url) }}" alt="{{ $ingrediente->nombre }}" class="h-28 object-cover rounded">
                </div>
            @endif

            <!-- Nombre -->
            <div>
                <label class="block text-sm mb-1 text-gray-700">Nombre:</label>
                <p class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-50">{{ $ingrediente->nombre }}</p>
            </div>

            <!-- Descripción -->
            <div>
                <label class="block text-sm mb-1 text-gray-700">Descripción:</label>
                <p class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-50 min-h-[100px]">
                    {{ $ingrediente->descripcion ?? 'Sin descripción' }}
                </p>
            </div>

            <!-- Precio extra -->
            <div>
                <label class="block text-sm mb-1 text-gray-700">Precio extra:</label>
                <p class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-50">${{ number_format($ingrediente->precio_extra, 2) }}</p>
            </div>

            <!-- Tipo -->
            <div>
                <label class="block text-sm mb-1 text-gray-700">Tipo:</label>
                <p class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-50">{{ $ingrediente->tipo }}</p>
            </div>

            <!-- Disponible -->
            <div class="mb-4">
                <label for="disponible" class="flex items-center cursor-default">
                    <div class="relative">
                        <input type="checkbox" id="disponible" disabled {{ $ingrediente->disponible ? 'checked' : '' }} class="sr-only">
                        <div class="block w-10 h-6 rounded-full {{ $ingrediente->disponible ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition {{ $ingrediente->disponible ? 'transform translate-x-4' : '' }}"></div>
                    </div>
                    <span class="ml-3 text-sm text-gray-700">Disponible</span>
                </label>
            </div>
        </div>

        <!-- Botón cerrar -->
        <div class="flex justify-end mt-6">
            <button onclick="closeModal('modalVerIngrediente')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
                Cerrar
            </button>
        </div>
    </div>
</div>