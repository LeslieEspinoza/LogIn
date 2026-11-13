@extends('layout.layout')

@section('titulo', 'Mi Panel Estudiantil')

@section('contenido')
    <div class="container-fluid py-3">

        <!-- ENCABEZADO -->
        <div class="d-flex align-items-center gap-2 mb-4">
            <span class="icon-box-pink">
                <i class="bi bi-person-badge fs-4"></i>
            </span>
            <div>
                <h3 class="fw-bold text-white mb-0">Hola, {{ auth()->user()->name }}</h3>
                <p class="text-secondary small mb-0">Bienvenido a tu portal académico</p>
            </div>
        </div>

        <!-- TARJETAS DE RESUMEN (KPIs) -->
        <div class="row g-4 mb-4">

            <!-- Materias Inscritas -->
            <div class="col-12 col-md-4">
                <div class="p-4 rounded-4 h-100" style="background: #111827; border: 1px solid rgba(255, 255, 255, 0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-secondary mb-0">Materias Inscritas</h6>
                        <i class="bi bi-journal-bookmark text-pink-accent fs-4"></i>
                    </div>
                    <h2 class="fw-bold text-white mb-0">{{ $materiasInscritas ?? 0 }}</h2>
                    <small class="text-secondary">Ciclo Actual</small>
                </div>
            </div>

            <!-- Promedio Global (CUM) - Estático por ahora -->
            <div class="col-12 col-md-4">
                <div class="p-4 rounded-4 h-100" style="background: #111827; border: 1px solid rgba(255, 255, 255, 0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-secondary mb-0">Promedio Global (CUM)</h6>
                        <i class="bi bi-star-fill text-warning fs-4"></i>
                    </div>
                    <h2 class="fw-bold text-white mb-0">8.5</h2>
                    <small class="text-success"><i class="bi bi-arrow-up-short"></i> Rendimiento estable</small>
                </div>
            </div>

            <!-- Progreso de Carrera - Estático por ahora -->
            <div class="col-12 col-md-4">
                <div class="p-4 rounded-4 h-100" style="background: #111827; border: 1px solid rgba(255, 255, 255, 0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-secondary mb-0">Avance de Carrera</h6>
                        <i class="bi bi-trophy text-info fs-4"></i>
                    </div>
                    <div class="d-flex align-items-end gap-2 mb-2">
                        <h2 class="fw-bold text-white mb-0">45</h2><span class="text-secondary pb-1">%</span>
                    </div>
                    <div class="progress bg-dark" style="height: 8px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN INFERIOR -->
        <div class="row g-4">

            <!-- Clases de Hoy -->
            <div class="col-12 col-lg-8">
                <div class="p-4 rounded-4 h-100" style="background: #111827; border: 1px solid rgba(255, 255, 255, 0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-white mb-0"><i class="bi bi-calendar-event text-pink-accent me-2"></i>Mis Clases de Hoy</h5>
                        <a href="{{ route('estudiante.horario') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Ver Horario Completo</a>
                    </div>

                    <div class="alert bg-dark text-secondary border-secondary border-opacity-25 d-flex align-items-center gap-3">
                        <i class="bi bi-info-circle-fill text-pink-subtle fs-4"></i>
                        <div>
                            <strong class="text-white d-block">Configuración pendiente</strong>
                            Próximamente cruzaremos tus materias inscritas con el día de la semana para mostrar tu agenda diaria aquí.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acceso Rápido a Trámites -->
            <div class="col-12 col-lg-4">
                <div class="p-4 rounded-4 h-100 border-0 text-white shadow-sm d-flex flex-column justify-content-center align-items-center text-center" style="background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);">
                    <i class="bi bi-file-earmark-text fs-1 mb-3 text-white"></i>
                    <h5 class="fw-bold">Gestión de Trámites</h5>
                    <p class="small text-white-50 mb-4 px-2">Solicita constancias de estudio, revisión de notas o justificaciones médicas rápidamente.</p>
                    <a href="{{ route('estudiante.tramites') }}" class="btn btn-light rounded-pill px-4 fw-bold" style="color: #be185d;">Iniciar Solicitud</a>
                </div>
            </div>

        </div>
    </div>
@endsection
