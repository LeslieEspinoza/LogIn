@extends('layout.layout')

@section('contenido')
    <div class="container-fluid mt-4">

        <!-- Encabezado -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-light mb-0">Gestión de Materias</h2>
        </div>

        <!-- Mensajes de éxito -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>¡Listo!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tarjeta de Filtros -->
        <div class="card bg-dark text-light border-secondary mb-4 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.materias.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="carrera_id" class="form-label text-secondary">Filtrar por Carrera:</label>
                        <select name="carrera_id" id="carrera_id" class="form-select bg-dark text-light border-secondary">
                            <option value="">-- Mostrar Todas --</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id }}" {{ request('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                    {{ $carrera->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-7">
                        <button type="submit" class="btn btn-primary me-2">
                            Filtrar
                        </button>
                        @if(request()->filled('carrera_id'))
                            <a href="{{ route('admin.materias.index') }}" class="btn btn-outline-light">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Tarjeta de la Tabla -->
        <div class="card bg-dark text-light border-secondary shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover mb-0 align-middle">
                        <thead>
                        <tr>
                            <th scope="col" class="px-4 py-3">Código</th>
                            <th scope="col" class="px-4 py-3">Nombre</th>
                            <th scope="col" class="px-4 py-3 text-center">UV</th>
                            <th scope="col" class="px-4 py-3">Carrera</th>
                            <th scope="col" class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($materias as $materia)
                            <tr>
                                <td class="px-4 py-3 text-secondary fw-bold">{{ $materia->codigo }}</td>
                                <td class="px-4 py-3">{{ $materia->nombre }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="badge bg-secondary">{{ $materia->uv }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $materia->carrera->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Botón Editar -->
                                        <a href="{{ route('admin.materias.edit', $materia) }}" class="btn btn-sm btn-outline-info">
                                            Editar
                                        </a>

                                        <!-- Formulario Eliminar -->
                                        <form action="{{ route('admin.materias.destroy', $materia) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta materia?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary">
                                    No se encontraron materias para esta selección.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            @if($materias->hasPages())
                <div class="card-footer border-secondary pt-3">
                    {{ $materias->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
