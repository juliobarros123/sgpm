<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\LocationController;
use App\Livewire\Admin\MaterialComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('acesso-negado', function () {
    abort(403, 'Você não tem permissão para acessar esta página.');
})->name('acesso-negado');
Route::get('test', function () {
    return view('welcome');
});