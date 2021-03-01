<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CotCatalogoCreditoController;
use App\Models\CotCatalogoCredito;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/catalogo-creditos', [CotCatalogoCreditoController::class, 'index'])->name('catalogo-creditos.index');
Route::post('/catalogo-creditos', [CotCatalogoCreditoController::class, 'postIndex'])->name('catalogo-creditos.post');
Route::get('/admin/index', [AdministradorController::class, 'index'])->name('administrador.index');
Auth::routes(['register' => false]);

