<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Kárdex Académico</title>
    <style>
        /* Fondo blanco general para imprimir, texto oscuro para lectura */
        body { font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #333333; background-color: #ffffff; margin: 20px; }

        /* Detalles institucionales en rosa (#be185d) */
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #be185d; padding-bottom: 15px; }
        .header h1 { margin: 0; color: #be185d; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; color: #666; }

        .info-table { width: 100%; margin-bottom: 30px; }
        .info-table td { padding: 5px; }
        .info-table strong { color: #be185d; }

        .grades-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .grades-table th, .grades-table td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        /* Cabecera sin fondo de color (ahorra tinta) pero con texto y borde rosa */
        .grades-table th { background-color: #ffffff; color: #be185d; border-bottom: 2px solid #be185d; text-transform: uppercase; font-size: 12px; }
        .grades-table td.materia { text-align: left; }

        .badge-aprobada { color: green; font-weight: bold; }

        .footer { position: fixed; bottom: -10px; width: 100%; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #be185d; padding-top: 10px; }
    </style>
</head>
<body>

<div class="header">
    <h1>Universidad Modular Abierta</h1>
    <p>Kárdex Oficial de Calificaciones</p>
</div>

<table class="info-table">
    <tr>
        <td><strong>Estudiante:</strong> {{ $estudiante->user->name ?? 'N/A' }}</td>
        <td><strong>Carnet:</strong> {{ $estudiante->documento_identidad ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td><strong>Carrera:</strong> {{ $estudiante->carrera->nombre ?? 'N/A' }}</td>
        <td><strong>Fecha de Emisión:</strong> {{ $fecha }}</td>
    </tr>
</table>

<table class="grades-table">
    <thead>
    <tr>
        <th>Código</th>
        <th>Materia</th>
        <th>Ciclo</th>
        <th>Nota Final</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    <!-- Aquí luego harás un foreach con las materias aprobadas reales -->
    <tr>
        <td>INF-101</td>
        <td class="materia">Introducción a la Informática</td>
        <td>2025-I</td>
        <td>8.5</td>
        <td class="badge-aprobada">Aprobada</td>
    </tr>
    <tr>
        <td>MAT-102</td>
        <td class="materia">Matemática I</td>
        <td>2025-I</td>
        <td>7.0</td>
        <td class="badge-aprobada">Aprobada</td>
    </tr>
    <tr>
        <td>ADM-103</td>
        <td class="materia">Administración General</td>
        <td>2025-II</td>
        <td>9.2</td>
        <td class="badge-aprobada">Aprobada</td>
    </tr>
    </tbody>
</table>

<div class="footer">
    Este documento es una representación digital generada por el Sistema Académico.<br>
    Las alteraciones a este documento lo invalidan.
</div>

</body>
</html>
