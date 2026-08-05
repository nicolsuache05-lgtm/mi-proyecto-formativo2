<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdminController;

// 1. Ruta de Inicio (Pública o redirección según Rol)
Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    if (Auth::guard('web')->check()) {
        return redirect()->route('cliente.dashboard');
    }
    return view('inicio');
})->name('home');

// 2. Rutas de Autenticación
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'procesarLogin'])->name('login.post');
Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'procesarRegistro'])->name('registro.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Rutas del Cliente (Protegidas por Middleware Cliente)
Route::middleware('auth.cliente')->group(function () {
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('cliente.dashboard');
    Route::get('/reservas/agendar', [UsuarioController::class, 'agendarCita'])->name('cliente.agendar');
    Route::post('/reservas/agendar', [UsuarioController::class, 'agendarCita'])->name('cliente.agendar.post');
    Route::get('/mis-reservas', [UsuarioController::class, 'misReservas'])->name('cliente.misReservas');
    Route::get('/cancelar-reserva/{id}', [UsuarioController::class, 'cancelarReserva'])->name('cliente.cancelarReserva');
    Route::get('/catalogo', [UsuarioController::class, 'catalogo'])->name('cliente.catalogo');
});

// 4. Rutas del Administrador (Protegidas por Middleware Administrador)
Route::middleware('auth.admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/clientes', [AdminController::class, 'listarClientes'])->name('admin.clientes');
    Route::post('/admin/clientes/toggle/{id}', [AdminController::class, 'toggleCliente'])->name('admin.clientes.toggle');
    Route::get('/admin/reservas', [AdminController::class, 'listarReservas'])->name('admin.reservas');
    Route::post('/admin/reservas/actualizar', [AdminController::class, 'actualizarReserva'])->name('admin.reservas.actualizar');
    Route::get('/admin/servicios', [AdminController::class, 'listarServicios'])->name('admin.servicios');
    Route::post('/admin/servicios/guardar', [AdminController::class, 'guardarServicio'])->name('admin.servicios.guardar');
    Route::post('/admin/servicios/actualizar', [AdminController::class, 'actualizarServicio'])->name('admin.servicios.actualizar');
    Route::post('/admin/servicios/eliminar', [AdminController::class, 'eliminarServicio'])->name('admin.servicios.eliminar');
    Route::get('/admin/pagos', [AdminController::class, 'verPagos'])->name('admin.pagos');
});
