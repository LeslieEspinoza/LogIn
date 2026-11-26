<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon bi bi-speedometer2 text-pink"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-header mt-3 fw-bold text-uppercase text-secondary small ps-3">Académico</li>
<li class="nav-item">
    <a href="{{ route('admin.estudiantes.index') }}" class="nav-link {{ request()->routeIs('admin.estudiantes.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-person-video3 text-pink"></i>
        <p>Estudiantes</p>
    </a>
</li>
<li class="nav-item">
    <a href="javascript:void(0);" class="nav-link opacity-75">
        <i class="nav-icon bi bi-journal-bookmark text-pink"></i>
        <p>Materias</p>
    </a>
</li>

<li class="nav-header mt-3 fw-bold text-uppercase text-secondary small ps-3">Operaciones</li>
<li class="nav-item">
    <a href="{{ route('inscripcion') }}" class="nav-link {{ request()->routeIs('inscripcion*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-card-checklist text-pink"></i>
        <p>Inscripciones</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-file-earmark-bar-graph text-pink"></i>
        <p>Reportes</p>
    </a>
</li>
