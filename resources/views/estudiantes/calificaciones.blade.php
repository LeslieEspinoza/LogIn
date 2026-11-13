@extends('layout.layout')

@section('titulo', 'Mis Calificaciones')

@section('contenido')
    <div class="container-fluid py-3">

        <!-- ENCABEZADO -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <span class="icon-box-pink p-3 rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(236, 72, 153, 0.1);">
                    <i class="bi bi-award fs-3 text-pink-accent"></i>
                </span>
                <div>
                    <h3 class="fw-bold text-white mb-0">Mis Calificaciones</h3>
                    <p class="text-secondary small mb-0">Seguimiento académico</p>
                </div>
            </div>
            <!-- Botón para descargar el PDF (Kárdex) -->
            <a href="{{ route('estudiante.kardex.pdf') }}" class="btn rounded-pill px-4 btn-sm d-flex align-items-center gap-2 fw-semibold shadow-sm" style="background-color: #ec4899; color: white; border: none;">
                <i class="bi bi-file-pdf"></i> Descargar Kárdex
            </a>
        </div>

        <div class="card bg-dark border-secondary border-opacity-25 rounded-4 shadow-sm">

            <!-- PESTAÑAS (NAVS) -->
            <div class="card-header border-secondary border-opacity-25 pt-3 pb-0 bg-transparent">
                <ul class="nav nav-tabs border-0" id="calificacionesTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active bg-transparent fw-bold border-0 border-bottom border-3" id="actual-tab" data-bs-toggle="tab" data-bs-target="#actual" type="button" role="tab" style="color: #ec4899; border-color: #ec4899 !important;">
                            Ciclo Actual
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-transparent text-secondary border-0" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial" type="button" role="tab">
                            Historial Académico
                        </button>
                    </li>
                </ul>
            </div>

            <!-- CONTENIDO DE LAS PESTAÑAS -->
            <div class="card-body p-0">
                <div class="tab-content" id="calificacionesTabsContent">

                    <!-- TAB 1: CICLO ACTUAL -->
                    <div class="tab-pane fade show active" id="actual" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0 align-middle">
                                <thead class="bg-body-secondary text-secondary small text-uppercase">
                                <tr>
                                    <th class="py-3 ps-4">Materia</th>
                                    <th class="py-3 text-center">Laboratorio (30%)</th>
                                    <th class="py-3 text-center">Parcial 1 (30%)</th>
                                    <th class="py-3 text-center">Parcial 2 (40%)</th>
                                    <th class="py-3 text-center">Nota Final</th>
                                    <th class="py-3 text-center pe-4">Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Estos son datos simulados hasta que conectemos la tabla de notas -->
                                <tr>
                                    <td class="ps-4 py-3">
                                        <strong class="d-block text-white">Desarrollo de Software II</strong>
                                        <small class="text-pink-subtle">INF-204</small>
                                    </td>
                                    <td class="text-center">8.5</td>
                                    <td class="text-center">9.0</td>
                                    <td class="text-center text-secondary">-</td>
                                    <td class="text-center fw-bold text-white">-</td>
                                    <td class="text-center pe-4"><span class="badge bg-info bg-opacity-25 text-info border border-info rounded-pill px-3">En curso</span></td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <strong class="d-block text-white">Bases de Datos Avanzadas</strong>
                                        <small class="text-pink-subtle">INF-205</small>
                                    </td>
                                    <td class="text-center">7.0</td>
                                    <td class="text-center">6.5</td>
                                    <td class="text-center text-secondary">-</td>
                                    <td class="text-center fw-bold text-white">-</td>
                                    <td class="text-center pe-4"><span class="badge bg-info bg-opacity-25 text-info border border-info rounded-pill px-3">En curso</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB 2: HISTORIAL -->
                    <div class="tab-pane fade" id="historial" role="tabpanel" tabindex="0">
                        <div class="p-5 text-center text-secondary">
                            <i class="bi bi-clock-history fs-1 d-block mb-3 text-secondary opacity-50"></i>
                            <h5 class="text-white">Historial de Ciclos Anteriores</h5>
                            <p>Aquí aparecerán las materias que ya has cursado y aprobado en años anteriores.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
