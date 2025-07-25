import { initCategoriaForm } from './modules/categorias/create';
import { initEditCategoriaForm } from './modules/categorias/edit';
import { initIngredienteForm } from './modules/ingredientes/create';
import { initEditIngredienteForm } from './modules/ingredientes/edit';
import './bootstrap';
import './modules/modal.js';
import { showFlash } from './modules/flash';

window.showFlash = showFlash;
document.addEventListener('DOMContentLoaded', function() {
    initCategoriaForm();
    initEditCategoriaForm();
    initIngredienteForm();
    initEditIngredienteForm();
});
