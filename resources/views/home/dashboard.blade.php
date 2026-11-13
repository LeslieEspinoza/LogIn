@extends('layout.layout')

@section('titulo', 'Dashboard')

@section('contenido')
    <div class="container-fluid py-3">

        <!-- Encabezado de sección -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-white mb-1">Panel General</h3>
                <p class="text-secondary mb-0">Resumen e indicadores del sistema de inscripción</p>
            </div>
        </div>

        <!-- TARJETAS DE INDICADORES (KPIs) -->
        <div class="row g-3 mb-4">
            <!-- Carreras -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border border-secondary border-opacity-25 shadow-sm bg-dark text-white rounded-4 overflow-hidden">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold mb-2 text-secondary small">Carreras</h6>
                            <h2 class="display-6 fw-bold mb-0 text-white">{{ $totalCarreras }}</h2>
                        </div>
                        <div class="bg-pink bg-opacity-10 text-pink rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; color: #ec4899;">
                            <i class="bi bi-award fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estudiantes -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border border-secondary border-opacity-25 shadow-sm bg-dark text-white rounded-4 overflow-hidden">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold mb-2 text-secondary small">Estudiantes</h6>
                            <h2 class="display-6 fw-bold mb-0 text-white">{{ $totalEstudiantes }}</h2>
                        </div>
                        <div class="bg-pink bg-opacity-10 text-pink rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; color: #ec4899;">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Docentes -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border border-secondary border-opacity-25 shadow-sm bg-dark text-white rounded-4 overflow-hidden">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold mb-2 text-secondary small">Docentes</h6>
                            <h2 class="display-6 fw-bold mb-0 text-white">{{ $totalDocentes }}</h2>
                        </div>
                        <div class="bg-pink bg-opacity-10 text-pink rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; color: #ec4899;">
                            <i class="bi bi-person-workspace fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inscripciones -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border border-secondary border-opacity-25 shadow-sm bg-dark text-white rounded-4 overflow-hidden">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold mb-2 text-secondary small">Inscripciones</h6>
                            <h2 class="display-6 fw-bold mb-0 text-white">{{ $totalInscripciones }}</h2>
                        </div>
                        <div class="rounded-circle p-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 56px; height: 56px; background: #ec4899; color: #fff;">
                            <i class="bi bi-card-checklist fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DE GRÁFICAS -->
        <div class="row g-4">
            <!-- Gráfico de Líneas (Tendencia de Inscripciones) -->
            <div class="col-12 col-lg-8">
                <div class="card border border-secondary border-opacity-25 shadow-sm bg-dark text-white rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-0 text-white">Inscripciones Mensuales</h5>
                            <small class="text-secondary">Comportamiento en el año actual</small>
                        </div>
                        <span class="badge rounded-pill px-3 py-2" style="background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.3);">
                        Año {{ date('Y') }}
                    </span>
                    </div>
                    <div style="position: relative; height: 320px;">
                        <canvas id="lineChartInscripciones"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Pastel (Distribución por Carrera) -->
            <div class="col-12 col-lg-4">
                <div class="card border border-secondary border-opacity-25 shadow-sm bg-dark text-white rounded-4 p-4 h-100">
                    <div class="mb-3">
                        <h5 class="fw-bold mb-0 text-white">Estudiantes por Carrera</h5>
                        <small class="text-secondary">Distribución porcentual activa</small>
                    </div>
                    <div style="position: relative; height: 320px;" class="d-flex align-items-center justify-content-center">
                        <canvas id="pieChartCarreras"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Configuración Global Dark Mode
            Chart.defaults.color = '#9ca3af';
            Chart.defaults.font.family = 'system-ui, -apple-system, "Segoe UI", Roboto, sans-serif';

            // 1. GRÁFICO DE LÍNEAS
            const ctxLine = document.getElementById('lineChartInscripciones').getContext('2d');

            // Gradiente rosa para el área bajo la curva
            const gradientPink = ctxLine.createLinearGradient(0, 0, 0, 300);
            gradientPink.addColorStop(0, 'rgba(236, 72, 153, 0.4)');
            gradientPink.addColorStop(1, 'rgba(236, 72, 153, 0.0)');

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: @json($mesesNombres),
                    datasets: [{
                        label: 'Inscripciones',
                        data: @json($datosInscripciones),
                        borderColor: '#ec4899',
                        borderWidth: 3,
                        backgroundColor: gradientPink,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ec4899',
                        pointBorderColor: '#181f2c',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#9ca3af' }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#9ca3af', precision: 0 }
                        }
                    }
                }
            });

            // 2. GRÁFICO DE PASTEL (DOUGHNUT)
            const ctxPie = document.getElementById('pieChartCarreras').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: @json($labelsCarreras),
                    datasets: [{
                        data: @json($totalesPorCarrera),
                        backgroundColor: [
                            '#ec4899',
                            '#3b82f6',
                            '#10b981',
                            '#f59e0b',
                            '#8b5cf6',
                            '#06b6d4'
                        ],
                        borderColor: '#181f2c',
                        borderWidth: 3,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#e5e7eb',
                                padding: 15,
                                font: { size: 12 }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        });
    </script>
@endsection
