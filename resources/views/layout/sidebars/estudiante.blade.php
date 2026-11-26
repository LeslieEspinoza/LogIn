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
