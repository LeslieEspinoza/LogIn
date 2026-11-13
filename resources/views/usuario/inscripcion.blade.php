@extends('layout.layout')

@section('titulo', 'Inscripción de Materias')

@section('contenido')
    <div class="container-fluid py-2">

        <!-- Encabezado de la página -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1">Inscripción de Materias</h3>
                <p class="text-body-secondary mb-0">Selecciona las asignaturas ofertadas para el periodo lectivo activo</p>
            </div>
            <button type="button" class="btn btn-pink text-white px-4 fw-semibold shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalConfirmarInscripcion">
                <i class="bi bi-check-circle-fill fs-6"></i> Finalizar Inscripción
            </button>
        </div>

        <!-- Información del Estudiante & Resumen de Unidades Valorativas -->
        <div class="row g-3 mb-4">

            <!-- Card Información Estudiante -->
            <div class="col-12 col-lg-8">
                <div class="card border border-secondary border-opacity-25 bg-dark text-white rounded-4 shadow-sm h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-pink-subtle text-pink rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                                <i class="bi bi-person-badge fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-white mb-0">{{ Auth::user()->name ?? 'Usuario' }}</h5>
                                <span class="text-secondary small">Carnet: 2024-00129 | Carrera: Ingeniería en Sistemas</span>
                            </div>
                        </div>
                        <div class="row g-2 pt-2 border-top border-secondary border-opacity-25 text-center text-md-start">
                            <div class="col-6 col-md-3">
                                <small class="text-secondary d-block">Ciclo Lectivo</small>
                                <span class="fw-semibold text-white">2026-II</span>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-secondary d-block">CUM Acumulado</small>
                                <span class="fw-semibold text-pink">8.45</span>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-secondary d-block">UV Máximas</small>
                                <span class="fw-semibold text-white">24 UV</span>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-secondary d-block">Estado Financiero</small>
                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-2 py-1">Solvente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Avance de Unidades Valorativas (UV) -->
            <div class="col-12 col-lg-4">
                <div class="card border border-secondary border-opacity-25 bg-dark text-white rounded-4 shadow-sm h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="text-uppercase fw-bold text-secondary mb-0 small">Avance de Selección</h6>
                                <span class="badge bg-pink-subtle text-pink fw-bold">3 Materias</span>
                            </div>
                            <div class="d-flex align-items-baseline gap-2 mb-2">
                                <h2 class="display-6 fw-bold mb-0 text-white">12</h2>
                                <span class="text-secondary">/ 24 UV Seleccionadas</span>
                            </div>
                            <!-- Barra de progreso -->
                            <div class="progress bg-secondary bg-opacity-25" style="height: 8px;">
                                <div class="progress-bar bg-pink" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <small class="text-secondary mt-3 d-block">
                            <i class="bi bi-info-circle text-pink me-1"></i> Puedes inscribir hasta 12 UV adicionales.
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tabla de Oferta de Asignaturas -->
        <div class="card border-0 shadow-sm bg-body">
            <div class="card-header bg-transparent border-bottom py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h5 class="fw-bold mb-0">Oferta Académica Disponible</h5>

                <!-- Buscador rápido -->
                <div class="d-flex gap-2" style="max-width: 380px; width: 100%;">
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-secondary-subtle text-secondary">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar por código o asignatura...">
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th class="ps-4">Código</th>
                            <th>Asignatura</th>
                            <th>UV</th>
                            <th>Sección / Horario</th>
                            <th>Docente</th>
                            <th>Cupos</th>
                            <th class="text-end pe-4">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Materia Seleccionada 1 -->
                        <tr>
                            <td class="ps-4 fw-bold text-pink">PRG301</td>
                            <td>
                                <div class="fw-semibold text-body">Programación Orientada a Objetos</div>
                                <small class="text-body-secondary">Prerrequisito: Programación I</small>
                            </td>
                            <td><span class="badge bg-body-tertiary text-body border">4 UV</span></td>
                            <td>
                                <span class="d-block fw-semibold">Sec. 01</span>
                                <small class="text-body-secondary">Lun - Mié 08:00 - 10:00 AM</small>
                            </td>
                            <td class="text-body-secondary">Ing. Mario Castillo</td>
                            <td><span class="badge bg-success-subtle text-success-emphasis">15 / 30</span></td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-outline-danger px-3 rounded-pill">
                                    <i class="bi bi-dash-circle me-1"></i> Quitar
                                </button>
                            </td>
                        </tr>

                        <!-- Materia Seleccionada 2 -->
                        <tr>
                            <td class="ps-4 fw-bold text-pink">BDD201</td>
                            <td>
                                <div class="fw-semibold text-body">Bases de Datos I</div>
                                <small class="text-body-secondary">Prerrequisito: Estructura de Datos</small>
                            </td>
                            <td><span class="badge bg-body-tertiary text-body border">4 UV</span></td>
                            <td>
                                <span class="d-block fw-semibold">Sec. 02</span>
                                <small class="text-body-secondary">Mar - Jue 10:00 - 12:00 PM</small>
                            </td>
                            <td class="text-body-secondary">Licda. Sofia Ramos</td>
                            <td><span class="badge bg-success-subtle text-success-emphasis">8 / 25</span></td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-outline-danger px-3 rounded-pill">
                                    <i class="bi bi-dash-circle me-1"></i> Quitar
                                </button>
                            </td>
                        </tr>

                        <!-- Materia Seleccionada 3 -->
                        <tr>
                            <td class="ps-4 fw-bold text-pink">RED101</td>
                            <td>
                                <div class="fw-semibold text-body">Redes de Computadoras I</div>
                                <small class="text-body-secondary">Prerrequisito: Arquitectura de PC</small>
                            </td>
                            <td><span class="badge bg-body-tertiary text-body border">4 UV</span></td>
                            <td>
                                <span class="d-block fw-semibold">Sec. 01</span>
                                <small class="text-body-secondary">Vie 01:00 - 05:00 PM</small>
                            </td>
                            <td class="text-body-secondary">Ing. Roberto Gómez</td>
                            <td><span class="badge bg-warning-subtle text-warning-emphasis">3 / 20</span></td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-outline-danger px-3 rounded-pill">
                                    <i class="bi bi-dash-circle me-1"></i> Quitar
                                </button>
                            </td>
                        </tr>

                        <!-- Materia Disponible para Agregar -->
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">MAT202</td>
                            <td>
                                <div class="fw-semibold text-body">Matemática Discreta</div>
                                <small class="text-body-secondary">Prerrequisito: Matemática I</small>
                            </td>
                            <td><span class="badge bg-body-tertiary text-body border">4 UV</span></td>
                            <td>
                                <span class="d-block fw-semibold">Sec. 01</span>
                                <small class="text-body-secondary">Lun - Mié 10:00 - 12:00 PM</small>
                            </td>
                            <td class="text-body-secondary">Dr. Carlos Fuentes</td>
                            <td><span class="badge bg-success-subtle text-success-emphasis">12 / 30</span></td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-pink text-white px-3 rounded-pill">
                                    <i class="bi bi-plus-circle me-1"></i> Agregar
                                </button>
                            </td>
                        </tr>

                        <!-- Materia Sin Cupo / Deshabilitada -->
                        <tr class="opacity-75">
                            <td class="ps-4 fw-bold text-secondary">FIS101</td>
                            <td>
                                <div class="fw-semibold text-body">Física General</div>
                                <small class="text-body-secondary">Prerrequisito: Matemática I</small>
                            </td>
                            <td><span class="badge bg-body-tertiary text-body border">4 UV</span></td>
                            <td>
                                <span class="d-block fw-semibold">Sec. 01</span>
                                <small class="text-body-secondary">Mar - Jue 08:00 - 10:00 AM</small>
                            </td>
                            <td class="text-body-secondary">Ing. Ana Martínez</td>
                            <td><span class="badge bg-danger-subtle text-danger-emphasis">Sin Cupo</span></td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-secondary px-3 rounded-pill" disabled>
                                    Agotado
                                </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Confirmar Inscripción -->
    <div class="modal fade" id="modalConfirmarInscripcion" tabindex="-1" aria-labelledby="modalConfirmarInscripcionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border border-secondary border-opacity-50 shadow-lg rounded-4 overflow-hidden">

                <div class="modal-header border-bottom border-secondary border-opacity-25 bg-dark px-4 pt-4 pb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-pink-subtle text-pink rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-card-checklist fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0" id="modalConfirmarInscripcionLabel">Confirmar Inscripción</h5>
                            <small class="text-secondary">Revisa tu selección antes de guardar</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 bg-dark">
                    <p class="text-light mb-3">Estás a punto de inscribir las siguientes <strong>3 asignaturas (12 UV)</strong> para el ciclo <strong>2026-II</strong>:</p>

                    <ul class="list-group list-group-flush bg-transparent rounded-3 mb-3 border border-secondary border-opacity-25 overflow-hidden">
                        <li class="list-group-item bg-dark text-white border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-pink me-2">PRG301</span> Programación Orientada a Objetos
                            </div>
                            <span class="badge bg-pink-subtle text-pink">4 UV</span>
                        </li>
                        <li class="list-group-item bg-dark text-white border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-pink me-2">BDD201</span> Bases de Datos I
                            </div>
                            <span class="badge bg-pink-subtle text-pink">4 UV</span>
                        </li>
                        <li class="list-group-item bg-dark text-white border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-pink me-2">RED101</span> Redes de Computadoras I
                            </div>
                            <span class="badge bg-pink-subtle text-pink">4 UV</span>
                        </li>
                    </ul>

                    <div class="alert bg-pink-subtle text-pink-emphasis border-0 rounded-3 mb-0 d-flex align-items-center gap-2 small">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <span>Una vez confirmada la inscripción, los cambios requerirán autorización de Registro Académico.</span>
                    </div>
                </div>

                <div class="modal-footer border-top border-secondary border-opacity-25 bg-dark px-4 py-3 gap-2">
                    <button type="button" class="btn btn-outline-secondary text-light border-secondary border-opacity-50 px-4 rounded-3" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-pink text-white px-4 fw-semibold rounded-3 shadow-sm d-flex align-items-center gap-2">
                        <i class="bi bi-check-lg fs-6"></i> Confirmar e Inscribir
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
