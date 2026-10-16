<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InicioSesionController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\pacientesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\api\ApiSupplierController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('productos/search', [ProductosController::class, 'search']);
Route::resource('productos', ProductosController::class);

Route::get('/login', function(){
    return view('AuthViews.InicioSesion');/// vista llamada pacientes 
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/profile', [ProfileController::class, 'mostrarDatos']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::get('/password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.request');

Route::get('/datos/auth', [AuthController::class, 'mostrarDatos']);
Route::get('/datos/todas-las-tablas', [HomeController::class, 'mostrarDatos']);
Route::get('/datos/images', [ImageController::class, 'mostrarDatos']);
Route::get('/datos/inicio-sesion', [InicioSesionController::class, 'mostrarDatos']);
Route::get('/datos/movimientos', [MovimientoController::class, 'mostrarDatos']);
Route::get('/datos/podcast', [PodcastController::class, 'mostrarDatos']);
Route::get('/datos/pacientes', [pacientesController::class, 'mostrarDatos']);
Route::get('/datos/productos', [ProductosController::class, 'mostrarDatos']);
Route::get('/datos/perfil', [ProfileController::class, 'mostrarDatos']);
Route::post('/datos/perfil/usuarios', [ProfileController::class, 'store'])->name('usuarios.store');
Route::put('/datos/perfil/usuarios/{id}', [ProfileController::class, 'update'])->name('usuarios.update');
Route::delete('/datos/perfil/usuarios/{id}', [ProfileController::class, 'destroy'])->name('usuarios.destroy');
Route::get('/datos/registro', [RegisterController::class, 'mostrarDatos']);
Route::get('/datos/restablecer-contrasenia', [ResetPasswordController::class, 'mostrarDatos']);
Route::get('/datos/ventas', [VentasController::class, 'mostrarDatos']);
Route::get('/datos/api-usuarios', [ApiSupplierController::class, 'mostrarDatos']);
