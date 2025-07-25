// --- Control genérico de modales ---
window.openModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.remove('hidden');
}

window.closeModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.add('hidden');
}

// Cerrar si se hace click fuera del contenido
document.addEventListener('click', function (e) {
    document.querySelectorAll('.modal-bg').forEach(modal => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
// Cerrar si se presiona la tecla Escape         
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-bg').forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                closeModal(modal.id);
            }
        });
    }
});
