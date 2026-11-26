<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AdminEstudianteController;
use App\Http\Controllers\AdminProfesorController;
 use App\Http\Controllers\MateriaController;
// use App\Http\Controllers\CarreraController;
use App\Http\Controllers\InscripcionController;

use App\Http\Middleware\CheckStudentOnboarding;

// 1. RUTAS PÚBLICAS
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');

Route::get('/registro', function () {
    return redirect()->route('register.select');
});
Route::get('/registro/seleccion', [RegisterController::class, 'showRoleSelection'])->name('register.select');
Route::get('/registro/{tipo}', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/registro', [RegisterController::class, 'register'])->name('register.store');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// 2. RUTAS DE ONBOARDING (SOLO AUTH)
Route::middleware(['auth'])->group(function () {
    Route::get('/onboarding/perfil', [OnboardingController::class, 'showPerfilSelection'])->name('onboarding.perfil');
    Route::post('/onboarding/perfil', [OnboardingController::class, 'savePerfilSelection'])->name('onboarding.perfil.save');

    Route::get('/onboarding/paso/{paso}', [OnboardingController::class, 'showStep'])->name('onboarding.paso');
    Route::post('/onboarding/paso1', [OnboardingController::class, 'guardarPaso1'])->name('onboarding.paso1.guardar');
    Route::post('/onboarding/paso2', [OnboardingController::class, 'guardarPaso2'])->name('onboarding.paso2.guardar');
    Route::post('/onboarding/paso3', [OnboardingController::class, 'guardarPaso3'])->name('onboarding.paso3.guardar');
});

// 3. RUTAS PROTEGIDAS GENERALES
Route::middleware(['auth', CheckStudentOnboarding::class])->group(function () {

    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    Route::get('/inscripcion', function () {
        return view('usuario.inscripcion');
    })->name('inscripcion');

    // EXCLUSIVAS ADMIN (rol_id = 1)
    Route::middleware(['rol:1'])->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
        Route::post('/usuarios', [UsuarioController::class, 'insertarUsuario'])->name('usuarios.insertar');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'actualizarUsuario'])->name('usuarios.actualizar');
        Route::put('/usuarios/{user}/estado', [UsuarioController::class, 'alternarEstado'])->name('usuarios.estado');

            // Panel Estudiantes
        Route::prefix('admin/estudiantes')->name('admin.estudiantes.')->group(function () {
            Route::get('/', [AdminEstudianteController::class, 'index'])->name('index');
            Route::put('/{estudiante}/aprobar', [AdminEstudianteController::class, 'aprobarExpediente'])->name('aprobar');
            Route::get('/{estudiante}/kardex', [AdminEstudianteController::class, 'kardex'])->name('kardex');
            Route::post('/{estudiante}/reset-password', [AdminEstudianteController::class, 'resetPassword'])->name('reset_password');
        });

        //Panel Profesores
        Route::prefix('admin/profesores')->name('admin.profesores.')->group(function () {
            Route::get('/', [AdminProfesorController::class, 'index'])->name('index');
            Route::post('/', [AdminProfesorController::class, 'store'])->name('store');
            Route::put('/{profesor}', [AdminProfesorController::class, 'update'])->name('update');
            Route::post('/{profesor}/crear-cuenta', [AdminProfesorController::class, 'crearCuenta'])->name('crear_cuenta');
            Route::post('/{profesor}/reset-password', [AdminProfesorController::class, 'resetPassword'])->name('reset_password');
            Route::put('/{profesor}/toggle-estado', [AdminProfesorController::class, 'toggleEstado'])->name('toggle_estado');
        });
        //Panel Materias

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('materias', MateriaController::class);
        });

    });

    // ADMIN Y DOCENTES (rol_id = 1, 2)
    Route::middleware(['rol:1,2'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::post('/reportes/expediente/{id}/correo', [ReporteController::class, 'enviarCorreo'])->name('reportes.expediente.correo');
        Route::get('/reportes/expediente/{id}/pdf', [ReporteController::class, 'exportarPdf'])->name('reportes.expediente.pdf');
        Route::post('/reportes/expediente/{id}/pdf-correo', [ReporteController::class, 'enviarCorreoPdf'])->name('reportes.expediente.pdf.correo');
        Route::get('/reportes/expediente/{id}/excel', [ReporteController::class, 'exportarExcel'])->name('reportes.expediente.excel');
        Route::post('/reportes/expediente/{id}/excel-correo', [ReporteController::class, 'enviarCorreoExcel'])->name('reportes.expediente.excel.correo');


        // Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
        // Route::get('/materias', [MateriaController::class, 'index'])->name('materias.index');
    });


    // ESTUDIANTES (rol_id = 3)

    Route::middleware(['rol:3'])->group(function () {

        Route::get('/mi-panel', [App\Http\Controllers\EstudianteController::class, 'dashboard'])->name('estudiante.dashboard');
        Route::get('/mis-inscripciones', [App\Http\Controllers\InscripcionController::class, 'misInscripciones'])->name('estudiante.inscripciones');
        Route::get('/mi-horario', [App\Http\Controllers\EstudianteController::class, 'horario'])->name('estudiante.horario');
        Route::get('/mis-calificaciones', [App\Http\Controllers\EstudianteController::class, 'calificaciones'])->name('estudiante.calificaciones');
        Route::get('/mi-kardex/pdf', [App\Http\Controllers\EstudianteController::class, 'descargarKardex'])->name('estudiante.kardex.pdf');
        Route::get('/mi-perfil', [App\Http\Controllers\EstudianteController::class, 'perfil'])->name('estudiante.perfil');
        Route::put('/mi-perfil/actualizar', [App\Http\Controllers\EstudianteController::class, 'actualizarPerfil'])->name('estudiante.perfil.actualizar');
        Route::get('/mis-tramites', [App\Http\Controllers\EstudianteController::class, 'tramites'])->name('estudiante.tramites');
    });
});
