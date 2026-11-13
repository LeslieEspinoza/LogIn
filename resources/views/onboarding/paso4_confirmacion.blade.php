@extends('layout.onboarding')

@section('title', 'Fase 4: Inscripción Completada')

@php $paso_actual = 4; @endphp

@section('content')
    <div class="container text-center my-auto" style="max-width: 700px;">

        <div class="card bg-dark border border-secondary border-opacity-50 rounded-4 shadow-lg p-4 p-md-5">
            <div class="bg-success-subtle text-success rounded-circle p-4 mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 90px; height: 90px;">
                <i class="bi bi-check-circle-fill display-4"></i>
            </div>

            <h2 class="fw-bold text-white mb-2">¡Matrícula Completada con Éxito!</h2>
            <p class="text-secondary mb-4">
                Hemos procesado tu registro y asignación de asignaturas para el programa
                <strong class="text-pink">{{ $estudiante->carrera->nombre ?? 'seleccionado' }}</strong>.
            </p>

            <div class="card bg-body-tertiary border border-secondary border-opacity-25 text-start rounded-3 p-4 mb-4">
                <h6 class="fw-bold text-white border-bottom border-secondary border-opacity-25 pb-2 mb-3">
                    <i class="bi bi-person-badge me-2 text-pink"></i>Ficha de Confirmación
                </h6>
                <div class="row g-2 small text-secondary">
                    <div class="col-6">Estudiante: <strong class="text-white d-block">{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</strong></div>
                    <div class="col-6">Cédula / DNI: <strong class="text-white d-block">{{ $estudiante->documento_identidad }}</strong></div>
                    <div class="col-6 mt-2">Nivel: <strong class="text-white d-block text-capitalize">{{ $estudiante->nivel_academico }}</strong></div>
                    <div class="col-6 mt-2">Estatus Financiero: <span class="badge bg-success-subtle text-success">Verificado / En revisión</span></div>
                </div>
            </div>

            <div>
                <a href="{{ route('estudiante.dashboard') }}" class="btn btn-pink text-white fw-bold px-5 py-3 rounded-3 shadow-lg">
                    Ir a mi Dashboard Académico <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

    </div>
@endsection
