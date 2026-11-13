<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <thead>
    <!-- BANNER DE ENCABEZADO INSTITUCIONAL -->
    <tr>
        <th colspan="4" style="background-color: #181f2c; color: #ec4899; font-weight: bold; font-size: 16pt; text-align: center; height: 40px; vertical-align: middle;">
            EXPEDIENTE ACADÉMICO INSTITUCIONAL
        </th>
    </tr>
    <tr><th colspan="4"></th></tr>

    <!-- INFORMACIÓN GENERAL DEL ESTUDIANTE -->
    <tr>
        <th style="font-weight: bold; background-color: #1e293b; color: #ffffff; text-align: left;">Estudiante:</th>
        <td colspan="3" style="background-color: #f9fafb; color: #111827;">{{ $estudiante->user->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th style="font-weight: bold; background-color: #1e293b; color: #ffffff; text-align: left;">Correo Electrónico:</th>
        <td colspan="3" style="background-color: #f9fafb; color: #111827;">{{ $estudiante->user->email ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th style="font-weight: bold; background-color: #1e293b; color: #ffffff; text-align: left;">Carrera:</th>
        <td colspan="3" style="background-color: #f9fafb; color: #111827;">{{ $estudiante->carrera->nombre ?? 'Sin Asignar' }}</td>
    </tr>
    <tr>
        <th style="font-weight: bold; background-color: #1e293b; color: #ffffff; text-align: left;">Nivel Académico:</th>
        <td colspan="3" style="background-color: #f9fafb; color: #111827;">{{ ucfirst($estudiante->nivel_academico ?? 'N/A') }}</td>
    </tr>
    <tr><th colspan="4"></th></tr>

    <!-- CABECERA DE LA TABLA DE MATERIAS -->
    <tr style="background-color: #ec4899; color: #ffffff;">
        <th style="font-weight: bold; background-color: #ec4899; color: #ffffff; text-align: left; height: 25px; vertical-align: middle;">Materia</th>
        <th style="font-weight: bold; background-color: #ec4899; color: #ffffff; text-align: center; height: 25px; vertical-align: middle;">Aula</th>
        <th style="font-weight: bold; background-color: #ec4899; color: #ffffff; text-align: center; height: 25px; vertical-align: middle;">Hora</th>
        <th style="font-weight: bold; background-color: #ec4899; color: #ffffff; text-align: center; height: 25px; vertical-align: middle;">Estado</th>
    </tr>
    </thead>
    <tbody>
    @forelse($estudiante->secciones as $seccion)
        <tr>
            <td style="text-align: left; border: 1px solid #e5e7eb;">{{ $seccion->materia->nombre ?? 'Sin Asignar' }}</td>
            <td style="text-align: center; border: 1px solid #e5e7eb;">{{ $seccion->aula ?? 'N/A' }}</td>
            <td style="text-align: center; border: 1px solid #e5e7eb; color: #10b981; font-weight: bold;">Inscrito</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align: center; color: #6b7280; font-style: italic; border: 1px solid #e5e7eb;">
                No hay materias ni secciones inscritas para este estudiante.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
