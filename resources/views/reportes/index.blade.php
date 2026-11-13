@extends('layout.layout')

@section('titulo', 'Centro de Reportes')

@section('contenido')
    <div class="container-fluid py-3">

        <!-- ENCABEZADO DE SECCIÓN -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                <span class="icon-box-pink">
                    <i class="bi bi-file-earmark-bar-graph fs-4"></i>
                </span>
                    <h3 class="fw-bold text-white mb-0">Centro de Reportes</h3>
                </div>
                <p class="text-secondary small mb-0 ms-md-5">
                    Generación de expedientes institucionales en formato PDF, Excel y envío por correo electrónico.
                </p>
            </div>
        </div>

        <!-- ALERTA DE ÉXITO (AUTO-DESVANECIMIENTO 3S) -->
        @if(session('success'))
            <div id="alert-success" class="alert alert-success bg-success bg-opacity-20 border-success text-white rounded-3 mb-4 d-flex align-items-center gap-2" style="transition: opacity 0.5s ease;">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <span>{{ session('success') }}</span>
            </div>

            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alert-success');
                    if (alertElement) {
                        alertElement.style.opacity = '0';
                        setTimeout(() => alertElement.remove(), 500);
                    }
                }, 3000);
            </script>
        @endif

        <div class="row g-4">

            <!-- SELECCIÓN DE ESTUDIANTE -->
            <div class="col-12 col-lg-5 col-xl-4">
                <div class="reporte-card-main h-100">
                    <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-people text-pink-accent"></i> Seleccionar Estudiante
                    </h5>

                    <div class="d-flex flex-column gap-2 mb-3">
                        @forelse($estudiantes as $est)
                            <a href="{{ route('reportes.index', ['estudiante_id' => $est->id]) }}"
                               class="estudiante-select-card p-3 text-decoration-none d-flex justify-content-between align-items-center"
                               style="{{ ($estudianteSeleccionado && $estudianteSeleccionado->id == $est->id) ? 'border-color: #ec4899 !important; background: rgba(236, 72, 153, 0.08);' : '' }}">
                                <div>
                                    <h6 class="fw-bold text-white mb-0">{{ $est->user->name ?? 'Estudiante' }}</h6>
                                    <small class="text-secondary">{{ $est->carrera->nombre ?? 'Sin Carrera' }}</small>
                                </div>
                                <i class="bi bi-chevron-right text-pink-subtle"></i>
                            </a>
                        @empty
                            <p class="text-secondary small">No hay estudiantes registrados.</p>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $estudiantes->links() }}
                    </div>
                </div>
            </div>

            <!-- DETALLE Y ACCIONES -->
            <div class="col-12 col-lg-7 col-xl-8">
                @if($estudianteSeleccionado)
                    <div class="reporte-card-main">

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom border-secondary border-opacity-25 pb-3 mb-4 gap-3">
                            <div>
                            <span class="badge bg-danger bg-opacity-25 text-pink-subtle px-3 py-1 rounded-pill fw-bold mb-1">
                                Detalle del Reporte
                            </span>
                                <h4 class="fw-bold text-white mb-0">{{ $estudianteSeleccionado->user->name }}</h4>
                                <small class="text-secondary">{{ $estudianteSeleccionado->user->email }}</small>
                            </div>

                            <!-- PANEL PRINCIPAL CON LOS 3 BOTONES DE ACCIÓN -->
                            <div class="d-flex flex-wrap align-items-center gap-2">

                                <!-- 1. BOTÓN PDF -->
                                <button type="button" class="btn btn-reporte-pdf d-flex align-items-center gap-2 px-3 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#modalOpcionesPdf">
                                    <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                                    <span>PDF</span>
                                </button>

                                <!-- 2. BOTÓN EXCEL -->
                                <button type="button" class="btn btn-reporte-excel d-flex align-items-center gap-2 px-3 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#modalOpcionesExcel">
                                    <i class="bi bi-file-earmark-excel-fill fs-5"></i>
                                    <span>Excel</span>
                                </button>

                                <!-- 3. BOTÓN ENVIAR CORREO DIRECTO -->
                                <button type="button" class="btn btn-pink-gradient d-flex align-items-center gap-2 px-3 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#modalEnviarCorreo">
                                    <i class="bi bi-envelope-fill"></i>
                                    <span>Enviar Correo</span>
                                </button>

                            </div>
                        </div>

                        <!-- RESUMEN EN PANTALLA -->
                        <div class="p-3 rounded-4" style="background: #111827; border: 1px solid rgba(255, 255, 255, 0.05);">
                            <h6 class="fw-bold text-pink-accent mb-3">Resumen Informativo del Expediente</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <span class="text-secondary small d-block">Carrera Asignada:</span>
                                    <strong class="text-white">{{ $estudianteSeleccionado->carrera->nombre ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    <span class="text-secondary small d-block">Nivel Académico:</span>
                                    <strong class="text-white text-capitalize">{{ $estudianteSeleccionado->nivel_academico }}</strong>
                                </div>
                            </div>

                            <h6 class="fw-bold text-white mt-4 mb-2 small text-uppercase">Materias e Inscripciones</h6>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover mb-0 align-middle">
                                    <thead>
                                    <tr class="text-pink-subtle small">
                                        <th>Materia</th>
                                        <th>Aula</th>
                                        <th>Hora</th>
                                        <th class="text-end">Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($estudianteSeleccionado->secciones as $seccion)
                                        <tr>
                                            <td class="text-white fw-medium">{{ $seccion->materia->nombre ?? 'Materia' }}</td>
                                            <td class="text-secondary small">{{ $seccion->aula }}</td>
                                            <td class="text-end"><span class="badge bg-success bg-opacity-25 text-success">Inscrito</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-secondary small py-3">No hay materias inscritas.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- MODAL 1: OPCIONES PDF -->
                    <div class="modal fade" id="modalOpcionesPdf" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-white border border-secondary border-opacity-50 rounded-4 shadow-lg">
                                <div class="modal-header border-bottom border-secondary border-opacity-25 p-4">
                                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-pdf-fill text-danger"></i> Exportar Expediente en PDF
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="p-3 mb-4 rounded-3" style="background: #111827; border: 1px solid rgba(255,255,255,0.08);">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="fw-bold text-white mb-1"><i class="bi bi-download text-danger me-1"></i> Descargar Documento</h6>
                                                <small class="text-secondary">Obtener archivo PDF en el equipo.</small>
                                            </div>
                                            <a href="{{ route('reportes.expediente.pdf', $estudianteSeleccionado->id) }}" class="btn btn-danger rounded-3 px-3">Descargar</a>
                                        </div>
                                    </div>
                                    <div class="text-center text-secondary small my-2">O si prefieres enviarlo:</div>
                                    <form action="{{ route('reportes.expediente.pdf.correo', $estudianteSeleccionado->id) }}" method="POST" class="p-3 rounded-3" style="background: #111827; border: 1px solid rgba(255,255,255,0.08);">
                                        @csrf
                                        <h6 class="fw-bold text-white mb-2"><i class="bi bi-send text-pink-accent me-1"></i> Enviar por Correo</h6>
                                        <div class="mb-3">
                                            <label class="form-label text-secondary small fw-bold">Correo Destinatario</label>
                                            <input type="email" name="email_destino" value="{{ $estudianteSeleccionado->user->email }}" class="form-control bg-dark text-white border-secondary border-opacity-50 rounded-3 p-2" required>
                                        </div>
                                        <button type="submit" class="btn btn-pink-gradient w-100">Enviar PDF por Correo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL 2: OPCIONES EXCEL -->
                    <div class="modal fade" id="modalOpcionesExcel" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-white border border-secondary border-opacity-50 rounded-4 shadow-lg">
                                <div class="modal-header border-bottom border-secondary border-opacity-25 p-4">
                                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-excel-fill text-success"></i> Exportar Expediente en Excel
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="p-3 mb-4 rounded-3" style="background: #111827; border: 1px solid rgba(255,255,255,0.08);">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="fw-bold text-white mb-1"><i class="bi bi-download text-success me-1"></i> Descargar Archivo</h6>
                                                <small class="text-secondary">Obtener libro de cálculo (.xlsx).</small>
                                            </div>
                                            <a href="{{ route('reportes.expediente.excel', $estudianteSeleccionado->id) }}" class="btn btn-success rounded-3 px-3">Descargar</a>
                                        </div>
                                    </div>
                                    <div class="text-center text-secondary small my-2">O si prefieres enviarlo:</div>
                                    <form action="{{ route('reportes.expediente.excel.correo', $estudianteSeleccionado->id) }}" method="POST" class="p-3 rounded-3" style="background: #111827; border: 1px solid rgba(255,255,255,0.08);">
                                        @csrf
                                        <h6 class="fw-bold text-white mb-2"><i class="bi bi-send text-pink-accent me-1"></i> Enviar por Correo</h6>
                                        <div class="mb-3">
                                            <label class="form-label text-secondary small fw-bold">Correo Destinatario</label>
                                            <input type="email" name="email_destino" value="{{ $estudianteSeleccionado->user->email }}" class="form-control bg-dark text-white border-secondary border-opacity-50 rounded-3 p-2" required>
                                        </div>
                                        <button type="submit" class="btn btn-pink-gradient w-100">Enviar Excel por Correo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL 3: ENVIAR CORREO DIRECTO -->
                    <div class="modal fade" id="modalEnviarCorreo" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-white border border-secondary border-opacity-50 rounded-4 shadow-lg">
                                <div class="modal-header border-bottom border-secondary border-opacity-25 p-4">
                                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                                        <i class="bi bi-envelope-fill text-pink-accent"></i> Enviar Expediente por Correo
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('reportes.expediente.correo', $estudianteSeleccionado->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body p-4">
                                        <p class="text-secondary small mb-3">
                                            Envío directo de la notificación del expediente académico al correo del estudiante.
                                        </p>

                                        <div class="mb-3">
                                            <label class="form-label text-secondary small fw-bold">Correo Electrónico Destinatario</label>
                                            <input
                                                type="email"
                                                name="email_destino"
                                                value="{{ $estudianteSeleccionado->user->email }}"
                                                class="form-control bg-dark text-white border-secondary border-opacity-50 rounded-3 p-3"
                                                required>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-top border-secondary border-opacity-25 p-3">
                                        <button type="button" class="btn btn-outline-light rounded-3 px-4" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-pink-gradient px-4">Enviar Ahora →</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="reporte-card-main text-center py-5">
                        <i class="bi bi-folder-x fs-1 text-secondary mb-2"></i>
                        <h5 class="text-white fw-bold">Selecciona un estudiante</h5>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
