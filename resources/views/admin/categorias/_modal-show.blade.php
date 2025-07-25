<button onclick="closeModal('modalVerCategoria')" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

<h2 class="text-xl font-bold mb-4">Detalles de la Categoría</h2>

<div class="space-y-4">
    @if($categoria->imagen_url)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $categoria->imagen_url) }}" alt="{{ $categoria->nombre }}" class="h-28 object-cover rounded">
        </div>
    @endif

    <div>
        <label class="block text-sm mb-1 text-gray-700">Nombre:</label>
        <p class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-50">{{ $categoria->nombre }}</p>
    </div>

    <div>
        <label class="block text-sm mb-1 text-gray-700">Descripción:</label>
        <p class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-50 min-h-[100px]">{{ $categoria->descripcion ?? 'Sin descripción' }}</p>
    </div>

    <div>
        <label class="block text-sm mb-1 text-gray-700">Orden de visualización:</label>
        <p class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-50">{{ $categoria->orden_display }}</p>
    </div>

            <div class="mb-4">
                <label for="activa" class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" id="activa" name="activa" value="1" 
                            class="sr-only" {{ old('activa', true) ? 'checked' : '' }}>
                        <div class="block w-10 h-6 rounded-full {{ old('activa', true) ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition {{ old('activa', true) ? 'transform translate-x-4' : '' }}"></div>
                    </div>
                    <span class="ml-3 text-sm text-gray-700">Categoría activa</span>
                </label>
            </div>
</div>

<div class="flex justify-end mt-6">
    <button onclick="closeModal('modalVerCategoria')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
        Cerrar
    </button>
</div>