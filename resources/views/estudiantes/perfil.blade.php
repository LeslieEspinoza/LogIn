@extends('layout.layout')

@section('titulo', 'Mi Perfil')

@section('contenido')
    <div class="container-fluid py-3">

        <!-- ENCABEZADO -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <span class="icon-box-pink p-3 rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(236, 72, 153, 0.1);">
                <i class="bi bi-person-gear fs-3 text-pink-accent"></i>
            </span>
            <div>
                <h3 class="fw-bold text-white mb-0">Configuración de Perfil</h3>
                <p class="text-secondary small mb-0">Administra tus credenciales y datos personales</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Datos Informativos (Solo lectura) -->
            <div class="col-12 col-md-5">
                <div class="card bg-dark border-secondary border-opacity-25 rounded-4 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="d-inline-block mb-3 p-1 rounded-circle border border-2" style="border-color: #ec4899 !important;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: rgba(255,255,255,0.1);">
                                <i class="bi bi-person-fill text-white opacity-50" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h4 class="text-white fw-bold mb-1">{{ $usuario->name }}</h4>
                        <p class="text-pink-subtle mb-3">Estudiante Activo</p>

                        <div class="text-start mt-4">
                            <div class="mb-2">
                                <small class="text-secondary d-block">Carnet Institucional</small>
                                <strong class="text-white">{{ $usuario->estudiante->carnet ?? 'No asignado' }}</strong>
                            </div>
                            <div class="mb-2">
                                <small class="text-secondary d-block">Carrera</small>
                                <strong class="text-white">{{ $usuario->estudiante->carrera->nombre ?? 'No asignada' }}</strong>
                            </div>
                            <div class="mb-0">
                                <small class="text-secondary d-block">Fecha de Ingreso</small>
                                <strong class="text-white">{{ $usuario->created_at->format('d/m/Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Actualización -->
            <div class="col-12 col-md-7">
                <div class="card bg-dark border-secondary border-opacity-25 rounded-4 shadow-sm h-100">
                    <div class="card-header border-secondary border-opacity-25 bg-transparent pt-3 pb-2">
                        <h6 class="text-white fw-bold mb-0">Actualizar Credenciales</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('estudiante.perfil.actualizar') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label text-secondary small">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary border-opacity-50" value="{{ $usuario->email }}">
                                </div>
                            </div>

                            <hr class="border-secondary my-4">

                            <h6 class="text-white fw-bold mb-3">Cambiar Contraseña</h6>
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Nueva Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary border-opacity-50" placeholder="Deja en blanco para no cambiar">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-secondary small">Confirmar Nueva Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control bg-dark text-white border-secondary border-opacity-50" placeholder="Repite la contraseña">
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn px-4 fw-bold rounded-pill" style="background-color: #ec4899; color: white;">
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
