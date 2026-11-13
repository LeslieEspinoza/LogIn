<!DOCTYPE html>
<html lang="es" data-bs-theme="dark" data-lte-primary="pink">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de {{ ucfirst($tipo) }}</title>

    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/adminlte-colors.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>
<body class="register-page bg-dark min-vh-100 d-flex align-items-center justify-content-center py-5">

<div class="register-box" style="width: 100%; max-width: 460px;">

    <!-- Logo del Sistema -->
    <div class="register-logo text-center mb-4">
        <a href="{{ url('/') }}" class="text-decoration-none text-white fw-bold fs-2 d-flex align-items-center justify-content-center gap-2">
            <div class="bg-pink-subtle text-pink rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="bi bi-mortarboard-fill fs-3"></i>
            </div>
            <span>Registro</span>
        </a>
    </div>

    <!-- Tarjeta de Registro -->
    <div class="card border border-secondary border-opacity-50 bg-dark text-white shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-4 p-sm-5">

            <div class="text-center mb-4">
                <span class="badge bg-pink-subtle text-pink px-3 py-2 rounded-pill fw-bold mb-2">
                    <i class="bi {{ $tipo === 'docente' ? 'bi-person-workspace' : 'bi-mortarboard' }} me-1"></i>
                    Perfil: {{ ucfirst($tipo) }}
                </span>
                <h4 class="fw-bold text-white mb-1">Crear nueva cuenta</h4>
                <p class="text-secondary small mb-0">Ingresa tus datos para completar tu registro</p>
            </div>

            <form method="POST" action="{{ route('register.store') }}" novalidate>
                @csrf

                <!-- Campo Oculto para Guardar el ID de Rol (2 = Docente, 3 = Estudiante) -->
                <input type="hidden" name="rol_id" value="{{ $rol_id }}">

                <!-- Nombre Completo -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold text-light small mb-1">
                        <i class="bi bi-person text-pink me-1"></i> Nombre Completo
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                            <i class="bi bi-person-badge"></i>
                        </span>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="form-control bg-dark text-white border-secondary border-opacity-50 @error('name') is-invalid @enderror"
                               placeholder="Ej. Juan Pérez" required autofocus>
                    </div>
                    @error('name')
                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Correo Electrónico -->
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
                               placeholder="correo@ejemplo.com" required>
                    </div>
                    @error('email')
                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                @if($tipo === 'estudiante')
                    <!-- Selección de Nivel Académico (Solo para Estudiantes) -->
                    <div class="mb-3">
                        <label for="nivel_academico" class="form-label fw-semibold text-light small mb-1">
                            <i class="bi bi-award text-pink me-1"></i> Nivel Académico / Perfil
                        </label>
                        <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </span>
                            <select name="nivel_academico" id="nivel_academico"
                                    class="form-select bg-dark text-white border-secondary border-opacity-50 @error('nivel_academico') is-invalid @enderror" required>
                                <option value="" disabled {{ old('nivel_academico') ? '' : 'selected' }}>Selecciona tu nivel...</option>
                                <option value="pregrado" {{ old('nivel_academico') == 'pregrado' ? 'selected' : '' }}>Pregrado (Licenciaturas e Ingenierías)</option>
                                <option value="posgrado" {{ old('nivel_academico') == 'posgrado' ? 'selected' : '' }}>Posgrado (Maestrías y Doctorados)</option>
                                <option value="educacion_continua" {{ old('nivel_academico') == 'educacion_continua' ? 'selected' : '' }}>Educación Continua (Diplomados y Cursos)</option>
                            </select>
                        </div>
                        @error('nivel_academico')
                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <!-- Contraseña -->
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
                               placeholder="••••••••" required>
                    </div>
                    @error('password')
                    <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold text-light small mb-1">
                        <i class="bi bi-shield-check text-pink me-1"></i> Confirmar Contraseña
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-secondary border-opacity-50 text-secondary">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control bg-dark text-white border-secondary border-opacity-50"
                               placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Botón Registrarse -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-pink text-white fw-semibold py-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-person-plus-fill fs-5"></i> Registrar como {{ ucfirst($tipo) }}
                    </button>
                </div>
            </form>

            <div class="text-center pt-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                <a href="{{ route('register.select') }}" class="text-secondary small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Cambiar rol
                </a>
                <a href="{{ route('login') }}" class="text-pink fw-bold small text-decoration-none">
                    Inicia sesión aquí
                </a>
            </div>

        </div>
    </div>

</div>

<!-- AdminLTE & Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
