<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\SuscripcionController;
use App\Http\Controllers\Api\EncuentrosController;
use App\Http\Controllers\Api\InscripcionController;
use App\Http\Controllers\Api\EquipoController;
use App\Http\Controllers\Api\ResultadoController;
use App\Http\Controllers\Api\ProgramacionJuezController;
use App\Http\Controllers\Api\JugadorController;
use App\Http\Controllers\Api\ReciboDePagoController;
use App\Http\Controllers\Api\AmonestacionController;
use App\Http\Controllers\Api\AuthController;
use LDAP\Result;

// rutas de usuarios

Route::get('/usuarios',[UsuarioController::class, 'index']);

Route::get('/usuarios/{id}',[UsuarioController::class, 'show']);

Route::post('/usuarios',[UsuarioController::class, 'store']);

Route::put('/usuarios/{id}',[UsuarioController::class, 'update']);

Route::delete('/usuarios/{id}',[UsuarioController::class, 'destroy']);

Route::patch('/usuarios/{id}',[UsuarioController::class, 'updatePartial']);

// ruta de suscripcion )

Route::get('/suscripcion',[SuscripcionController::class, 'index']);

Route::get('/suscripcion/{id}',[SuscripcionController::class, 'show']);

Route::post('/suscripcion',[SuscripcionController::class, 'store']);

Route::put('/suscripcion/{id}',[SuscripcionController::class, 'update']);

Route::delete('/suscripcion/{id}',[SuscripcionController::class, 'destroy']);

Route::patch('/suscripcion/{id}',[SuscripcionController::class, 'updatePartial']);

// rutas de encuentros

Route::get('/encuentros',[EncuentrosController::class, 'index']);

Route::get('/encuentros/{id}',[EncuentrosController::class, 'show']);

Route::post('/encuentros',[EncuentrosController::class, 'store']);

Route::put('/encuentros/{id}',[EncuentrosController::class, 'update']);

Route::delete('/encuentros/{id}',[EncuentrosController::class, 'destroy']);

Route::patch('/encuentros/{id}',[EncuentrosController::class, 'updatePartial']);

// ruta de inscripcion )

Route::get('/inscripcion',[InscripcionController::class, 'index']);

Route::get('/inscripcion/{id}',[InscripcionController::class, 'show']);

Route::post('/inscripcion',[InscripcionController::class, 'store']);

Route::put('/inscripcion/{id}',[InscripcionController::class, 'update']);

Route::delete('/inscripcion/{id}',[InscripcionController::class, 'destroy']);

Route::patch('/inscripcion/{id}',[InscripcionController::class, 'updatePartial']);

// ruta de equipos

Route::get('/equipos',[EquipoController::class, 'index']);

Route::get('/equipos/{id}',[EquipoController::class, 'show']);

Route::post('/equipos',[EquipoController::class, 'store']);

Route::put('/equipos/{id}',[EquipoController::class, 'update']);

Route::delete('/equipos/{id}',[EquipoController::class, 'destroy']);

Route::patch('/equipos/{id}',[EquipoController::class, 'updatePartial']);

//ruta de resultados

Route::get('/resultados',[ResultadoController::class, 'index']);

Route::get('/resultados/{id}',[ResultadoController::class, 'show']);

Route::post('/resultados',[ResultadoController::class, 'store']);

Route::put('/resultados/{id}',[ResultadoController::class, 'update']);

Route::delete('/resultados/{id}',[ResultadoController::class, 'destroy']);

Route::patch('/resultados/{id}',[ResultadoController::class, 'updatePartial']); 

// ruta juez

Route::get('/jueces', [ProgramacionJuezController::class, 'index']);

Route::get('/jueces/{id}', [ProgramacionJuezController::class, 'show']);

Route::post('/jueces', [ProgramacionJuezController::class, 'store']);

Route::put('/jueces/{id}', [ProgramacionJuezController::class, 'update']);

Route::delete('/jueces/{id}', [ProgramacionJuezController::class, 'destroy']);

Route::patch('/jueces/{id}', [ProgramacionJuezController::class, 'updatePartial']);

// ruta jugador

Route::get('/jugadores',[JugadorController::class, 'index']);

Route::get('/jugadores/{id}',[JugadorController::class, 'show']);

Route::post('/jugadores',[JugadorController::class, 'store']);

Route::put('/jugadores/{id}',[JugadorController::class, 'update']);

Route::delete('/jugadores/{id}',[JugadorController::class, 'destroy']);

Route::patch('/jugadores/{id}',[JugadorController::class, 'updatePartial']);

//ruta de recibo de pago

Route::get('/recibo_de_pago',[ReciboDePagoController::class, 'index']);

Route::get('/recibo_de_pago/{id}',[ReciboDePagoController::class, 'show']); 

Route::post('/recibo_de_pago',[ReciboDePagoController::class, 'store']);

Route::put('/recibo_de_pago/{id}',[ReciboDePagoController::class, 'update']);

Route::delete('/recibo_de_pago/{id}',[ReciboDePagoController::class, 'destroy']);

Route::patch('/recibo_de_pago/{id}',[ReciboDePagoController::class, 'updatePartial']);

//ruta amonestacion

Route::get('/amonestaciones',[AmonestacionController::class, 'index']);

Route::get('/amonestaciones/{id}',[AmonestacionController::class, 'show']);

Route::post('/amonestaciones',[AmonestacionController::class, 'store']);

Route::put('/amonestaciones/{id}',[AmonestacionController::class, 'update']);

Route::delete('/amonestaciones/{id}',[AmonestacionController::class, 'destroy']);

Route::patch('/amonestaciones/{id}',[AmonestacionController::class, 'updatePartial']);

// rutas de autenticación con JWT

Route::group(['prefix' => 'auth'], function () {
    
    Route::post('/register', [AuthController::class, 'register']);    // Registrar usuario

    Route::post('/login', [AuthController::class, 'login']);          // Iniciar sesión

    Route::post('/logout', [AuthController::class, 'logout']);        // Cerrar sesión

    Route::post('/refresh', [AuthController::class, 'refresh']);      // Renovar token

    Route::get('/me', [AuthController::class, 'me']);                 // Datos del usuario logueado
});









