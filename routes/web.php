<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CotCatalogoCreditoController;
use App\Http\Controllers\cotCreditosController;
use App\Http\Controllers\CotCreditosDetController;
use App\Http\Controllers\MisPropuestasController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\HencorpPropuestasConfigController;
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
Route::get('/admin/gestion-propuesta', [CotCreditosDetController::class,'index'])->name('admin.gestion');
Route::put('/admin/gestion-propuesta/update', [CotCreditosDetController::class,'update'])->name('admin.update');

Route::get('/cotizacion/{id}', [CotCreditosController::class,'index'])->name('cotizacion.index');
route::delete('/cotizacion/delete', [CotCreditosController::class, 'destroy'])->name('cotizazcion.destroy');
route::put('/cotizacion/update', [CotCreditosController::class, 'update'])->name('cotizazcion.update');

Route::get('/envio-cotizacion/{id}', [CotCreditosController::class, 'mostrar'])->name('cotizacion.mostrar');
Route::get('/envio-cotizacion', [EnvioController::class, 'index'])->name('enviar.index');
Route::post('/envio-cotizacion', [EnvioController::class, 'enviar'])->name('cotizacion.enviar');

Route::get('/mis-propuestas', [MisPropuestasController::class,'index'])->name('propuestas.index');
Route::post('/mis-propuestas/copiar', [MisPropuestasController::class,'copiar'])->name('propuestas.copiar');

Route::put('configuracion/update', [HencorpPropuestasConfigController:: class, 'update'])->name('config.update');


Auth::routes(['register' => false]);