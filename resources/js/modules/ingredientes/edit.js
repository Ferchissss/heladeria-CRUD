// 1. Funciones de validación (las mismas que en create.js pero ajustando el campo 'orden_display')
function validateEditForm(form) {
    let isValid = true;

    // Validar nombre
    const nombre = form.querySelector('[name="nombre"]');
    if (!nombre.value.trim()) {
        showError(nombre, 'El nombre es obligatorio');
        isValid = false;
    } else if (nombre.value.length > 255) { // Ajustado a 255 para coincidir con la validación del servidor
        showError(nombre, 'El nombre no debe exceder 255 caracteres');
        isValid = false;
    } else {
        clearError(nombre);
    }

    // Validar descripción
    const descripcion = form.querySelector('[name="descripcion"]');
    if (descripcion.value.length > 500) {
        showError(descripcion, 'La descripción no debe exceder 500 caracteres');
        isValid = false;
    } else {
        clearError(descripcion);
    }

    // Validar orden (ahora orden_display)
    const orden = form.querySelector('[name="orden_display"]');
    if (!orden.value.trim()) {
        showError(orden, 'El orden es obligatorio');
        isValid = false;
    } else if (isNaN(orden.value) || parseInt(orden.value) < 0) {
        showError(orden, 'El orden debe ser un número positivo');
        isValid = false;
    } else {
        clearError(orden);
    }

    return isValid;
}

function showError(input, message) {
    const errorSpan = input.nextElementSibling;
    if (errorSpan && errorSpan.classList.contains('text-red-500')) {
        errorSpan.textContent = message;
    } else {
        const newErrorSpan = document.createElement('span');
        newErrorSpan.className = 'text-red-500 text-xs';
        newErrorSpan.textContent = message;
        input.parentNode.insertBefore(newErrorSpan, input.nextSibling);
    }
    input.classList.add('border-red-500');
}

function clearError(input) {
    const errorSpan = input.nextElementSibling;
    if (errorSpan && errorSpan.classList.contains('text-red-500')) {
        errorSpan.remove();
    }
    input.classList.remove('border-red-500');
}

// 2. Función para mostrar notificación flash (la misma)
function showFlashNotification(message, type = 'success') {
    let flashContainer = document.getElementById('flash-notification-container');
    
    if (!flashContainer) {
        flashContainer = document.createElement('div');
        flashContainer.id = 'flash-notification-container';
        flashContainer.className = 'fixed top-4 right-4 z-[1000]';
        document.body.appendChild(flashContainer);
    }

    const notification = document.createElement('div');
    notification.className = `px-4 py-2 mb-2 rounded-md shadow-lg text-white ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    }`;
    notification.textContent = message;
    
    flashContainer.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// 3. Función principal para inicializar el formulario de edición
function initEditIngredienteForm() {
    const form = document.getElementById('editCategoryForm');
    if (!form) return;

    // Configurar eventos específicos de edición
    const imagenInput = document.getElementById('imagenInput');
    const activaToggle = form.querySelector('[name="activa"]');

    // Manejar cambio de imagen (muestra el nombre del archivo)
    if (imagenInput) {
        imagenInput.addEventListener('change', function() {
            document.getElementById('fileName').textContent = this.files[0]?.name || '';
        });
    }

    // Manejar el toggle de activa
    if (activaToggle) {
        activaToggle.addEventListener('change', function() {
            const toggleBg = this.nextElementSibling;
            const dot = toggleBg.nextElementSibling;
            const isChecked = this.checked;
            
            toggleBg.classList.toggle('bg-blue-500', isChecked);
            toggleBg.classList.toggle('bg-gray-300', !isChecked);
            dot.classList.toggle('translate-x-4', isChecked);
        });
    }

    // Manejar envío del formulario
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateEditForm(this)) return false;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            showFlashNotification('Error de seguridad. Recarga la página.', 'error');
            return;
        }

        const submitBtn = form.querySelector('[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Guardando...';

        try {
            const formData = new FormData(this);
            const response = await fetch(this.action, {
                method: 'POST', // Usar POST aunque sea PUT por el method spoofing
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            // Procesar respuesta
            const data = await response.json();

            if (!response.ok) {
                // Mostrar errores de validación del servidor
                if (data.errors) {
                    Object.entries(data.errors).forEach(([field, messages]) => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) showError(input, messages[0]);
                    });
                }
                throw new Error(data.message || 'Error al guardar los cambios');
            }

            // Éxito
            showFlashNotification(data.message || '¡Cambios guardados!', 'success');
            
            // Cerrar modal y recargar
            setTimeout(() => {
                closeModal('modalEditIngrediente');
                window.location.reload();
            }, 1500);

        } catch (error) {
            console.error('Error en edición:', error);
            showFlashNotification(error.message, 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });

    // Abrir modal automáticamente si hay errores (útil cuando hay errores de validación del servidor)
    if (form.querySelector('.border-red-500')) {
        openModal('modalEditIngrediente');
    }
}

export { initEditIngredienteForm };