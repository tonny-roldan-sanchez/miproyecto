<?php 
require_once 'views/includes/SideBarView.php';
require_once 'views/includes/NavBarView.php';

// Datos de ejemplo para la vista de accesos si el controlador no setea `$accesos`
if(!isset($accesos) || !is_array($accesos)){
  $accesos = [
    ['fecha'=>'12/03/2026','hora'=>'01:54','estado'=>'Entrada'],
    ['fecha'=>'13/03/2026','hora'=>'13:20','estado'=>'Salida'],
    ['fecha'=>'16/03/2026','hora'=>'07:14','estado'=>'Entrada'],
    ['fecha'=>'18/03/2026','hora'=>'06:56','estado'=>'Salida'],
    ['fecha'=>'20/03/2026','hora'=>'15:20','estado'=>'Entrada'],
    ['fecha'=>'21/03/2026','hora'=>'11:35','estado'=>'Salida'],
    ['fecha'=>'26/03/2026','hora'=>'21:15','estado'=>'Entrada'],
    ['fecha'=>'27/03/2026','hora'=>'20:10','estado'=>'Salida'],
    ['fecha'=>'01/04/2026','hora'=>'18:55','estado'=>'Entrada'],
    ['fecha'=>'02/04/2026','hora'=>'22:18','estado'=>'Salida'],
  ];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Historial de Accesos - Tracto Pensión</title>
    <link rel="stylesheet" href="public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="public/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="public/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="public/assets/css/demo_1/style.css">
    <link rel="shortcut icon" href="public/assets/images/favicon.png" />
    <style>
      body.custom-bg { background:#e9ecef; }
      .access-card { max-width:980px; margin:40px auto; }
      .access-table thead th { text-align:center; color:#0b5394; }
      .access-table tbody td { vertical-align:middle; text-align:center; }
      .access-inner { background:#f5f5f5; border:3px solid #333; }
      .page-title { font-size:34px; color:#0b5394; font-weight:700; margin-bottom:20px; }
    </style>
  </head>
  <body class="custom-bg">
    <div class="container-scroller">
      <?=NavBarView(); ?>
      <div class="container-fluid page-body-wrapper">
        <?=SideBarView(); ?>
        <div class="main-panel">
          <div class="content-wrapper">

            <div class="access-card">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="page-title text-center">Historial de Accesos</div>
                  <div class="card mt-3">
                    <div class="card-body text-center">
                      <h3 class="text-primary font-weight-bold">Estado de Accesos</h3>
                      <div class="mt-4 p-4 access-inner">
                        <div class="table-responsive">
                          <table class="table access-table mb-0">
                            <thead>
                              <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Entrada / Salida</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($accesos as $row): ?>
                                <tr>
                                  <td><?= htmlspecialchars($row['fecha']) ?></td>
                                  <td><?= htmlspecialchars($row['hora']) ?></td>
                                  <td>
                                    <?php if(strtolower($row['estado']) === 'entrada'): ?>
                                      <span class="badge badge-success">Entrada</span>
                                    <?php else: ?>
                                      <span class="badge badge-danger">Salida</span>
                                    <?php endif; ?>
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
            </div>

          </div>
          <!-- content-wrapper ends -->
          <footer class="footer">
            <div class="footer-inner-wraper">
              <div class="d-flex justify-content-start">
                <span class="text-muted text-left d-block">Copyright © 2025 Tracto Pensión San Leonardo. Todos los derechos reservados.</span>
              </div>
            </div>
          </footer>
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    <script src="public/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="public/assets/js/off-canvas.js"></script>
    <script src="public/assets/js/hoverable-collapse.js"></script>
    <script src="public/assets/js/misc.js"></script>
  </body>
</html>