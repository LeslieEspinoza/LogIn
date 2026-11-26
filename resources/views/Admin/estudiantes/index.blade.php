@extends('layout.layout')

@section('titulo', 'Gestión de Estudiantes')

@push('estilos')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte-colors.css') }}">
@endpush

@section('contenido')
    <div class="container-fluid">

        {{-- Alertas de Feedback --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Encabezado de la Página --}}
        <div class="row mb-4 align-items-center">
            <div class="col-12">
                <h3 class="mb-0 fw-bold text-body">
                    <i class="bi bi-mortarboard-fill text-pink me-2"></i>Directorio de Estudiantes
                </h3>
                <p class="text-body-secondary small mb-0 mt-1">Gestión de expedientes, generación de kárdex oficial y credenciales de acceso.</p>
            </div>
        </div>

        {{-- Tabla Principal --}}
        <div class="card border-0 shadow-sm rounded-4 bg-body">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="tablaEstudiantes" class="table table-hover align-middle w-100">
                        <thead>
                        <tr class="text-body-secondary border-bottom">
                            <th class="ps-3">Documento / Carnet</th>
                            <th>Nombre Completo</th>
                            <th>Correo Institucional</th>
                            <th class="text-center">Estado de Expediente</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($estudiantes as $estudiante)
                            <tr>
                                <td class="ps-3 fw-semibold text-body">{{ $estudiante->documento_identidad }}</td>
                                <td class="fw-semibold text-pink">{{ $estudiante->user->name ?? $estudiante->usuario->name ?? 'Sin usuario' }}</td>
                                <td class="text-body-secondary">{{ $estudiante->user->email ?? $estudiante->usuario->email ?? 'N/A' }}</td>

                                <td class="text-center">
                                    @if($estudiante->expediente_aprobado)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1">
                                        <i class="bi bi-check-circle me-1"></i> Aprobado
                                    </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1">
                                        <i class="bi bi-clock-history me-1"></i> Pendiente
                                    </span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                        {{-- Botón Aprobar Expediente --}}
                                        @if(!$estudiante->expediente_aprobado)
                                            <form action="{{ route('admin.estudiantes.aprobar', $estudiante) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Aprobar expediente de {{ $estudiante->user->name ?? 'este estudiante' }}?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Aprobar Expediente">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Botón Descargar Kárdex PDF --}}
                                        <a href="{{ route('admin.estudiantes.kardex', $estudiante) }}" class="btn btn-sm btn-outline-info" title="Descargar Kárdex PDF">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>

                                        {{-- Botón Restablecer Contraseña --}}
                                        <form action="{{ route('admin.estudiantes.reset_password', $estudiante) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Generar nueva contraseña temporal para {{ $estudiante->user->name ?? 'este estudiante' }}?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Restablecer Contraseña">
                                                <i class="bi bi-key"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if(session('credenciales'))
        <!-- MODAL CREDENCIALES RESTABLECIDAS -->
        <div class="modal fade" id="modalCredenciales" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white border-secondary shadow-lg">
                    <div class="modal-header border-secondary pb-3">
                        <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock-fill text-pink fs-4"></i> Nueva Contraseña Temporal
                        </h5>
                    </div>
                    <div class="modal-body py-4">
                        <p class="text-body-secondary small mb-3">
                            Se ha restablecido el acceso para <strong class="text-white">{{ session('credenciales')['nombre'] }}</strong>. Entrega estas credenciales al estudiante:
                        </p>

                        <div class="p-3 rounded-3 bg-body-tertiary border border-secondary mb-3">
                            <div class="mb-2">
                                <span class="text-body-secondary small d-block">Correo Institucional:</span>
                                <span class="fw-semibold text-white">{{ session('credenciales')['email'] }}</span>
                            </div>
                            <div>
                                <span class="text-body-secondary small d-block">Contraseña Temporal:</span>
                                <div class="input-group mt-1">
                                    <input type="text" id="inputTempPassword" class="form-control bg-dark text-pink fw-bold border-secondary font-monospace" value="{{ session('credenciales')['password'] }}" readonly>
                                    <button class="btn btn-outline-light border-secondary" type="button" id="btnCopiarPassword" title="Copiar contraseña">
                                        <i class="bi bi-clipboard me-1"></i> Copiar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning bg-warning-subtle text-warning border-warning-subtle small mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                            <div>Por seguridad, esta contraseña no volverá a mostrarse una vez que cierres esta ventana.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary pt-3">
                        <button type="button" class="btn btn-primary px-4 fw-semibold w-100" data-bs-dismiss="modal">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaEstudiantes').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                pageLength: 10,
                ordering: true,
                responsive: true,
                columnDefs: [
                    { orderable: false, targets: [4] } // Desactiva el ordenamiento en la columna de Acciones
                ]
            });
        });

        @if(session('credenciales'))
        let modalCredenciales = new bootstrap.Modal(document.getElementById('modalCredenciales'));
        modalCredenciales.show();

        $('#btnCopiarPassword').on('click', function() {
            let inputPass = document.getElementById('inputTempPassword');
            navigator.clipboard.writeText(inputPass.value);

            $(this).html('<i class="bi bi-check-lg text-success me-1"></i> ¡Copiada!');
            setTimeout(() => {
                $(this).html('<i class="bi bi-clipboard me-1"></i> Copiar');
            }, 2500);
        });
        @endif
    </script>
@endpush
