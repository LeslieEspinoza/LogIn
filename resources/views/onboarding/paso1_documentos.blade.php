@extends('layout.onboarding')

@section('title', 'Fase 1: Datos y Documentos')

@php $paso_actual = 1; @endphp

@section('content')
    <div class="container" style="max-width: 800px;">

        <div class="card bg-dark border border-secondary border-opacity-50 rounded-4 shadow-lg overflow-hidden">
            <div class="card-body p-4 p-md-5">

                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom border-secondary border-opacity-25 pb-3">
                    <div>
                        <span class="badge bg-pink-subtle text-pink px-3 py-2 rounded-pill fw-bold mb-1">Fase 1 de 4</span>
                        <h4 class="fw-bold text-white mb-0">Información Personal y Requisitos</h4>
                    </div>
                    <div class="text-secondary small text-end">
                        Nivel: <strong class="text-white text-capitalize">{{ $estudiante->nivel_academico ?? 'General' }}</strong>
                    </div>
                </div>

                <form method="POST" action="{{ route('onboarding.paso1.guardar') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Datos de Identificación -->
                    <h6 class="text-pink fw-bold mb-3"><i class="bi bi-person-vcard me-2"></i>Datos del Estudiante</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-secondary">Nombre Completo</label>
                            <input type="text" name="nombres" value="{{ old('nombres', $estudiante->nombres ?? '') }}"
                                   class="form-control bg-body-tertiary text-white border-secondary border-opacity-50" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label small text-secondary">Documento de Identidad / Cédula / DNI</label>
                            <input type="text" name="documento_identidad" value="{{ old('documento_identidad', $estudiante->documento_identidad ?? '') }}"
                                   class="form-control bg-body-tertiary text-white border-secondary border-opacity-50" placeholder="Ej. 12345678-9" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-secondary">Correo Personal / Contacto</label>
                            <input type="email" name="correo_institucional" value="{{ old('correo_institucional', Auth::user()->email) }}"
                                   class="form-control bg-body-tertiary text-white border-secondary border-opacity-50" required readonly>
                        </div>
                    </div>

                    <hr class="border-secondary border-opacity-25 my-4">

                    <!-- Requisitos Digitales -->
                    <h6 class="text-pink fw-bold mb-3"><i class="bi bi-cloud-arrow-up me-2"></i>Documentos Digitales Requeridos</h6>

                    <div class="mb-3">
                        <label class="form-label small text-secondary">Documento de Identidad (PDF o Imagen)</label>
                        <input type="file" name="doc_identidad_file" class="form-control bg-body-tertiary text-white border-secondary border-opacity-50" accept=".pdf,.jpg,.jpeg,.png">
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-secondary">
                            @if(($estudiante->nivel_academico ?? '') === 'posgrado')
                                Título Universitario o Acta de Grado (PDF)
                            @else
                                Título de Bachillerato / Secundaria (PDF)
                            @endif
                        </label>
                        <input type="file" name="doc_titulo_file" class="form-control bg-body-tertiary text-white border-secondary border-opacity-50" accept=".pdf,.jpg,.jpeg,.png">
                    </div>

                    <!-- Botón para avanzar -->
                    <div class="d-flex justify-content-end pt-3 border-top border-secondary border-opacity-25">
                        <button type="submit" class="btn btn-pink text-white fw-semibold px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
                            Guardar y Continuar <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
