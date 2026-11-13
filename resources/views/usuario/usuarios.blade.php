@extends('layout.layout')

@section('titulo', 'Usuarios')

@push('estilos')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte-colors.css') }}">
@endpush

@section('contenido')
    <div class="container-fluid py-2">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">Gestión de Usuarios</h3>
                <p class="text-body-secondary small mb-0">Administra los accesos y asignación de roles</p>
            </div>
            <button type="button" class="btn btn-pink text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm bg-body">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($usuarios as $user)
                            <tr>
                                <td class="ps-4 fw-semibold text-pink">{{ $user->name }}</td>
                                <td class="text-body-secondary">{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-pink-subtle text-pink-emphasis rounded-pill px-3 py-2">
                                        {{ $user->rol->nombre ?? 'Sin Rol' }}
                                    </span>
                                </td>
                                <!-- Columna de Acciones -->
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <!-- Botón Editar con icono rosa -->
                                        <button type="button"
                                                class="btn btn-sm btn-outline-warning border-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarUsuario{{ $user->id }}"
                                                title="Editar Usuario">
                                            <i class="bi bi-pencil-fill fs-6 text-pink"></i>
                                        </button>
                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('usuarios.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a {{ $user->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Eliminar Usuario">
                                                <i class="bi bi-trash-fill fs-6"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Editar Usuario -->
                                    <div class="modal fade text-start" id="modalEditarUsuario{{ $user->id }}" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-dark text-white border border-secondary border-opacity-50 shadow-lg rounded-4 overflow-hidden">

                                                <form action="{{ route('usuarios.actualizar', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Encabezado con Badge de Icono Rosa -->
                                                    <div class="modal-header border-bottom border-secondary border-opacity-25 bg-dark px-4 pt-4 pb-3">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="bg-pink-subtle text-pink rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                                                <i class="bi bi-pencil-square fs-5"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="modal-title fw-bold text-white mb-0" id="modalEditarUsuarioLabel{{ $user->id }}">Actualizar Usuario</h5>
                                                                <small class="text-secondary">Modifica la información o permisos de la cuenta</small>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn-close btn-close-white align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <!-- Cuerpo del Modal -->
                                                    <div class="modal-body p-4 bg-dark">

                                                        <!-- Campo Rol -->
                                                        <div class="mb-3">
                                                            <label for="rol_id_{{ $user->id }}" class="form-label fw-semibold text-light small mb-1">
                                                                <i class="bi bi-shield-lock text-pink me-1"></i> Rol de Usuario
                                                            </label>
                                                            <div class="input-group">
                            <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                                <i class="bi bi-person-badge"></i>
                            </span>
                                                                <select name="rol_id" id="rol_id_{{ $user->id }}" class="form-select bg-dark text-white border-secondary border-opacity-50 @error('rol_id') is-invalid @enderror" required>
                                                                    <option value="" class="bg-dark text-white">Seleccione un rol...</option>
                                                                    @foreach($roles as $rol)
                                                                        <option value="{{ $rol->id }}" class="bg-dark text-white" {{ old('rol_id', $user->rol_id) == $rol->id ? 'selected' : '' }}>
                                                                            {{ $rol->nombre }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @error('rol_id')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- Campo Nombre -->
                                                        <div class="mb-3">
                                                            <label for="name_{{ $user->id }}" class="form-label fw-semibold text-light small mb-1">
                                                                <i class="bi bi-person text-pink me-1"></i> Nombre Completo
                                                            </label>
                                                            <div class="input-group">
                            <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                                <i class="bi bi-person-vcard"></i>
                            </span>
                                                                <input type="text" name="name" id="name_{{ $user->id }}" value="{{ old('name', $user->name) }}"
                                                                       class="form-control bg-dark text-white border-secondary border-opacity-50 @error('name') is-invalid @enderror" required>
                                                            </div>
                                                            @error('name')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- Campo Correo Electrónico -->
                                                        <div class="mb-3">
                                                            <label for="email_{{ $user->id }}" class="form-label fw-semibold text-light small mb-1">
                                                                <i class="bi bi-envelope text-pink me-1"></i> Correo Electrónico
                                                            </label>
                                                            <div class="input-group">
                            <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                                <i class="bi bi-at"></i>
                            </span>
                                                                <input type="email" name="email" id="email_{{ $user->id }}" value="{{ old('email', $user->email) }}"
                                                                       class="form-control bg-dark text-white border-secondary border-opacity-50 @error('email') is-invalid @enderror" required>
                                                            </div>
                                                            @error('email')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- Campo Contraseña -->
                                                        <div class="mb-3">
                                                            <label for="password_{{ $user->id }}" class="form-label fw-semibold text-light small mb-1">
                                                                <i class="bi bi-key text-pink me-1"></i> Nueva Contraseña (Opcional)
                                                            </label>
                                                            <div class="input-group">
                                                               <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                                                               <i class="bi bi-lock"></i>
                                                               </span>
                                                                <input type="password" name="password" id="password_{{ $user->id }}"
                                                                       class="form-control bg-dark text-white border-secondary border-opacity-50 @error('password') is-invalid @enderror"
                                                                       placeholder="••••••••">
                                                            </div>
                                                            <span class="form-text text-secondary small">Déjalo en blanco para mantener la contraseña actual.</span>
                                                            @error('password')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                    <!-- Pie del Modal -->
                                                    <div class="modal-footer border-top border-secondary border-opacity-25 bg-dark px-4 py-3 gap-2">
                                                        <button type="button" class="btn btn-outline-secondary text-light border-secondary border-opacity-50 px-4 rounded-3" data-bs-dismiss="modal">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit" class="btn btn-pink text-white px-4 fw-semibold rounded-3 shadow-sm d-flex align-items-center gap-2">
                                                            <i class="bi bi-arrow-repeat fs-6"></i> Actualizar Usuario
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin Modal Editar -->

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-body-secondary">
                                    No se encontraron usuarios registrados.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo Usuario -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border border-secondary border-opacity-50 shadow-lg rounded-4 overflow-hidden">

                <form action="{{ route('usuarios.insertar') }}" method="POST">
                    @csrf

                    <!-- Encabezado con Badge de Icono Rosa -->
                    <div class="modal-header border-bottom border-secondary border-opacity-25 bg-dark px-4 pt-4 pb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-pink-subtle text-pink rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                <i class="bi bi-person-plus-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold text-white mb-0" id="modalUsuarioLabel">Registrar Usuario</h5>
                                <small class="text-secondary">Ingresa la información para crear una nueva cuenta</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Cuerpo del Modal -->
                    <div class="modal-body p-4 bg-dark">

                        <!-- Campo Rol -->
                        <div class="mb-3">
                            <label for="rol_id" class="form-label fw-semibold text-light small mb-1">
                                <i class="bi bi-shield-lock text-pink me-1"></i> Rol de Usuario
                            </label>
                            <div class="input-group">
                            <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                                <i class="bi bi-person-badge"></i>
                            </span>
                                <select name="rol_id" id="rol_id" class="form-select bg-dark text-white border-secondary border-opacity-50 @error('rol_id') is-invalid @enderror">
                                    <option value="" class="bg-dark text-white">Seleccione un rol...</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}" class="bg-dark text-white" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
                                            {{ $rol->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('rol_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Nombre -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-light small mb-1">
                                <i class="bi bi-person text-pink me-1"></i> Nombre Completo
                            </label>
                            <div class="input-group">
                            <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                                <i class="bi bi-person-vcard"></i>
                            </span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                       class="form-control bg-dark text-white border-secondary border-opacity-50 @error('name') is-invalid @enderror"
                                       placeholder="Ej: Juan Pérez">
                            </div>
                            @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Correo Electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-light small mb-1">
                                <i class="bi bi-envelope text-pink me-1"></i> Correo Electrónico
                            </label>
                            <div class="input-group">
                            <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                                <i class="bi bi-at"></i>
                            </span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       class="form-control bg-dark text-white border-secondary border-opacity-50 @error('email') is-invalid @enderror"
                                       placeholder="correo@ejemplo.com">
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-light small mb-1">
                                <i class="bi bi-key text-pink me-1"></i> Contraseña
                            </label>
                            <div class="input-group">
                            <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                                <i class="bi bi-lock"></i>
                            </span>
                                <input type="password" name="password" id="password"
                                       class="form-control bg-dark text-white border-secondary border-opacity-50 @error('password') is-invalid @enderror"
                                       placeholder="Mínimo 8 caracteres">
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <!-- Pie del Modal -->
                    <div class="modal-footer border-top border-secondary border-opacity-25 bg-dark px-4 py-3 gap-2">
                        <button type="button" class="btn btn-outline-secondary text-light border-secondary border-opacity-50 px-4 rounded-3" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-pink text-white px-4 fw-semibold rounded-3 shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-check-lg fs-6"></i> Guardar Usuario
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('js/dataTable.js') }}"></script>
@endpush
