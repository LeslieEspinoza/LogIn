@extends('layout.layout')

@section('titulo', 'Mi Horario de Clases')

@section('contenido')
    <div class="container-fluid py-3">

        <!-- ENCABEZADO -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <span class="icon-box-pink p-3 rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(236, 72, 153, 0.1);">
                    <i class="bi bi-calendar3 fs-3 text-pink-accent"></i>
                </span>
                <div>
                    <h3 class="fw-bold text-white mb-0">Mi Horario de Clases</h3>
                    <p class="text-secondary small mb-0">Ciclo Activo 2026-II</p>
                </div>
            </div>
            <button class="btn btn-outline-light rounded-pill px-4 btn-sm d-none d-md-flex align-items-center gap-2" onclick="window.print()">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>

        <div class="card bg-dark border-secondary border-opacity-25 rounded-4 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-bordered border-secondary border-opacity-25 mb-0 text-center align-middle" style="min-width: 800px;">
                        <thead class="bg-body-secondary text-pink-subtle small text-uppercase">
                        <tr>
                            <th class="py-3" style="width: 10%;">Hora</th>
                            <th class="py-3" style="width: 18%;">Lunes</th>
                            <th class="py-3" style="width: 18%;">Martes</th>
                            <th class="py-3" style="width: 18%;">Miércoles</th>
                            <th class="py-3" style="width: 18%;">Jueves</th>
                            <th class="py-3" style="width: 18%;">Viernes</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($secciones as $seccion)
                            <!-- Aquí iteramos las materias. Por ahora mostramos una lista plana hasta que la BD tenga los días exactos -->
                            <tr>
                                <td class="text-secondary fw-bold">
                                    08:00 AM <br>
                                    <small class="text-muted">09:30 AM</small>
                                </td>
                                <td>
                                    <div class="p-2 rounded-3" style="background: rgba(236, 72, 153, 0.1); border-left: 3px solid #ec4899;">
                                        <strong class="d-block text-white small">{{ $seccion->materia->nombre ?? 'Materia' }}</strong>
                                        <small class="text-pink-subtle">{{ $seccion->aula ?? 'Aula por asignar' }}</small>
                                    </div>
                                </td>
                                <td class="text-secondary opacity-50">-</td>
                                <td class="text-secondary opacity-50">-</td>
                                <td class="text-secondary opacity-50">-</td>
                                <td class="text-secondary opacity-50">-</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-5 text-center text-secondary">
                                    <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                    No tienes materias inscritas para este ciclo.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Estilo especial para la impresión del horario -->
    <style type="text/css" media="print">
        body * { visibility: hidden; }
        .table-responsive, .table-responsive * { visibility: visible; }
        .table-responsive { position: absolute; left: 0; top: 0; width: 100%; }
        .app-sidebar, .app-header { display: none !important; }
    </style>
@endsection
