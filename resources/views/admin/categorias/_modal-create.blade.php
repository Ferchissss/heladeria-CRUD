<div id="modalCategoria" class="modal-bg fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded shadow-lg relative">
        <!-- Botón cerrar -->
        <button onclick="closeModal('modalCategoria')" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

        <h2 class="text-xl font-bold mb-4">Nueva Categoría</h2>
        <p>Ingresa los datos de la nueva categoría</p>

        <form action="{{ route('admin.categorias.store') }}" method="POST" enctype="multipart/form-data" id="categoriaForm">
            @csrf
            <div class="mb-4">
                <label class="block text-sm mb-1 text-gray-700">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required 
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 @error('nombre') border-red-500 @enderror">
                @error('nombre')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm mb-1 text-gray-700">Descripción</label>
                <textarea name="descripcion" 
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm mb-1 text-gray-700">Orden de visualización</label>
                <input type="number" name="orden" min="0" value="{{ old('orden', 1) }}" step="1" required 
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 @error('orden') border-red-500 @enderror">
                @error('orden')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm mb-1 text-gray-700">Imagen de la categoría</label>
                <button type="button" onclick="document.getElementById('imagenInput').click()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Subir imagen</button>

                <input type="file" name="imagen" id="imagenInput" accept="image/*" class="hidden @error('imagen') border-red-500 @enderror">

                <p id="fileName" class="text-sm text-gray-600 mt-2"></p>
                @error('imagen')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
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

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalCategoria')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>