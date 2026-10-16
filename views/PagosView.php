<?php 
require_once 'views/includes/SideBarView.php'; 
require_once 'views/includes/NavBarView.php';
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pagos - Tracto Pensión</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="public/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="public/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="public/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="public/assets/css/demo_1/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="public/assets/images/favicon.png" />
    <style>
      .badge-pending { background-color: #FFC107; color: #000; }
      .badge-completed { background-color: #28A745; color: #fff; }
      .badge-overdue { background-color: #DC3545; color: #fff; }
      .payment-card { transition: all 0.3s ease; }
      .payment-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
      .stat-card-primary { border-left: 4px solid #007BFF; }
      .stat-card-success { border-left: 4px solid #28A745; }
      .stat-card-danger { border-left: 4px solid #DC3545; }
      .stat-card-warning { border-left: 4px solid #FFC107; }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      
      <?=NavBarView(); ?>

      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        
        <?=SideBarView(); ?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Page Header -->
            <div class="d-xl-flex justify-content-between align-items-start mb-4">
              <div>
                <h2 class="text-dark font-weight-bold mb-2">
                  <i class="mdi mdi-credit-card mr-2"></i>Gestión de Pagos
                </h2>
                <p class="text-muted">Administra tus pagos y visualiza el historial</p>
              </div>
              <button class="btn btn-primary" data-toggle="modal" data-target="#registrarPagoModal">
                <i class="mdi mdi-plus mr-2"></i>Registrar Pago
              </button>
            </div>

            <!-- Estadísticas -->
            <div class="row mb-4">
              <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                <div class="card payment-card stat-card-primary">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h5 class="card-title text-muted font-weight-normal mb-1">Total Pagado</h5>
                        <h3 class="text-dark font-weight-bold mb-0">$45,250</h3>
                        <small class="text-muted">Este año</small>
                      </div>
                      <i class="mdi mdi-cash-multiple icon-lg text-primary opacity-50"></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                <div class="card payment-card stat-card-warning">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h5 class="card-title text-muted font-weight-normal mb-1">Pagos Pendientes</h5>
                        <h3 class="text-dark font-weight-bold mb-0">$8,500</h3>
                        <small class="text-muted">3 pendientes</small>
                      </div>
                      <i class="mdi mdi-clock-outline icon-lg text-warning opacity-50"></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                <div class="card payment-card stat-card-success">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h5 class="card-title text-muted font-weight-normal mb-1">Al Corriente</h5>
                        <h3 class="text-dark font-weight-bold mb-0">$2,750</h3>
                        <small class="text-muted">Próximo mes</small>
                      </div>
                      <i class="mdi mdi-check-circle icon-lg text-success opacity-50"></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                <div class="card payment-card stat-card-danger">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h5 class="card-title text-muted font-weight-normal mb-1">Vencidos</h5>
                        <h3 class="text-dark font-weight-bold mb-0">$1,200</h3>
                        <small class="text-muted">1 vencido</small>
                      </div>
                      <i class="mdi mdi-alert-circle icon-lg text-danger opacity-50"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="row mb-3">
              <div class="col-12">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pagos-realizados-tab" data-toggle="tab" href="#pagos-realizados" role="tab">
                      <i class="mdi mdi-check-circle mr-2"></i>Pagos Realizados
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pagos-pendientes-tab" data-toggle="tab" href="#pagos-pendientes" role="tab">
                      <i class="mdi mdi-clock mr-2"></i>Pagos Pendientes
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pagos-vencidos-tab" data-toggle="tab" href="#pagos-vencidos" role="tab">
                      <i class="mdi mdi-alert mr-2"></i>Pagos Vencidos
                    </a>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
              <!-- Pagos Realizados -->
              <div class="tab-pane fade show active" id="pagos-realizados" role="tabpanel">
                <div class="card">
                  <div class="card-header bg-light">
                    <h4 class="card-title mb-0">Historial de Pagos Realizados</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="table-light">
                          <tr>
                            <th>Folio</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Fecha de Pago</th>
                            <th>Método de Pago</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(!empty($pagos)): ?>
                            <?php foreach($pagos as $pago): ?>
                            <tr>
                              <td><strong><?= $pago['id_pago'] ?></strong></td>
                              <td><?= $pago['concepto'] ?></td>
                              <td><span class="font-weight-bold text-dark">$<?= number_format($pago['monto'], 2) ?></span></td>
                              <td><?= $pago['fecha_pago'] ? date('d/m/Y', strtotime($pago['fecha_pago'])) : '-' ?></td>
                              <td>
                                <span class="badge <?= $pago['metodo_pago'] == 'transferencia' ? 'badge-info' : ($pago['metodo_pago'] == 'efectivo' ? 'badge-success' : 'badge-warning') ?>">
                                  <?= ucfirst($pago['metodo_pago']) ?>
                                </span>
                              </td>
                              <td>
                                <span class="badge <?= $pago['estado'] == 'pagado' ? 'badge-completed' : ($pago['estado'] == 'pendiente' ? 'badge-warning' : 'badge-danger') ?>">
                                  <?= ucfirst($pago['estado']) ?>
                                </span>
                              </td>
                              <td>
                                <?php if($pago['estado'] == 'pendiente'): ?>
                                <button class="btn btn-sm btn-outline-success" onclick="marcarPagado(<?= $pago['id_pago'] ?>)" title="Marcar como pagado">
                                  <i class="mdi mdi-check"></i>
                                </button>
                                <?php endif; ?>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                          <tr>
                            <td colspan="7" class="text-center text-muted">Sin pagos registrados</td>
                          </tr>
                          <?php endif; ?>
                        </tbody>
                                <i class="mdi mdi-download"></i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <nav>
                      <ul class="pagination justify-content-center mt-4">
                        <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>

              <!-- Pagos Pendientes -->
              <div class="tab-pane fade" id="pagos-pendientes" role="tabpanel">
                <div class="card">
                  <div class="card-header bg-light">
                    <h4 class="card-title mb-0">Pagos Pendientes de Realizar</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="table-light">
                          <tr>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Fecha Límite</th>
                            <th>Días Restantes</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><strong>Renta Espacio - Junio</strong></td>
                            <td><span class="font-weight-bold text-dark">$2,500.00</span></td>
                            <td>05/06/2026</td>
                            <td><span class="badge badge-info">12 días</span></td>
                            <td><span class="badge badge-pending">Pendiente</span></td>
                            <td>
                              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#registrarPagoModal" title="Pagar ahora">
                                <i class="mdi mdi-check"></i> Pagar
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Renta Espacio - Julio</strong></td>
                            <td><span class="font-weight-bold text-dark">$2,500.00</span></td>
                            <td>05/07/2026</td>
                            <td><span class="badge badge-light">22 días</span></td>
                            <td><span class="badge badge-pending">Pendiente</span></td>
                            <td>
                              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#registrarPagoModal" title="Pagar ahora">
                                <i class="mdi mdi-check"></i> Pagar
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Cuota Mantenimiento - Junio</strong></td>
                            <td><span class="font-weight-bold text-dark">$500.00</span></td>
                            <td>10/06/2026</td>
                            <td><span class="badge badge-info">7 días</span></td>
                            <td><span class="badge badge-pending">Pendiente</span></td>
                            <td>
                              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#registrarPagoModal" title="Pagar ahora">
                                <i class="mdi mdi-check"></i> Pagar
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Pagos Vencidos -->
              <div class="tab-pane fade" id="pagos-vencidos" role="tabpanel">
                <div class="card">
                  <div class="card-header bg-danger text-white">
                    <h4 class="card-title mb-0">⚠️ Pagos Vencidos</h4>
                  </div>
                  <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                      <i class="mdi mdi-alert-circle mr-2"></i>
                      <strong>¡Atención!</strong> Tienes 1 pago vencido. Por favor, realiza el pago lo antes posible para evitar sanciones.
                    </div>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="table-light">
                          <tr>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Fecha Límite</th>
                            <th>Días Vencido</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="table-danger">
                            <td><strong>Renta Espacio - Mayo Adicional</strong></td>
                            <td><span class="font-weight-bold">$1,200.00</span></td>
                            <td>30/05/2026</td>
                            <td><span class="badge badge-danger">15 días vencido</span></td>
                            <td><span class="badge badge-overdue">Vencido</span></td>
                            <td>
                              <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#registrarPagoModal" title="Pagar inmediatamente">
                                <i class="mdi mdi-alert"></i> Pagar Ahora
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sección de Contacto -->
            <div class="row mt-5">
              <div class="col-md-6 mb-3">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title mb-3">
                      <i class="mdi mdi-help-circle mr-2"></i>¿Preguntas sobre tus pagos?
                    </h5>
                    <p class="card-text text-muted mb-3">Si tienes dudas o necesitas ayuda con algún pago, contacta con nuestro equipo de soporte.</p>
                    <button class="btn btn-outline-primary">
                      <i class="mdi mdi-email mr-2"></i>Enviar Mensaje
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title mb-3">
                      <i class="mdi mdi-information mr-2"></i>Información de Pago
                    </h5>
                    <ul class="list-unstyled mb-0">
                      <li class="mb-2"><strong>Banco:</strong> Banco Nacional</li>
                      <li class="mb-2"><strong>Cuenta:</strong> 123456789</li>
                      <li class="mb-2"><strong>Titular:</strong> Tracto Pensión S.A.</li>
                      <li><strong>Referencia:</strong> Usa tu número de cliente</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- content-wrapper ends -->
          <footer class="footer">
            <div class="footer-inner-wraper">
              <span class="text-muted text-left d-block">Copyright © 2025 Tracto Pensión San Leonardo. Todos los derechos reservados.</span>
            </div>
          </footer>
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller ends -->

    <!-- Modal: Registrar Pago -->
    <div class="modal fade" id="registrarPagoModal" tabindex="-1" role="dialog" aria-labelledby="registrarPagoLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="registrarPagoLabel">
              <i class="mdi mdi-cash-multiple mr-2"></i>Registrar Nuevo Pago
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="formPago">
              <div class="form-group">
                <label for="concepto">Concepto del Pago <span class="text-danger">*</span></label>
                <select class="form-control" id="concepto" name="concepto" required>
                  <option value="">Selecciona un concepto</option>
                  <option value="renta_junio">Renta Espacio - Junio 2026</option>
                  <option value="renta_julio">Renta Espacio - Julio 2026</option>
                  <option value="mantenimiento">Cuota Mantenimiento - Junio 2026</option>
                  <option value="otro">Otro</option>
                </select>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="monto">Monto <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="number" class="form-control" id="monto" name="monto" placeholder="0.00" step="0.01" required>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="fecha_pago">Fecha de Pago <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                </div>
              </div>

              <div class="form-group">
                <label for="metodo_pago">Método de Pago <span class="text-danger">*</span></label>
                <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                  <option value="">Selecciona un método</option>
                  <option value="transferencia">Transferencia Bancaria</option>
                  <option value="efectivo">Efectivo</option>
                  <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                  <option value="cheque">Cheque</option>
                </select>
              </div>

              <div class="form-group">
                <label for="numero_referencia">Número de Referencia <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="numero_referencia" name="numero_referencia" placeholder="Ej: TRF-2026-001" required>
              </div>

              <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Agrega algún comentario adicional (opcional)"></textarea>
              </div>

              <div class="alert alert-info" role="alert">
                <i class="mdi mdi-information-outline mr-2"></i>
                Por favor, guarda tu número de referencia para efectos de comprobación.
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="guardarPago()">
              <i class="mdi mdi-check mr-2"></i>Registrar Pago
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="public/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="public/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="public/assets/js/demo_1/dashboard.js"></script>
    <script src="public/assets/js/misc.js"></script>

    <script>
      // Establecer fecha actual como valor por defecto
      document.getElementById('fecha_pago').valueAsDate = new Date();

      function guardarPago() {
        const form = document.getElementById('formPago');
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          // Aquí iría la lógica para guardar el pago
          alert('Pago registrado exitosamente');
          $('#registrarPagoModal').modal('hide');
          form.reset();
          document.getElementById('fecha_pago').valueAsDate = new Date();
        }
      }

      // Validación en tiempo real
      document.getElementById('formPago').addEventListener('submit', function(e) {
        e.preventDefault();
        guardarPago();
      });
    </script>
  </body>
</html>

          