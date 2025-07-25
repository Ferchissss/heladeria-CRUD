<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\IngredienteController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('admin.dashboard');
});
// Admin routes agrupadas
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::post('categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('categorias/{id}', [CategoriaController::class, 'show'])->name('categorias.show');
    Route::get('categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('categorias/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    Route::get('ingredientes', [IngredienteController::class, 'index'])->name('ingredientes.index');
    Route::post('ingredientes', [IngredienteController::class, 'store'])->name('ingredientes.store');
    Route::get('ingredientes/{id}', [IngredienteController::class, 'show'])->name('ingredientes.show');
    Route::get('ingredientes/{id}/edit', [IngredienteController::class, 'edit'])->name('ingredientes.edit');
    Route::put('ingredientes/{id}', [IngredienteController::class, 'update'])->name('ingredientes.update');
    Route::delete('ingredientes/{ingredientes}', [IngredienteController::class, 'destroy'])->name('ingredientes.destroy');

    Route::resource('productos', ProductoController::class)->names('productos');
    Route::resource('clientes', ClienteController::class)->names('clientes');
    Route::resource('pedidos', PedidoController::class)->names('pedidos');
});
