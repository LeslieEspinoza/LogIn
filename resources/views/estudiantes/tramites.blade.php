@extends('layout.layout')

@section('titulo', 'Gestión de Trámites')

@section('contenido')
    <div class="container-fluid py-3">

        <!-- ENCABEZADO -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <span class="icon-box-pink p-3 rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(236, 72, 153, 0.1);">
                <i class="bi bi-file-earmark-text fs-3 text-pink-accent"></i>
            </span>
            <div>
                <h3 class="fw-bold text-white mb-0">Mis Trámites</h3>
                <p class="text-secondary small mb-0">Solicitudes y constancias académicas</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Formulario de Nueva Solicitud -->
            <div class="col-12 col-lg-5">
                <div class="card bg-dark border-secondary border-opacity-25 rounded-4 shadow-sm h-100">
                    <div class="card-header border-secondary border-opacity-25 bg-transparent pt-3 pb-2">
                        <h6 class="text-white fw-bold mb-0"><i class="bi bi-plus-circle text-pink-subtle me-2"></i>Nueva Solicitud</h6>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Tipo de Trámite</label>
                                <select class="form-select bg-dark text-white border-secondary border-opacity-50">
                                    <option value="">Selecciona una opción...</option>
                                    <option value="1">Constancia de Estudio</option>
                                    <option value="2">Constancia de Notas (Kárdex Oficial)</option>
                                    <option value="3">Revisión de Calificación</option>
                                    <option value="4">Justificación de Inasistencia</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Detalles o Justificación</label>
                                <textarea class="form-control bg-dark text-white border-secondary border-opacity-50" rows="3" placeholder="Explica brevemente tu solicitud..."></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-secondary small">Documento Adjunto (Opcional)</label>
                                <input type="file" class="form-control bg-dark text-secondary border-secondary border-opacity-50">
                            </div>
                            <button type="submit" class="btn w-100 fw-bold rounded-pill" style="background-color: #ec4899; color: white;">
                                Enviar Solicitud
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Historial de Trámites -->
            <div class="col-12 col-lg-7">
                <div class="card bg-dark border-secondary border-opacity-25 rounded-4 shadow-sm h-100">
                    <div class="card-header border-secondary border-opacity-25 bg-transparent pt-3 pb-2">
                        <h6 class="text-white fw-bold mb-0"><i class="bi bi-clock-history text-pink-subtle me-2"></i>Estado de mis trámites</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0 align-middle">
                                <thead class="bg-body-secondary text-secondary small text-uppercase">
                                <tr>
                                    <th class="py-3 ps-4">Trámite</th>
                                    <th class="py-3 text-center">Fecha</th>
                                    <th class="py-3 text-center">Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Datos simulados -->
                                <tr>
                                    <td class="ps-4 py-3">
                                        <strong class="d-block text-white">Constancia de Estudio</strong>
                                        <small class="text-secondary">Para trámite de pasantía</small>
                                    </td>
                                    <td class="text-center text-secondary small">12 Oct 2026</td>
                                    <td class="text-center">
                                        <span class="badge bg-success bg-opacity-25 text-success border border-success rounded-pill px-3">Completado</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <strong class="d-block text-white">Revisión de Calificación</strong>
                                        <small class="text-secondary">INF-204 (Parcial 1)</small>
                                    </td>
                                    <td class="text-center text-secondary small">02 Nov 2026</td>
                                    <td class="text-center">
                                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning rounded-pill px-3">En Proceso</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
