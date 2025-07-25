<div id="modalEditIngrediente" class="modal-bg fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded shadow-lg relative">
        <!-- Botón cerrar -->
        <button onclick="closeModal('modalEditIngrediente')" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

        <h2 class="text-xl font-bold mb-4">Editar Ingrediente</h2>

        <form action="{{ route('admin.ingredientes.update', $ingrediente->id) }}" method="POST" enctype="multipart/form-data" id="editIngredientForm">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Imagen actual -->
                <div class="mb-4">
                    <label class="block text-sm mb-1 text-gray-700">Imagen actual:</label>
                    @if($ingrediente->imagen_url)
                        <img src="{{ asset('storage/' . $ingrediente->imagen_url) }}" alt="Imagen actual" class="w-full h-48 object-cover rounded mb-2">
                        <label class="flex items-center mt-2">
                            <input type="checkbox" name="eliminar_imagen" class="mr-2">
                            <span class="text-sm text-gray-600">Eliminar imagen actual</span>
                        </label>
                    @else
                        <p class="text-sm text-gray-500">No hay imagen cargada</p>
                    @endif

                    <label class="block text-sm mb-1 mt-4 text-gray-700">Nueva imagen:</label>
                    <input type="file" name="imagen" id="imagenInput" accept="image/*" class="hidden">
                    <button type="button" onclick="document.getElementById('imagenInput').click()" 
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                        Seleccionar imagen
                    </button>
                    <p id="fileName" class="text-sm text-gray-600 mt-2"></p>
                    @error('imagen')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nombre -->
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Nombre:</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $ingrediente->nombre) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                           required maxlength="255">
                    @error('nombre')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Descripción:</label>
                    <textarea name="descripcion" class="w-full border border-gray-300 rounded px-3 py-2 text-sm min-h-[100px] focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('descripcion', $ingrediente->descripcion) }}</textarea>
                    @error('descripcion')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Precio extra -->
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Precio extra:</label>
                    <input type="number" name="precio_extra" value="{{ old('precio_extra', $ingrediente->precio_extra) }}" 
                           min="0" step="0.01"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                    @error('precio_extra')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tipo -->
                <div>
                    <label class="block text-sm mb-1 text-gray-700">Tipo:</label>
                    <input type="text" name="tipo" value="{{ old('tipo', $ingrediente->tipo) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                    @error('tipo')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Disponible -->
                <div>
                    <label class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="disponible" value="1" 
                                   class="sr-only" {{ old('disponible', $ingrediente->disponible) ? 'checked' : '' }}>
                            <div class="block w-10 h-6 rounded-full {{ old('disponible', $ingrediente->disponible) ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition {{ old('disponible', $ingrediente->disponible) ? 'transform translate-x-4' : '' }}"></div>
                        </div>
                        <span class="ml-3 text-sm text-gray-700">Disponible</span>
                    </label>
                    @error('disponible')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('modalEditIngrediente')" 
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
                    Cancelar
                </button>
                <button type="submit" id="submitBtn" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>