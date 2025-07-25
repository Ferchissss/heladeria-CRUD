@extends('layout.admin')

@section('title', 'Ingredientes')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Gestión de Ingredientes</h1>
            <p class="mt-2 text-gray-600">Administra los ingredientes disponibles</p>
        </div>
        <button type="button" onclick="openModal('modalIngrediente')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nuevo Ingrediente</button>
    </div>
    
    <!-- Filtros y Búsqueda -->
    <div class="bg-white p-3 rounded border border-gray-200 mb-4">
        <form action="{{ route('admin.ingredientes.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <!-- Campo de búsqueda -->
            <div class="flex-1 relative">
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    class="w-full pr-8 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm" 
                    placeholder="Buscar por nombre o descripción"
                    oninput="toggleClearBtn()"
                >
                <button type="button" 
                    id="clearSearchBtn"
                    onclick="clearSearch()"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 text-sm hidden">
                    &times;
                </button>
            </div>
            <!-- Filtro por disponibilidad -->
            <div>
                <select name="disponible" id="disponible" onchange="this.form.submit()" class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm">
                    <option value="1" {{ request('disponible', '1') == '1' ? 'selected' : '' }}>Disponible</option>            
                    <option value="2" {{ request('disponible') == '2' ? 'selected' : '' }}>Todos</option>                 
                    <option value="0" {{ request('disponible') == '0' ? 'selected' : '' }}>No disponible</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Tabla de ingredientes -->
    <div class="bg-white shadow border rounded-md overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 text-left text-sm uppercase text-gray-600">
                    <th class="py-3 px-4">Nombre</th>
                    <th class="py-3 px-4">Tipo</th>
                    <th class="py-3 px-4">Precio Extra</th>
                    <th class="py-3 px-4">Disponibilidad</th>
                    <th class="py-3 px-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                @forelse($ingredientes as $ingrediente)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                @if($ingrediente->imagen_url)
                                    <img src="{{ asset('storage/' . $ingrediente->imagen_url) }}" alt="Imagen {{ $ingrediente->nombre }}" class="w-10 h-10 object-cover rounded">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                @endif

                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $ingrediente->nombre }}</span>
                                    <span class="text-gray-500 text-sm">{{ Str::limit($ingrediente->descripcion, 50) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">{{ $ingrediente->tipo }}</td>
                        <td class="py-4 px-4">${{ number_format($ingrediente->precio_extra, 2) }}</td>
                        <td class="py-4 px-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $ingrediente->disponible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $ingrediente->disponible ? 'Disponible' : 'No disponible' }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.ingredientes.show', $ingrediente->id) }}" onclick="event.preventDefault(); openModalWithData(this, 'modalVerIngrediente')"  class="text-gray-600 hover:text-gray-800" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.ingredientes.edit', $ingrediente->id) }}" onclick="event.preventDefault(); openModalWithData(this, 'modalEditIngrediente')" class="text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                <button type="button" onclick="openDeleteModal({{ $ingrediente->id }})" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">
                            No se encontraron ingredientes con los filtros aplicados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Modales -->
        <div id="modalVerIngrediente" class="modal-bg fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
            <div class="bg-white w-full max-w-md p-6 rounded shadow-lg relative"></div>
        </div>

        <div id="modalEditIngrediente" class="modal-bg fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
            <div class="bg-white w-full max-w-md p-6 rounded shadow-lg relative"></div>
        </div>

        <div id="modalDeleteIngrediente" class="modal-bg fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
            <div class="bg-white w-full max-w-md p-6 rounded shadow-lg relative">
                <h3 class="text-lg font-medium text-gray-900">Confirmar eliminación</h3>
                <p class="mt-2 text-gray-600">¿Estás seguro que deseas eliminar este ingrediente? Esta acción no se puede deshacer.</p>
                
                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('modalDeleteIngrediente')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Cancelar
                    </button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Paginación -->
    <div class="mt-4">
        {{ $ingredientes->appends(request()->query())->links() }}
    </div>

    @include('admin.ingredientes._modal-create')
@endsection

@push('scripts')
<script>
    function toggleClearBtn() {
        const input = document.getElementById('search');
        const btn = document.getElementById('clearSearchBtn');
        btn.classList.toggle('hidden', input.value.trim() === '');
    }

    function clearSearch() {
        const input = document.getElementById('search');
        input.value = '';
        toggleClearBtn();
        input.form.submit();
    }

    document.addEventListener('DOMContentLoaded', toggleClearBtn);

    function openModalWithData(element, modalId) {
        event.preventDefault();
        const url = element.getAttribute('href');

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.querySelector(`#${modalId} > div`).innerHTML = html;
            document.getElementById(modalId).classList.remove('hidden');
        })
        .catch(error => console.error('Error:', error));
    }
    function loadEditForm(id) {
            const url = `${window.location.origin}/admin/ingredientes/${id}?edit=true`;
            const modal = document.getElementById('modalVerIngrediente');
            
            // Mostrar modal con spinner de carga
            modal.classList.remove('hidden');
            modal.querySelector('div').innerHTML = '<div class="text-center py-8"><div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div></div>';
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Error al cargar el formulario');
                return response.text();
            })
            .then(html => {
                modal.querySelector('div').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                modal.querySelector('div').innerHTML = `<div class="text-red-500 p-4">${error.message}</div>`;
            });
        }

    function openDeleteModal(id) {
        const modal = document.getElementById('modalDeleteIngrediente');
        const form = document.getElementById('deleteForm');
        form.action = `/admin/ingredientes/${id}`;
        modal.classList.remove('hidden');
    }

    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Eliminando...';

        const formData = new FormData(form);
        formData.append('_method', 'DELETE');

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error al eliminar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Eliminar';
        });
    });

    document.addEventListener('submit', function(e) {
        if (e.target.closest('form[action*="/ingredientes/"]')) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
</script>
@endpush
