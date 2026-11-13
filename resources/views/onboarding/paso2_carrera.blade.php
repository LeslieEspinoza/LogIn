@extends('layout.onboarding')

@section('title', 'Fase 2: Carrera y Horario')

@php $paso_actual = 2; @endphp

@section('content')
    <div class="container" style="max-width: 1000px;">
        <div class="card bg-dark border border-secondary border-opacity-50 rounded-4 shadow-lg overflow-hidden">
            <div class="card-body p-4 p-md-5">

                <!-- ENCABEZADO -->
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom border-secondary border-opacity-25 pb-3">
                    <div>
                    <span class="badge bg-danger bg-opacity-25 text-pink-subtle px-3 py-2 rounded-pill fw-bold mb-1">
                        Fase 2 de 4
                    </span>
                        <h4 class="fw-bold text-white mb-0 mt-1">Selección de Carrera y Secciones</h4>
                    </div>
                    <div class="text-secondary small text-end">
                        Nivel: <strong class="text-white text-capitalize">{{ $estudiante->nivel_academico }}</strong>
                    </div>
                </div>

                <form action="{{ route('onboarding.paso2.guardar') }}" method="POST">
                    @csrf

                    <!-- 1. SELECCIÓN DE CARRERA -->
                    <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
                        <span class="text-pink-accent">1.</span> Selecciona tu Carrera
                    </h5>

                    <div class="grid-carreras mb-5">
                        @foreach ($carreras as $carrera)
                            <div
                                onclick="seleccionarCarrera({{ $carrera->id }})"
                                id="carrera-card-{{ $carrera->id }}"
                                class="carrera-card-premium">

                                <input
                                    type="radio"
                                    name="carrera_id"
                                    value="{{ $carrera->id }}"
                                    id="carrera-radio-{{ $carrera->id }}"
                                    class="radio-oculto"
                                    {{ (old('carrera_id', $estudiante->carrera_id) ==$carrera->id) ? 'checked' : '' }}
                                    required>

                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="badge-codigo">{{ $carrera->codigo }}</span>
                                        <h5 class="fw-bold text-white mt-3 mb-1">{{ $carrera->nombre }}</h5>
                                        <p class="text-secondary small mb-0">{{ $carrera->facultad }}</p>
                                    </div>
                                    <div id="check-icon-{{ $carrera->id }}" class="check-badge">
                                        ✓
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <!-- BOTÓN CONTINUAR -->
                    <div class="mt-5 text-end">
                        <button type="submit" class="btn btn-pink-gradient">
                            Continuar a Fase 3 →
                        </button>
                    </div>
                </form>

                <!-- SCRIPT DE FILTRADO Y SELECCIÓN EN TIEMPO REAL -->
                <script>
                    function seleccionarCarrera(carreraId) {
                        // 1. Limpiar estado de todas las tarjetas
                        document.querySelectorAll('.carrera-card-premium').forEach(card => {
                            card.classList.remove('selected');
                        });

                        document.querySelectorAll('.check-badge').forEach(check => {
                            check.style.display = 'none';
                        });

                        // 2. Activar la tarjeta seleccionada
                        const card = document.getElementById(`carrera-card-${carreraId}`);
                        const radio = document.getElementById(`carrera-radio-${carreraId}`);
                        const check = document.getElementById(`check-icon-${carreraId}`);

                        if (card && radio) {
                            radio.checked = true;
                            card.classList.add('selected');
                            if (check) check.style.display = 'flex';
                        }

                        // contenedor de horarios
                        const contenedor = document.getElementById('contenedor-horarios');
                        if (contenedor) {
                            contenedor.style.display = 'block';
                        }

                        //  secciones visibles según la carrera elegida
                        const secciones = document.querySelectorAll('.seccion-item');
                        let encontradas = 0;

                        secciones.forEach(seccion => {
                            if (seccion.getAttribute('data-carrera-id') == carreraId) {
                                seccion.style.display = 'flex';
                                encontradas++;
                            } else {
                                seccion.style.display = 'none';
                            }
                        });

                        // Mostrar mensaje si no hay secciones
                        const sinSeccionesMsg = document.getElementById('sin-secciones-msg');
                        if (sinSeccionesMsg) {
                            sinSeccionesMsg.style.display = (encontradas === 0) ? 'block' : 'none';
                        }
                    }

                    // Autoseleccionar si ya existe una carrera seleccionada previamente
                    document.addEventListener('DOMContentLoaded', function () {
                        const carreraElegida = document.querySelector('input[name="carrera_id"]:checked');
                        if (carreraElegida) {
                            seleccionarCarrera(carreraElegida.value);
                        }
                    });
                </script>

            </div>
        </div>
    </div>
@endsection
