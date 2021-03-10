<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CotCatalogoCreditoController;
use App\Http\Controllers\cotCreditosController;
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
Route::get('/cotizacion/{id}', [CotCreditosController::class,'index'])->name('cotizacion.index');


Route::get('/envio-cotizacion/{id}', [CotCreditosController::class, 'mostrar'])->name('cotizacion.mostrar');

Route::post('/envio-cotizacion', [CotCreditosController::class, 'enviar'])->name('cotizacion.enviar');
Auth::routes(['register' => false]);