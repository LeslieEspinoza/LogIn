<!DOCTYPE html>
<html lang="es" data-bs-theme="dark" data-lte-primary="pink">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Proceso de Admisión')</title>

    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <style>
        .step-progress {
            display: flex;
            justify-content: space-between;
            position: relative;
        }
        .step-item {
            text-align: center;
            flex: 1;
            position: relative;
            z-index: 1;
        }
        .step-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #2b3035;
            border: 2px solid #495057;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-weight: bold;
            color: #adb5bd;
            transition: all 0.3s ease;
        }
        .step-item.active .step-icon {
            border-color: #d63384;
            background-color: #d63384;
            color: #fff;
            box-shadow: 0 0 15px rgba(214, 51, 132, 0.4);
        }
        .step-item.completed .step-icon {
            border-color: #198754;
            background-color: #198754;
            color: #fff;
        }
        .step-title {
            font-size: 0.85rem;
            color: #8a939b;
        }
        .step-item.active .step-title {
            color: #fff;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-dark text-white min-vh-100 d-flex flex-column">

<!-- Encabezado Superior -->
<nav class="navbar navbar-dark bg-body-tertiary border-bottom border-secondary border-opacity-25 py-3">
    <div class="container">
        <span class="navbar-brand fw-bold text-white d-flex align-items-center gap-2">
            <div class="bg-pink-subtle text-pink rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i class="bi bi-mortarboard-fill fs-5"></i>
            </div>
            Portal de Admisión Académica
        </span>

        <div class="d-flex align-items-center gap-3">
            <span class="text-secondary small d-none d-md-inline">
                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="bi bi-box-arrow-right me-1"></i> Salir
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Contenido Principal -->
<main class="container my-auto py-4">

    @if(isset($paso_actual))
        <!-- Línea de Tiempo de Fases -->
        <div class="card bg-body-tertiary border border-secondary border-opacity-25 rounded-4 p-4 mb-4 shadow-sm">
            <div class="step-progress">

                <div class="step-item {{ $paso_actual == 1 ? 'active' : ($paso_actual > 1 ? 'completed' : '') }}">
                    <div class="step-icon">
                        <i class="bi {{ $paso_actual > 1 ? 'bi-check-lg' : 'bi-file-earmark-person' }}"></i>
                    </div>
                    <div class="step-title">1. Documentos</div>
                </div>

                <div class="step-item {{ $paso_actual == 2 ? 'active' : ($paso_actual > 2 ? 'completed' : '') }}">
                    <div class="step-icon">
                        <i class="bi {{ $paso_actual > 2 ? 'bi-check-lg' : 'bi-journal-bookmark' }}"></i>
                    </div>
                    <div class="step-title">2. Carrera y Horario</div>
                </div>

                <div class="step-item {{ $paso_actual == 3 ? 'active' : ($paso_actual > 3 ? 'completed' : '') }}">
                    <div class="step-icon">
                        <i class="bi {{ $paso_actual > 3 ? 'bi-check-lg' : 'bi-credit-card' }}"></i>
                    </div>
                    <div class="step-title">3. Pago y Matrícula</div>
                </div>

                <div class="step-item {{ $paso_actual == 4 ? 'completed' : '' }}">
                    <div class="step-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <div class="step-title">4. Confirmación</div>
                </div>

            </div>
        </div>
    @endif

    @yield('content')

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
