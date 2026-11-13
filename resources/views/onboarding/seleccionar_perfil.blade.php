@extends('layout.onboarding')

@section('title', 'Selecciona tu Nivel Académico')

@section('content')
    <div class="container" style="max-width: 850px;">

        <div class="text-center mb-5">
            <h2 class="fw-bold text-white mb-2">¡Bienvenido(a), {{ Auth::user()->name }}!</h2>
            <p class="text-secondary">Para personalizar tu proceso de inscripción, selecciona el tipo de formación que deseas realizar:</p>
        </div>

        <form method="POST" action="{{ route('onboarding.perfil.save') }}">
            @csrf

            <div class="row g-4 mb-5">

                <!-- Opción Pregrado -->
                <div class="col-12 col-md-4">
                    <label class="w-100 h-100 cursor-pointer selection-card-label">
                        <input type="radio" name="nivel_academico" value="pregrado" class="btn-check" required>
                        <div class="card bg-dark text-white border border-secondary border-opacity-50 rounded-4 p-4 text-center h-100 shadow-lg hover-card transition-all position-relative">
                            <!-- Indicador de check -->
                            <span class="badge bg-pink rounded-circle p-1 selected-badge">
                                <i class="bi bi-check-lg fs-6 text-white"></i>
                            </span>

                            <div class="bg-pink-subtle text-pink rounded-circle p-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-mortarboard fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2">Pregrado</h5>
                            <p class="text-secondary small mb-0">Licenciaturas e Ingenierías para graduados de educación secundaria.</p>
                        </div>
                    </label>
                </div>

                <!-- Opción Posgrado -->
                <div class="col-12 col-md-4">
                    <label class="w-100 h-100 cursor-pointer selection-card-label">
                        <input type="radio" name="nivel_academico" value="posgrado" class="btn-check">
                        <div class="card bg-dark text-white border border-secondary border-opacity-50 rounded-4 p-4 text-center h-100 shadow-lg hover-card transition-all position-relative">
                            <!-- Indicador de check -->
                            <span class="badge bg-pink rounded-circle p-1 selected-badge">
                                <i class="bi bi-check-lg fs-6 text-white"></i>
                            </span>

                            <div class="bg-pink-subtle text-pink rounded-circle p-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-award fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2">Posgrado</h5>
                            <p class="text-secondary small mb-0">Maestrías, Especializaciones y Doctorados para titulados universitarios.</p>
                        </div>
                    </label>
                </div>

                <!-- Opción Educación Continua -->
                <div class="col-12 col-md-4">
                    <label class="w-100 h-100 cursor-pointer selection-card-label">
                        <input type="radio" name="nivel_academico" value="educacion_continua" class="btn-check">
                        <div class="card bg-dark text-white border border-secondary border-opacity-50 rounded-4 p-4 text-center h-100 shadow-lg hover-card transition-all position-relative">
                            <!-- Indicador de check -->
                            <span class="badge bg-pink rounded-circle p-1 selected-badge">
                                <i class="bi bi-check-lg fs-6 text-white"></i>
                            </span>

                            <div class="bg-pink-subtle text-pink rounded-circle p-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-journal-bookmark-fill fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2">Educación Continua</h5>
                            <p class="text-secondary small mb-0">Diplomados, cursos cortos y certificaciones de actualización profesional.</p>
                        </div>
                    </label>
                </div>

            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-pink text-white fw-bold px-5 py-3 rounded-3 shadow-lg">
                    Continuar al Registro de Datos <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </div>

        </form>

    </div>

    <!-- Estilos CSS para el efecto de selección pura -->
    <style>
        .cursor-pointer {
            cursor: pointer;
        }

        /* Efecto al pasar el cursor (Hover) */
        .selection-card-label:hover .card {
            border-color: rgba(232, 62, 140, 0.6) !important;
            box-shadow: 0 0 15px rgba(232, 62, 140, 0.25) !important;
            transform: translateY(-4px);
        }

        /* Badge de check oculto por defecto */
        .selected-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.2s ease;
        }

        /* Estado Seleccionado usando :checked de los radio buttons */
        .btn-check:checked + .card {
            border-color: #d63384 !important;
            background-color: rgba(214, 51, 132, 0.08) !important;
            box-shadow: 0 0 25px rgba(214, 51, 132, 0.5), inset 0 0 10px rgba(214, 51, 132, 0.2) !important;
            transform: translateY(-2px);
        }

        /* Mostrar el badge al estar seleccionado */
        .btn-check:checked + .card .selected-badge {
            opacity: 1;
            transform: scale(1);
        }
    </style>
@endsection
