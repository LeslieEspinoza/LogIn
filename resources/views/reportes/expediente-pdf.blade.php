<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente Académico - {{ $estudiante->user->name ?? 'Estudiante' }}</title>
    <style>
        @page {
            margin: 25px;
        }
        body {
            background-color: #181f2c;
            color: #ffffff;
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 15px;
            font-size: 12px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #ec4899;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .badge-rosa {
            background-color: #ec4899;
            color: #ffffff;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
        .title {
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            margin-top: 6px;
        }
        .card {
            background-color: #111827;
            border: 1px solid #374151;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 18px;
        }
        .card-title {
            color: #ec4899;
            font-size: 11px;
            font-weight: bold;
            border-bottom: 1px solid #374151;
            padding-bottom: 6px;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px 0;
            color: #d1d5db;
        }
        .info-table td.label {
            color: #9ca3af;
            font-weight: bold;
            width: 30%;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        .data-table th {
            background-color: #ec4899;
            color: #ffffff;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }
        .data-table td {
            padding: 8px;
            border-bottom: 1px solid #1f2937;
            color: #e5e7eb;
            font-size: 11px;
        }
        .status-badge {
            color: #10b981;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            border-top: 1px solid #374151;
            padding-top: 8px;
        }
    </style>
</head>
<body>

<!-- ENCABEZADO INSTITUCIONAL -->
<table class="header-table">
    <tr>
        <td>
            <span class="badge-rosa">Documento Oficial</span>
            <div class="title">Expediente Académico del Estudiante</div>
        </td>
        <td style="text-align: right; color: #9ca3af; font-size: 10px;">
            Fecha de Emisión:<br>
            <strong style="color: #ffffff;">{{ date('d/m/Y') }}</strong>
        </td>
    </tr>
</table>

<!-- TARJETA: INFORMACIÓN GENERAL -->
<div class="card">
    <div class="card-title">Información General</div>
    <table class="info-table">
        <tr>
            <td class="label">Estudiante:</td>
            <td>{{ $estudiante->user->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Correo Electrónico:</td>
            <td>{{ $estudiante->user->email ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Carrera:</td>
            <td style="color: #f472b6; font-weight: bold;">{{ $estudiante->carrera->nombre ?? 'Sin Asignar' }}</td>
        </tr>
        <tr>
            <td class="label">Nivel Académico:</td>
            <td>{{ ucfirst($estudiante->nivel_academico ?? 'N/A') }}</td>
        </tr>
    </table>
</div>

<!-- TARJETA: MATERIAS INSCRITAS -->
<div class="card">
    <div class="card-title">Materias e Inscripciones</div>
    <table class="data-table">
        <thead>
        <tr>
            <th>Materia</th>
            <th style="text-align: center;">Aula</th>
            <th style="text-align: center;">Hora</th>
            <th style="text-align: center;">Estado</th>
        </tr>
        </thead>
        <tbody>
        @forelse($estudiante->secciones as $seccion)
            <tr>
                <td>{{ $seccion->materia->nombre ?? 'Sin Asignar' }}</td>
                <td style="text-align: center;">{{ $seccion->aula ?? 'N/A' }}</td>
                <td style="text-align: center;" class="status-badge">Inscrito</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #9ca3af; padding: 15px;">
                    No hay materias ni secciones inscritas para este estudiante.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="footer">
    Este documento es un expediente institucional generado automáticamente por el Portal Estudiantil. Válido sin firma física.
</div>

</body>
</html>
