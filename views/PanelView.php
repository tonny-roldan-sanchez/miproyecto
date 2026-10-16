<?php 
require_once 'views/includes/SideBarView.php'; 
require_once 'views/includes/NavBarView.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tracto Pensión</title>
    <link rel="stylesheet" href="public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="public/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="public/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="public/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="public/assets/css/demo_1/style.css">
    <link rel="shortcut icon" href="public/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">

      <?= NavBarView(); ?>

      <div class="container-fluid page-body-wrapper">
        <div id="settings-trigger"><i class="mdi mdi-settings"></i></div>

        <?= SideBarView(); ?>

        <div class="main-panel">
          <div class="content-wrapper">

            <div class="row">
              <div class="col-12">
                <div class="card border-0 shadow-sm mb-4">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                      <div>
                        <h3 class="text-dark font-weight-bold mb-1">Dashboard</h3>
                        <p class="text-muted mb-0">Resumen general del estado del sistema</p>
                      </div>
                      <div class="text-right">
                        <h4 class="text-primary mb-0">Bienvenido</h4>
                        <small class="text-muted">Tracto Pensión San Leonardo</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <?php
              $colorMap = [
                'primary' => ['color' => '#0d6efd'],
                'success' => ['color' => '#35c93f'],
                'warning' => ['color' => '#ffbf3f'],
                'info' => ['color' => '#a45bd1'],
              ];
              foreach ($panelData['stats'] as $stat):
                $colors = $colorMap[$stat['color']] ?? $colorMap['primary'];
              ?>
              <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                      <div>
                        <h6 class="text-muted mb-2"><?= htmlspecialchars($stat['title']) ?></h6>
                        <h2 class="font-weight-bold text-dark mb-0"><?= htmlspecialchars($stat['value']) ?></h2>
                      </div>
                      <div class="icon-box rounded-circle d-flex align-items-center justify-content-center" style="width:64px;height:64px;background-color:<?= htmlspecialchars($colors['color']) ?>;">
                        <i class="mdi <?= htmlspecialchars($stat['icon']) ?> text-white mdi-24px"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>

            <div class="row">
              <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body">
                    <h4 class="card-title mb-3">Ocupación Actual</h4>
                    <div class="d-flex align-items-center justify-content-center">
                      <div class="position-relative" style="width:220px;height:220px;">
                        <canvas id="ocupacionChart" width="220" height="220" style="display:block;width:220px;height:220px;"></canvas>
                        <div class="position-absolute text-center" style="top:50%;left:50%;width:max-content;transform:translate(-50%,-50%);">
                          <small class="text-muted d-block" style="font-size:12px;">Total de espacios</small>
                          <strong class="text-dark" style="font-size:24px;"><?= (int) $panelData['occupancy']['occupied'] + (int) $panelData['occupancy']['available'] ?></strong>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body">
                    <h4 class="card-title mb-3">Actividad Reciente</h4>
                    <div class="table-responsive">
                      <table class="table table-hover mb-0">
                        <thead>
                          <tr>
                            <th>Fecha</th>
                            <th>Línea</th>
                            <th>Nombre del operador</th>
                            <th>Pensionado</th>
                            <th>Movimiento</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($panelData['activity'] as $row): ?>
                          <?php $isEntry = strtolower($row['tipo']) === 'entrada'; ?>
                          <tr>
                            <td><?= htmlspecialchars($row['fecha']) ?></td>
                            <td><?= htmlspecialchars($row['linea']) ?></td>
                            <td><?= htmlspecialchars($row['operador']) ?></td>
                            <td><?= htmlspecialchars($row['pensionado']) ?></td>
                            <td>
                              <span class="badge badge-<?= $isEntry ? 'success' : 'danger' ?>">
                                <?= $isEntry ? 'Entrada' : 'Salida' ?>
                              </span>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- content-wrapper ends -->

          <footer class="footer">
            <div class="footer-inner-wraper">
              <div class="d-flex justify-content-start">
                <span class="text-muted text-left d-block">
                  Copyright © 2025 Tracto Pensión San Leonardo. Todos los derechos reservados.
                </span>
              </div>
            </div>
          </footer>

        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <script src="public/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="public/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="public/assets/js/off-canvas.js"></script>
    <script src="public/assets/js/hoverable-collapse.js"></script>
    <script src="public/assets/js/misc.js"></script>
    <script src="public/assets/js/settings.js"></script>
    <script src="public/assets/js/todolist.js"></script>
    <script>
      new Chart(document.getElementById('ocupacionChart'), {
        type: 'doughnut',
        data: {
          labels: ['Ocupado', 'Disponible'],
          datasets: [{
            data: [<?= (int) $panelData['occupancy']['occupied'] ?>, <?= (int) $panelData['occupancy']['available'] ?>],
            backgroundColor: ['#7ed321', '#e8edf2'],
            borderColor: ['#7ed321', '#e8edf2'],
            borderWidth: 1,
            hoverOffset: 6
          }]
        },
        options: {
          responsive: false,
          cutoutPercentage: 66,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return ' ' + context.label + ': ' + context.raw;
                }
              }
            }
          }
        }
      });
    </script>
  </body>
</html>