<?php

use App\Http\Controllers\EdificioController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\TipoHabitacionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\HorarioPersonalController;
use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use App\Http\Controllers\Auth\FirebaseAuthController; // Importa el controlador FirebaseAuthController

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

Route::get('/', [MapaController::class, 'index'])->name('mapa.index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['permission:ver-rol|crear-rol|editar-rol|borrar-rol']], function () {
        Route::resource('roles', RolController::class);
    });
    Route::group(['middleware' => ['permission:ver-usuario|crear-usuario|editar-usuario|borrar-usuario']], function () {
        Route::resource('usuarios', UsuarioController::class);
    });
    Route::group(['middleware' => ['permission:ver-edificio|crear-edificio|editar-edificio|borrar-edificio']], function () {
        Route::resource('edificios', EdificioController::class);
    });
    Route::group(['middleware' => ['permission:ver-habitaciones|crear-habitaciones|editar-habitaciones|borrar-habitaciones']], function () {
        Route::resource('habitaciones', HabitacionController::class)->parameters(['habitaciones' => 'habitacion']);
    });
    Route::group(['middleware' => ['permission:ver-tipo_habitaciones|crear-tipo_habitaciones|editar-tipo_habitaciones|borrar-tipo_habitaciones']], function () {
        Route::resource('tipos-habitaciones', TipoHabitacionController::class)->parameters(['tipos-habitaciones' => 'tipo_habitacion']);
    });
    Route::group(['middleware' => ['permission:ver-personal|crear-personal|editar-personal|borrar-personal']], function () {
        Route::resource('personal', PersonalController::class);
    });
    Route::group(['middleware' => ['permission:ver-horarios|crear-horarios|editar-horarios|borrar-horarios']], function () {
        Route::resource('horarios_personal', HorarioPersonalController::class)->parameters(['horarios_personal' => 'horario']);
    });
    Route::group(['middleware' => ['permission:ver-eventos|crear-eventos|editar-eventos|borrar-eventos']], function () {
        Route::resource('eventos', EventoController::class);
    });
});

Route::post('/firebase-login', [FirebaseAuthController::class, 'login']);
