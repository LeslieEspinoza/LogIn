@extends('layout.onboarding')

@section('title', 'Fase 3: Pago y Matrícula')

@php $paso_actual = 3; @endphp

@section('content')
    <div class="container" style="max-width: 850px;">

        <div class="card bg-dark border border-secondary border-opacity-50 rounded-4 shadow-lg overflow-hidden">
            <div class="card-body p-4 p-md-5">

                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom border-secondary border-opacity-25 pb-3">
                    <div>
                        <span class="badge bg-pink-subtle text-pink px-3 py-2 rounded-pill fw-bold mb-1">Fase 3 de 4</span>
                        <h4 class="fw-bold text-white mb-0">Pago de Matrícula Académica</h4>
                    </div>
                    <div class="text-secondary small text-end">
                        Nivel: <strong class="text-white text-capitalize">{{ $estudiante->nivel_academico }}</strong>
                    </div>
                </div>

                <!-- Resumen de Costos -->
                <div class="card bg-body-tertiary border-secondary border-opacity-25 rounded-3 p-4 mb-4">
                    <h6 class="text-pink fw-bold mb-3"><i class="bi bi-receipt me-2"></i>Resumen de Matrícula</h6>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary">Programa Seleccionado:</span>
                        <span class="fw-semibold text-white">{{ $estudiante->carrera->nombre ?? 'Sin Carrera' }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary">Costo Base de Matrícula:</span>
                        <span class="fw-semibold text-white">${{ number_format($estudiante->carrera->costo_matricula ?? 0, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary">Derechos de Registro / Carnet:</span>
                        <span class="fw-semibold text-white">$70.00</span>
                    </div>

                    <hr class="border-secondary border-opacity-25 my-2">

                    @php
                        $total = ($estudiante->carrera->costo_matricula ?? 0) + 70;
                    @endphp

                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <span class="fw-bold text-white fs-5">Total a Cancelar:</span>
                        <span class="fw-bold text-pink fs-4">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <!-- Formulario de Pago -->
                <form method="POST" action="{{ route('onboarding.paso3.guardar') }}" enctype="multipart/form-data" id="payment-form">
                    @csrf
                    <input type="hidden" name="monto" value="{{ $total }}">

                    <!-- Campos ocultos para datos de tarjeta (si el usuario paga con tarjeta) -->
                    <input type="hidden" name="card_holder" id="hidden_card_holder">
                    <input type="hidden" name="card_number" id="hidden_card_number">
                    <input type="hidden" name="card_expiry" id="hidden_card_expiry">
                    <input type="hidden" name="card_cvv" id="hidden_card_cvv">

                    <h6 class="text-pink fw-bold mb-3"><i class="bi bi-credit-card me-2"></i>Selecciona el Método de Pago</h6>

                    <div class="row g-3 mb-4">
                        <!-- Transferencia -->
                        <div class="col-12 col-md-6">
                            <label class="w-100 cursor-pointer selection-card-label">
                                <input type="radio" name="metodo_pago" value="transferencia" class="btn-check" id="metodo_transferencia" checked>
                                <div class="card bg-body-tertiary text-white border border-secondary border-opacity-50 rounded-3 p-3 text-center h-100 hover-card transition-all position-relative">
                                    <span class="badge bg-pink rounded-circle p-1 selected-badge">
                                        <i class="bi bi-check-lg fs-6 text-white"></i>
                                    </span>
                                    <i class="bi bi-bank fs-3 text-pink mb-2"></i>
                                    <div class="fw-bold small">Transferencia / Depósito</div>
                                </div>
                            </label>
                        </div>

                        <!-- Tarjeta -->
                        <div class="col-12 col-md-6">
                            <label class="w-100 cursor-pointer selection-card-label">
                                <input type="radio" name="metodo_pago" value="tarjeta" class="btn-check" id="metodo_tarjeta">
                                <div class="card bg-body-tertiary text-white border border-secondary border-opacity-50 rounded-3 p-3 text-center h-100 hover-card transition-all position-relative">
                                    <span class="badge bg-pink rounded-circle p-1 selected-badge">
                                        <i class="bi bi-check-lg fs-6 text-white"></i>
                                    </span>
                                    <i class="bi bi-credit-card-2-front fs-3 text-pink mb-2"></i>
                                    <div class="fw-bold small">Tarjeta de Crédito / Débito</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Contenedor: Datos Bancarios (Visible si se elige Transferencia) -->
                    <div id="bank-details-container" class="card bg-body-tertiary border border-secondary border-opacity-50 rounded-3 p-4 mb-4">
                        <h6 class="text-pink fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Datos Bancarios de la Universidad</h6>
                        <ul class="text-secondary small mb-3 ps-3">
                            <li><strong>Banco:</strong> Banco Agrícola / Cuscatlán</li>
                            <li><strong>Tipo de Cuenta:</strong> Corriente</li>
                            <li><strong>Número de Cuenta:</strong> 0034-5678-9012</li>
                            <li><strong>A nombre de:</strong> Universidad Modular Abierta S.A. de C.V.</li>
                            <li><strong>NIT / NRC:</strong> 0614-123456-101-2</li>
                        </ul>
                        <div>
                            <label class="form-label small text-secondary">Número de Referencia / Comprobante de Transacción</label>
                            <input type="text" name="referencia" id="referencia_input" class="form-control bg-dark text-white border-secondary border-opacity-50"
                                   placeholder="Ej. REF-987654321">
                        </div>
                    </div>

                    <!-- Botones de Navegación -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25">
                        <a href="{{ route('onboarding.paso', ['paso' => 2]) }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                            <i class="bi bi-arrow-left me-1"></i> Regresar a Carrera
                        </a>

                        <button type="submit" class="btn btn-pink text-white fw-semibold px-4 py-2 rounded-3 shadow-sm">
                            Registrar Pago y Finalizar <i class="bi bi-check-lg ms-1"></i>
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- Modal para Datos de Tarjeta -->
    <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border border-secondary border-opacity-50 shadow-lg rounded-4">
                <div class="modal-header border-bottom border-secondary border-opacity-25">
                    <h5 class="modal-title fw-bold text-pink" id="cardModalLabel">
                        <i class="bi bi-credit-card-2-front me-2"></i>Ingrese los datos de su tarjeta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="close-card-modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Nombre del Titular</label>
                        <input type="text" id="modal_card_holder" class="form-control bg-body-tertiary text-white border-secondary border-opacity-50" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Número de Tarjeta</label>
                        <input type="text" id="modal_card_number" class="form-control bg-body-tertiary text-white border-secondary border-opacity-50" placeholder="4532 •••• •••• 1234" maxlength="19">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label small text-secondary">Expiración (MM/AA)</label>
                            <input type="text" id="modal_card_expiry" class="form-control bg-body-tertiary text-white border-secondary border-opacity-50" placeholder="MM/AA" maxlength="5">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small text-secondary">CVV</label>
                            <input type="password" id="modal_card_cvv" class="form-control bg-body-tertiary text-white border-secondary border-opacity-50" placeholder="123" maxlength="4">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary border-opacity-25">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-3" data-bs-dismiss="modal" id="cancel-card-btn">Cancelar</button>
                    <button type="button" class="btn btn-pink text-white px-4 py-2 rounded-3 fw-semibold" id="save-card-btn">Confirmar Tarjeta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos CSS -->
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .selection-card-label:hover .card {
            border-color: rgba(232, 62, 140, 0.6) !important;
            box-shadow: 0 0 15px rgba(232, 62, 140, 0.25) !important;
            transform: translateY(-2px);
        }
        .selected-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.2s ease;
        }
        .btn-check:checked + .card {
            border-color: #d63384 !important;
            background-color: rgba(214, 51, 132, 0.08) !important;
            box-shadow: 0 0 25px rgba(214, 51, 132, 0.4), inset 0 0 10px rgba(214, 51, 132, 0.2) !important;
            transform: translateY(-1px);
        }
        .btn-check:checked + .card .selected-badge {
            opacity: 1;
            transform: scale(1);
        }
    </style>

    <!-- Script de Interactividad -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioTransferencia = document.getElementById('metodo_transferencia');
            const radioTarjeta = document.getElementById('metodo_tarjeta');
            const bankContainer = document.getElementById('bank-details-container');
            const referenciaInput = document.getElementById('referencia_input');

            const cardModalElement = document.getElementById('cardModal');
            const cardModal = new bootstrap.Modal(cardModalElement);

            function updatePaymentView() {
                if (radioTransferencia.checked) {
                    bankContainer.style.display = 'block';
                    referenciaInput.setAttribute('required', 'required');
                } else {
                    bankContainer.style.display = 'none';
                    referenciaInput.removeAttribute('required');
                }
            }

            // Estado inicial al cargar la página
            updatePaymentView();

            radioTransferencia.addEventListener('change', function() {
                if (this.checked) updatePaymentView();
            });

            radioTarjeta.addEventListener('change', function() {
                if (this.checked) {
                    updatePaymentView();
                    cardModal.show();
                }
            });

            // Permitir abrir modal al hacer clic directamente en la tarjeta de crédito
            radioTarjeta.closest('label').addEventListener('click', function() {
                if (!radioTarjeta.checked) {
                    cardModal.show();
                }
            });

            // Guardar datos del modal en inputs ocultos
            document.getElementById('save-card-btn').addEventListener('click', function() {
                const holder = document.getElementById('modal_card_holder').value;
                const number = document.getElementById('modal_card_number').value;
                const expiry = document.getElementById('modal_card_expiry').value;
                const cvv = document.getElementById('modal_card_cvv').value;

                if (!holder || !number || !expiry || !cvv) {
                    alert('Por favor complete todos los datos de su tarjeta.');
                    return;
                }

                document.getElementById('hidden_card_holder').value = holder;
                document.getElementById('hidden_card_number').value = number;
                document.getElementById('hidden_card_expiry').value = expiry;
                document.getElementById('hidden_card_cvv').value = cvv;

                cardModal.hide();
            });

            // Si cancela o cierra el modal sin registrar la tarjeta, regresa automáticamente a Transferencia
            function revertToTransferIfEmpty() {
                if (!document.getElementById('hidden_card_number').value) {
                    radioTransferencia.checked = true;
                    updatePaymentView();
                }
            }

            document.getElementById('cancel-card-btn').addEventListener('click', revertToTransferIfEmpty);
            document.getElementById('close-card-modal').addEventListener('click', revertToTransferIfEmpty);
        });
    </script>
@endsection
