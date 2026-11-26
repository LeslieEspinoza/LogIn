<!DOCTYPE html>
<html lang="es" data-bs-theme="dark" data-lte-primary="pink">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>

    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/adminlte-colors.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>
<body class="login-page bg-dark min-vh-100 d-flex align-items-center justify-content-center py-5">

<div class="login-box" style="width: 100%; max-width: 420px;">

    <!-- Logo del Sistema -->
    <div class="login-logo text-center mb-4">
        <a href="{{ url('/') }}" class="text-decoration-none text-white fw-bold fs-2 d-flex align-items-center justify-content-center gap-2">
            <div class="bg-pink-subtle text-pink rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                <i class="bi bi-mortarboard-fill fs-3"></i>
            </div>
            <span>LogIn</span>
        </a>
    </div>

    <!-- Tarjeta de Login -->
    <div class="card border border-secondary border-opacity-50 bg-dark text-white shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-4 p-sm-5">

            <div class="text-center mb-4">
                <h4 class="fw-bold text-white mb-1">¡Bienvenido!</h4>
                <p class="text-secondary small mb-0">Ingresa tus credenciales para acceder al sistema</p>
            </div>

            @if(session('status'))
                <div class="alert alert-success bg-success bg-opacity-20 text-success border-0 small mb-4 rounded-3">
                    <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

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
                               class="form-control bg-dark text-white border-secondary border-opacity-50"
                               placeholder="correo@ejemplo.com" required autofocus>
                    </div>
                </div>

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
                               class="form-control bg-dark text-white border-secondary border-opacity-50"
                               placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Opciones (Recordarme / Olvidé clave) -->
                <div class="row align-items-center mb-4">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-secondary small" for="remember">
                                Recordarme
                            </label>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-pink small text-decoration-none fw-semibold">
                                ¿Olvidaste clave?
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Botón Iniciar Sesión -->
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-pink text-white fw-semibold py-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-in-right fs-5"></i> Iniciar Sesión
                    </button>
                </div>
            </form>

            <!-- Opción para Crear Cuenta / Registrarse -->
            <div class="text-center pt-3 border-top border-secondary border-opacity-25">
                <p class="small text-secondary mb-0">
                    ¿No tienes una cuenta aún?
                    @if (Route::has('register'))
                        <a href="{{ route('register.select') }}" class="text-pink fw-bold text-decoration-none ms-1">
                            Regístrate aquí
                        </a>
                    @else
                        <a href="#" class="text-pink fw-bold text-decoration-none ms-1">
                            Regístrate aquí
                        </a>
                    @endif
                </p>
            </div>

        </div>
    </div>

</div>

<!-- AdminLTE & Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>

<!-- SweetAlert2 JS para los Toasts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Configuración global para que los Toasts se vean oscuros y acordes al diseño
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 7000,
        timerProgressBar: true,
        background: '#343a40', // Color oscuro (bg-dark)
        color: '#ffffff', // Texto blanco
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Disparar Toast de Error (Cuenta suspendida o credenciales incorrectas)
    @if(session('error'))
    Toast.fire({
        icon: 'error',
        title: "{{ session('error') }}"
    });
    @endif

    // Disparar Toast de Éxito (Cierre de sesión, etc.)
    @if(session('success'))
    Toast.fire({
        icon: 'success',
        title: "{{ session('success') }}"
    });
    @endif
</script>

</body>
</html>
