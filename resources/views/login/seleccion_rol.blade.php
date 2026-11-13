<!DOCTYPE html>
<html lang="es" data-bs-theme="dark" data-lte-primary="pink">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seleccionar Rol</title>

    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/adminlte-colors.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <style>
        /* Estilos interactivos para las tarjetas de rol */
        .role-card {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            cursor: pointer;
            position: relative;
        }

        /* Efecto al pasar el cursor (Hover) */
        .role-card:hover {
            transform: translateY(-4px);
            border-color: rgba(232, 62, 140, 0.6) !important;
            box-shadow: 0 0 15px rgba(232, 62, 140, 0.25) !important;
        }

        /* Estado Seleccionado (Iluminación Rosa) */
        .role-card.selected {
            border-color: #d63384 !important;
            background-color: rgba(214, 51, 132, 0.08) !important;
            box-shadow: 0 0 25px rgba(214, 51, 132, 0.5), inset 0 0 10px rgba(214, 51, 132, 0.2) !important;
            transform: translateY(-2px);
        }

        /* Badge de check cuando está seleccionado */
        .role-card .selected-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.2s ease;
        }

        .role-card.selected .selected-badge {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>
<body class="register-page bg-dark min-vh-100 d-flex align-items-center justify-content-center py-5">

<div class="container" style="max-width: 680px;">

    <!-- Encabezado -->
    <div class="text-center mb-5">
        <div class="bg-pink-subtle text-pink rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
            <i class="bi bi-person-badge fs-2"></i>
        </div>
        <h3 class="fw-bold text-white mb-2">¿Cómo deseas registrarte?</h3>
        <p class="text-secondary mb-0">Selecciona tu perfil en el sistema para continuar con el registro</p>
    </div>

    <!-- Opciones de Rol -->
    <div class="row g-4 mb-4">

        <!-- Tarjeta Estudiante (rol_id: 3) -->
        <div class="col-12 col-md-6">
            <a href="{{ route('register', ['tipo' => 'estudiante']) }}" class="text-decoration-none role-link">
                <div class="card role-card bg-dark text-white border border-secondary border-opacity-50 rounded-4 p-4 text-center h-100 shadow-lg">
                    <!-- Icono de selección activa -->
                    <span class="badge bg-pink rounded-circle p-1 selected-badge">
                        <i class="bi bi-check-lg fs-6 text-white"></i>
                    </span>

                    <div class="bg-pink-subtle text-pink rounded-circle p-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="bi bi-mortarboard fs-2"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Estudiante</h5>
                    <p class="text-secondary small mb-0">Accede a inscripción de materias, consulta de notas y tu avance académico.</p>
                </div>
            </a>
        </div>

        <!-- Tarjeta Docente (rol_id: 2) -->
        <div class="col-12 col-md-6">
            <a href="{{ route('register', ['tipo' => 'docente']) }}" class="text-decoration-none role-link">
                <div class="card role-card bg-dark text-white border border-secondary border-opacity-50 rounded-4 p-4 text-center h-100 shadow-lg">
                    <!-- Icono de selección activa -->
                    <span class="badge bg-pink rounded-circle p-1 selected-badge">
                        <i class="bi bi-check-lg fs-6 text-white"></i>
                    </span>

                    <div class="bg-pink-subtle text-pink rounded-circle p-3 mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="bi bi-person-workspace fs-2"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Docente</h5>
                    <p class="text-secondary small mb-0">Gestiona tus asignaturas impartidas, ingreso de calificaciones y listas de alumnos.</p>
                </div>
            </a>
        </div>

    </div>

    <!-- Volver al Login -->
    <div class="text-center">
        <a href="{{ route('login') }}" class="text-secondary text-decoration-none small">
            <i class="bi bi-arrow-left me-1"></i> Volver a Iniciar Sesión
        </a>
    </div>

</div>

<!-- AdminLTE & Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const links = document.querySelectorAll('.role-link');

        links.forEach(link => {
            link.addEventListener('click', function(e) {
                // Remover estado seleccionado de todas las tarjetas
                document.querySelectorAll('.role-card').forEach(card => card.classList.remove('selected'));

                // Agregar clase seleccionada a la tarjeta cliqueada
                const card = this.querySelector('.role-card');
                if (card) {
                    card.classList.add('selected');
                }
            });
        });
    });
</script>
</body>
</html>
