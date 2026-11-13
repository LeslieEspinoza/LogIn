@extends('layout.layout')

@section('titulo', 'Mis Inscripciones')

@section('contenido')
    <div class="container-fluid py-3">

        <!-- ENCABEZADO -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <span class="icon-box-pink p-3 rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(236, 72, 153, 0.1);">
                <i class="bi bi-journal-check fs-3 text-pink-accent"></i>
            </span>
            <div>
                <h3 class="fw-bold text-white mb-0">Mis Inscripciones</h3>
                <p class="text-secondary small mb-0">Materias en las que estás inscrito en el ciclo actual</p>
            </div>
        </div>

        <!-- TABLA DE INSCRIPCIONES -->
        <div class="card bg-dark border-secondary border-opacity-25 rounded-4 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle">
                        <thead class="bg-body-secondary text-secondary small text-uppercase">
                        <tr>
                            <th class="py-3 ps-4">Materia</th>
                            <th class="py-3 text-center">Sección</th>
                            <th class="py-3 text-center">Aula / Modalidad</th>
                            <th class="py-3 text-center pe-4">Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($inscripciones as $seccion)
                            <tr>
                                <td class="ps-4 py-3">
                                    <strong class="d-block text-white">{{ $seccion->materia->nombre ?? 'Materia sin nombre' }}</strong>
                                    <small class="text-pink-subtle">Código: {{ $seccion->materia->codigo ?? 'N/A' }}</small>
                                </td>
                                <td class="text-center text-secondary">{{ $seccion->nombre ?? '01' }}</td>
                                <td class="text-center text-secondary">{{ $seccion->aula ?? 'Por asignar' }}</td>
                                <td class="text-center pe-4">
                                    <span class="badge bg-success bg-opacity-25 text-success border border-success rounded-pill px-3">Inscrita</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-5 text-center text-secondary">
                                    <div class="mb-3">
                                        <i class="bi bi-journal-x opacity-50" style="font-size: 3rem;"></i>
                                    </div>
                                    <h6 class="text-white">Sin inscripciones</h6>
                                    <p class="mb-0">Aún no tienes materias inscritas para este ciclo académico.</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
