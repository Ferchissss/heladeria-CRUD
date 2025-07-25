// 1. Mantenemos tus funciones de validación existentes
function validateForm(form) {
    let isValid = true;

    // Validar nombre
    const nombre = form.querySelector('[name="nombre"]');
    if (!nombre.value.trim()) {
        showError(nombre, 'El nombre es obligatorio');
        isValid = false;
    } else if (nombre.value.length > 50) {
        showError(nombre, 'El nombre no debe exceder 50 caracteres');
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
    // Validar precio extra
    const precioExtra = form.querySelector('[name="precio_extra"]');
    if (!precioExtra.value.trim()) {
        showError(precioExtra, 'El precio extra es obligatorio');
        isValid = false;
    } else if (isNaN(precioExtra.value) || parseFloat(precioExtra.value) < 0) {
        showError(precioExtra, 'El precio debe ser un número positivo');
        isValid = false;
    } else {
        clearError(precioExtra);
    }

    // Validar tipo
    const tipo = form.querySelector('[name="tipo"]');
    if (!tipo.value.trim()) {
        showError(tipo, 'El tipo es obligatorio');
        isValid = false;
    } else {
        clearError(tipo);
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

// 2. Función para mostrar notificación flash
function showFlashNotification(message, type = 'success') {
    // Crear el elemento de notificación si no existe
    let flashContainer = document.getElementById('flash-notification-container');
    
    if (!flashContainer) {
        flashContainer = document.createElement('div');
        flashContainer.id = 'flash-notification-container';
        flashContainer.className = 'fixed top-4 right-4 z-[1000]';
        document.body.appendChild(flashContainer);
    }

    // Crear la notificación
    const notification = document.createElement('div');
    notification.className = `px-4 py-2 mb-2 rounded-md shadow-lg text-white ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    }`;
    notification.textContent = message;
    
    // Agregar la notificación al contenedor
    flashContainer.appendChild(notification);
    
    // Eliminar después de 3 segundos
    setTimeout(() => {
        notification.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// 3. Función principal que inicializa el formulario
function initIngredienteForm() {
    const form = document.getElementById('ingredienteForm');
    if (!form) return;

    // Configurar eventos
    const imagenInput = document.getElementById('imagenInput');
    const activaToggle = document.getElementById('activa');

    if (imagenInput) {
        imagenInput.addEventListener('change', function() {
            document.getElementById('fileName').textContent = this.files[0]?.name || '';
        });
    }

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

        form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateForm(this)) return false;

        // 1. Obtener el token CSRF de manera segura
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        // Si no encuentra el token, muestra error
        if (!csrfToken) {
            console.error('Error: Token CSRF no encontrado');
            showFlashNotification('Error de seguridad. Recarga la página.', 'error');
            return;
        }

        // 2. Configurar los datos del formulario
        const formData = new FormData(this);

        try {
            // 3. Enviar la petición al servidor
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Token incluido aquí
                }
            });

            // 4. Procesar la respuesta
            if (response.ok) {
                const data = await response.json();
                showFlashNotification(data.message || '¡Éxito!', 'success');
                window.closeModal('modalIngrediente');
                
                // Opcional: Recargar la página después de 1 segundo
                setTimeout(() => window.location.reload(), 1000);
            } else {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Error desconocido');
            }
        } catch (error) {
            showFlashNotification(error.message, 'error');
            console.error('Error al enviar el formulario:', error);
        }
    });

    // Abrir modal si hay errores
    if (form.querySelector('.border-red-500')) {
        window.openModal('modalIngrediente');
    }
}

// 4. Exportamos solo la función principal que necesitamos
export { initIngredienteForm };