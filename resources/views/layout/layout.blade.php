<!DOCTYPE html>
<html lang="es" data-lte-primary="pink">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Token CSRF para peticiones AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo', 'LogIn')</title>

    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/adminlte-colors.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    @stack('estilos')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Navbar -->
    <nav class="app-header navbar navbar-expand bg-body border-bottom shadow-sm">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-body" data-lte-toggle="sidebar" href="javascript:void(0);" role="button">
                        <i class="bi bi-list fs-4"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Periodo Activo -->
                <li class="nav-item me-3">
                    <span class="badge bg-pink-subtle text-pink-emphasis px-3 py-2 rounded-pill">
                        <i class="bi bi-calendar-check me-1"></i> Ciclo Activo 2026-II
                    </span>
                </li>

                <!-- Nombre de Usuario con Dropdown -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-body" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4 text-pink"></i>
                        <span class="d-none d-md-inline fw-semibold">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end bg-dark border-secondary shadow">
                        @if(auth()->user()->rol_id == 3)
                            <li>
                                <a class="dropdown-item text-white" href="{{ route('estudiante.perfil') }}">
                                    <i class="bi bi-person-gear me-2 text-pink"></i> Mi Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider border-secondary"></li>
                        @endif
                        <li>
                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </nav>

    <!-- Sidebar-->
    <aside class="app-sidebar shadow bg-body-secondary">
        <div class="sidebar-brand text-center py-3 border-bottom border-body-subtle">
            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark fw-bold fs-5">
                <i class="bi bi-mortarboard-fill text-pink me-2"></i> Sistema Académico
            </a>
        </div>

        <div class="sidebar-wrapper overflow-x-hidden">
            <nav class="mt-3">
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                    <!-- DASHBOARD (SOLO ADMIN Y DOCENTES) -->
                    @if(auth()->check() && in_array(auth()->user()->rol_id, [1, 2]))
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer2 text-pink"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    @endif

                    <!-- SECCIÓN ADMINISTRACIÓN (SOLO ADMINISTRADOR: rol_id = 1) -->
                    @if(auth()->check() && auth()->user()->rol_id === 1)
                        <li class="nav-header mt-3 fw-bold text-uppercase text-secondary small ps-3">Administración</li>
                        <li class="nav-item">
                            <a href="{{ route('usuarios') }}" class="nav-link {{ request()->routeIs('usuarios*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people text-pink"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                    @endif

                    <!-- SECCIÓN ACADÉMICO (ADMIN Y DOCENTES: rol_id = 1, 2) -->
                    @if(auth()->check() && in_array(auth()->user()->rol_id, [1, 2]))
                        <li class="nav-header mt-3 fw-bold text-uppercase text-secondary small ps-3">Académico</li>

                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link opacity-75">
                                <i class="nav-icon bi bi-person-video3 text-pink"></i>
                                <p>Estudiantes</p>
                            </a>
                        </li>

                        @if(auth()->user()->rol_id === 1)
                            <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link opacity-75">
                                    <i class="nav-icon bi bi-person-workspace text-pink"></i>
                                    <p>Profesores</p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link opacity-75">
                                <i class="nav-icon bi bi-journal-bookmark text-pink"></i>
                                <p>Materias</p>
                            </a>
                        </li>
                    @endif

                    <!-- SECCIÓN GESTIÓN INSTITUCIONAL -->
                    <li class="nav-header mt-3 fw-bold text-uppercase text-secondary small ps-3">Gestión Institucional</li>

                    @if(auth()->check() && auth()->user()->rol_id === 1)
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link opacity-75">
                                <i class="nav-icon bi bi-award text-pink"></i>
                                <p>Carreras</p>
                            </a>
                        </li>
                    @endif

                    <!--  INSCRIPCIONES GENERAL -->
                    @if(auth()->check() && in_array(auth()->user()->rol_id, [1, 2]))
                        <li class="nav-item">
                            <a href="{{ route('inscripcion') }}" class="nav-link {{ request()->routeIs('inscripcion*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-card-checklist text-pink"></i>
                                <p>Inscripciones</p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->check() && in_array(auth()->user()->rol_id, [1, 2]))
                        <li class="nav-item">
                            <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-earmark-bar-graph text-pink"></i>
                                <p>Reportes</p>
                            </a>
                        </li>
                    @endif

                    <!-- MENÚ EXCLUSIVO PARA ESTUDIANTES -->
                    @if(auth()->check() && auth()->user()->rol_id == 3)
                        <li class="nav-item">
                            <a href="{{ route('estudiante.dashboard') }}" class="nav-link {{ request()->routeIs('estudiante.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-house-door text-pink"></i>
                                <p>Mi Panel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('estudiante.inscripciones') }}" class="nav-link {{ request()->routeIs('estudiante.inscripciones') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-journal-check text-pink"></i>
                                <p>Mis Inscripciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('estudiante.horario') }}" class="nav-link {{ request()->routeIs('estudiante.horario') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-calendar3 text-pink"></i>
                                <p>Mi Horario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('estudiante.calificaciones') }}" class="nav-link {{ request()->routeIs('estudiante.calificaciones') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-award text-pink"></i>
                                <p>Calificaciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('estudiante.tramites') }}" class="nav-link {{ request()->routeIs('estudiante.tramites') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-earmark-text text-pink"></i>
                                <p>Trámites</p>
                            </a>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="app-main px-4 pb-5 pt-4">
        @yield('contenido')
    </main>

    <!-- Footer -->
    <footer class="app-footer border-top py-3 px-4">
        <strong>Copyright &copy; 2026.</strong> Todos los derechos reservados.
        <div class="float-end d-none d-sm-inline-block">
            <b>Versión</b> 1.0 | <a href="{{ url('home/acerca') }}" class="text-decoration-none text-pink">Acerca de</a>
        </div>
    </footer>

    <!-- Modal de Confirmación de Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary shadow-lg">

                <div class="modal-header border-secondary pb-3">
                    <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2" id="logoutModalLabel">
                        <i class="bi bi-box-arrow-right text-pink fs-5"></i> Confirmar Salida
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4 text-center">
                    <p class="mb-0 text-light fs-6">
                        ¿Estás seguro de que deseas cerrar tu sesión en el sistema?
                    </p>
                    <small class="text-secondary d-block mt-1">Tendrás que volver a ingresar tus credenciales para acceder.</small>
                </div>

                <div class="modal-footer border-secondary pt-3 justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-light px-4" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4 fw-semibold d-flex align-items-center gap-1">
                            <i class="bi bi-box-arrow-right"></i> Sí, Cerrar Sesión
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

@include('layout.toast')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{ asset('js/toast.js') }}"></script>
@stack('scripts')

</body>
</html>
