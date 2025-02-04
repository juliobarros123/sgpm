<?php
use App\Http\Controllers\Admin\GrupoController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Ajax\GraficoController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'access.aprovador'
])->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard.index');
    Route::get('/materiais', [MaterialController::class, 'index'])->name('materiais.index');
    Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos.index');
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
});




