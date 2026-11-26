@extends('layout.layout')

@section('titulo', 'Gestión de Profesores')

@push('estilos')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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
            <div class="col-md-6">
                <h3 class="mb-0 fw-bold text-body">
                    <i class="bi bi-person-workspace text-pink me-2"></i>Docentes Registrados
                </h3>
                <p class="text-body-secondary small mb-0 mt-1">Administra la plantilla docente y sus credenciales de acceso al portal.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button type="button" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCrearProfesor">
                    <i class="bi bi-plus-lg me-1"></i> Registrar Profesor
                </button>
            </div>
        </div>

        {{-- Tabla Principal --}}
        <div class="card border-0 shadow-sm rounded-4 bg-body">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="tablaProfesores" class="table table-hover align-middle w-100">
                        <thead>
                        <tr class="text-body-secondary border-bottom">
                            <th class="ps-3">Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo Electrónico</th>
                            <th>Teléfono</th>
                            <th>Estado de Cuenta</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($profesores as $profesor)
                            <tr>
                                <td class="ps-3 fw-semibold text-body">{{ $profesor->nombres }}</td>
                                <td class="text-body">{{ $profesor->apellidos }}</td>
                                <td class="text-body-secondary">{{ $profesor->email }}</td>
                                <td class="text-body-secondary">{{ $profesor->telefono ?? 'No registrado' }}</td>
                                <td>
                                    @if(!$profesor->user)
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                            <i class="bi bi-dash-circle me-1"></i> Sin Cuenta
                                        </span>
                                    @elseif($profesor->user->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                          <i class="bi bi-check-circle me-1"></i> Activo
                                         </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                            <i class="bi bi-slash-circle me-1"></i> Suspendido
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                        {{-- Botón Editar Datos --}}
                                        <button type="button" class="btn btn-sm btn-outline-light border-secondary text-body btn-editar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarProfesor"
                                                data-id="{{ $profesor->id }}"
                                                data-nombres="{{ $profesor->nombres }}"
                                                data-apellidos="{{ $profesor->apellidos }}"
                                                data-email="{{ $profesor->email }}"
                                                data-telefono="{{ $profesor->telefono }}"
                                                title="Editar Docente">
                                            <i class="bi bi-pencil text-pink"></i>
                                        </button>

                                        @if(!$profesor->user)
                                            {{-- Crear Cuenta si aún no tiene --}}
                                            <form action="{{ route('admin.profesores.crear_cuenta', $profesor) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Generar cuenta de acceso para {{ $profesor->nombres }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Crear Cuenta de Acceso">
                                                    <i class="bi bi-person-plus"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Restablecer Contraseña --}}
                                            <form action="{{ route('admin.profesores.reset_password', $profesor) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Generar nueva contraseña temporal para {{ $profesor->nombres }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Restablecer Contraseña">
                                                    <i class="bi bi-key"></i>
                                                </button>
                                            </form>

                                            {{-- Activar / Suspender Acceso --}}
                                            <form action="{{ route('admin.profesores.toggle_estado', $profesor) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Cambiar estado de acceso para {{ $profesor->nombres }}?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm {{ $profesor->user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}" title="{{ $profesor->user->is_active ? 'Suspender Acceso' : 'Activar Acceso' }}">
                                                    <i class="bi {{ $profesor->user->is_active ? 'bi-person-slash' : 'bi-person-check' }}"></i>
                                                </button>
                                            </form>
                                        @endif
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

    <!-- MODAL CREAR PROFESOR -->
    <div class="modal fade" id="modalCrearProfesor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary shadow-lg">
                <form action="{{ route('admin.profesores.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-secondary pb-3">
                        <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                            <i class="bi bi-person-plus text-pink fs-5"></i> Registrar Nuevo Profesor
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-light">Nombres <span class="text-pink">*</span></label>
                            <input type="text" name="nombres" class="form-control bg-body-tertiary text-white border-secondary" placeholder="Ej. Carlos Alberto" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-light">Apellidos <span class="text-pink">*</span></label>
                            <input type="text" name="apellidos" class="form-control bg-body-tertiary text-white border-secondary" placeholder="Ej. Mendoza López" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-light">Correo Institucional <span class="text-pink">*</span></label>
                            <input type="email" name="email" class="form-control bg-body-tertiary text-white border-secondary" placeholder="docente@institucion.edu" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-light">Teléfono</label>
                            <input type="text" name="telefono" class="form-control bg-body-tertiary text-white border-secondary" placeholder="Ej. 7777-8888">
                        </div>
                        <div class="form-check form-switch mt-4 pt-2 border-top border-secondary">
                            <input class="form-check-input" type="checkbox" name="crear_usuario" value="1" id="checkCrearUsuario" checked>
                            <label class="form-check-label text-light" for="checkCrearUsuario">
                                Crear cuenta de acceso automáticamente (Rol Docente)
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary pt-3">
                        <button type="button" class="btn btn-outline-light px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Guardar Profesor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR PROFESOR -->
    <div class="modal fade" id="modalEditarProfesor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary shadow-lg">
                <form id="formEditarProfesor" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-secondary pb-3">
                        <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                            <i class="bi bi-pencil-square text-pink fs-5"></i> Editar Datos del Profesor
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-light">Nombres <span class="text-pink">*</span></label>
                            <input type="text" name="nombres" id="edit_nombres" class="form-control bg-body-tertiary text-white border-secondary" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-light">Apellidos <span class="text-pink">*</span></label>
                            <input type="text" name="apellidos" id="edit_apellidos" class="form-control bg-body-tertiary text-white border-secondary" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-light">Correo Institucional <span class="text-pink">*</span></label>
                            <input type="email" name="email" id="edit_email" class="form-control bg-body-tertiary text-white border-secondary" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-light">Teléfono</label>
                            <input type="text" name="telefono" id="edit_telefono" class="form-control bg-body-tertiary text-white border-secondary">
                        </div>
                    </div>
                    <div class="modal-footer border-secondary pt-3">
                        <button type="button" class="btn btn-outline-light px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Actualizar Datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('credenciales'))
        <!-- MODAL CREDENCIALES GENERADAS -->
        <div class="modal fade" id="modalCredenciales" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white border-secondary shadow-lg">
                    <div class="modal-header border-secondary pb-3">
                        <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock-fill text-pink fs-4"></i> Credenciales de Acceso Generadas
                        </h5>
                    </div>
                    <div class="modal-body py-4">
                        <p class="text-body-secondary small mb-3">
                            Se ha creado la cuenta institucional para <strong class="text-white">{{ session('credenciales')['nombre'] }}</strong>. Entrega estas credenciales al docente:
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
            $('#tablaProfesores').DataTable({
                language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
                pageLength: 10,
                ordering: true,
                responsive: true
            });

            // Cargar datos en el modal de edición
            $('.btn-editar').on('click', function() {
                let id = $(this).data('id');
                $('#edit_nombres').val($(this).data('nombres'));
                $('#edit_apellidos').val($(this).data('apellidos'));
                $('#edit_email').val($(this).data('email'));
                $('#edit_telefono').val($(this).data('telefono'));

                $('#formEditarProfesor').attr('action', `/admin/profesores/${id}`);
            });
        });

        @if(session('credenciales'))
        // Abrir el modal automáticamente
        let modalCredenciales = new bootstrap.Modal(document.getElementById('modalCredenciales'));
        modalCredenciales.show();

        // Lógica para copiar al portapapeles
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
