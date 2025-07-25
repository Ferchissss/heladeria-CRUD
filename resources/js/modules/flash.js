export function showFlash(message, type = 'success') {
    // Si usas Livewire
    if (window.Livewire) {
        window.Livewire.emit('flash-message', { message, type });
        return;
    }

    // Fallback para Alpine.js
    const event = new CustomEvent('flash-message', { 
        detail: { message, type } 
    });
    window.dispatchEvent(event);

    // Fallback básico
    const container = document.getElementById('flash-message-container');
    if (container) {
        container.classList.remove('hidden');
        container.innerHTML = `
            <div class="text-white px-4 py-2 rounded-lg shadow-lg flex items-center justify-between min-w-[300px] 
                        ${type === 'success' ? 'bg-green-500' : 
                          type === 'error' ? 'bg-red-500' :
                          type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'}">
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        `;
        
        setTimeout(() => {
            container.classList.add('hidden');
        }, 3000);
    }
}

// Función para inicializar desde sesión PHP
export function initFlashFromSession() {
    const flashData = JSON.parse(document.getElementById('flash-data').textContent);
    if (flashData) {
        showFlash(flashData.message, flashData.type);
    }
}