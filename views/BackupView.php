<?php
require_once 'views/includes/SideBarView.php';
require_once 'views/includes/NavBarView.php';

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$backupController = new BackupController();
$mensaje = '';
$tipoMensaje = 'info';

if (isset($_GET['message'])) {
  $mensaje = urldecode((string) $_GET['message']);
  $tipoMensaje = isset($_GET['type']) ? (string) $_GET['type'] : 'info';
}

$action = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
  $action = $_GET['action'];
}

if ($action === 'generar') {
  $resultado = $backupController->generarRespaldo();
  $mensaje = $resultado['message'] ?? 'Operación completada.';
  $tipoMensaje = $resultado['success'] ? 'success' : 'danger';
  $redirectUrl = 'index.php?menu=respaldo&message=' . urlencode($mensaje) . '&type=' . urlencode($tipoMensaje);
  header('Location: ' . $redirectUrl);
  exit;
} elseif ($action === 'importar') {
  if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $archivo = $_FILES['archivo'];
    if (pathinfo($archivo['name'], PATHINFO_EXTENSION) !== 'sql') {
      $mensaje = 'Solo se permiten archivos .sql';
      $tipoMensaje = 'danger';
    } elseif ($archivo['size'] > 104857600) {
      $mensaje = 'El archivo es demasiado grande (máximo 100MB)';
      $tipoMensaje = 'danger';
    } else {
      $backupDir = __DIR__ . '/../respaldos';
      if (!is_dir($backupDir)) {
        mkdir($backupDir, 0755, true);
      }

      $timestamp = date('Y-m-d_H-i-s');
      $filename = $backupDir . DIRECTORY_SEPARATOR . 'respaldo_importado_' . $timestamp . '.sql';

      if (move_uploaded_file($archivo['tmp_name'], $filename)) {
        $resultado = $backupController->importarRespaldo($filename);
        $mensaje = $resultado['message'] ?? 'Operación completada.';
        $tipoMensaje = $resultado['success'] ? 'success' : 'danger';
        if ($resultado['success']) {
          unlink($filename);
        }
      } else {
        $mensaje = 'Error al guardar el archivo';
        $tipoMensaje = 'danger';
      }
    }
  } else {
    $mensaje = 'Error en la carga del archivo';
    $tipoMensaje = 'danger';
  }

  if ($action === 'importar') {
    $redirectUrl = 'index.php?menu=respaldo&message=' . urlencode($mensaje) . '&type=' . urlencode($tipoMensaje);
    header('Location: ' . $redirectUrl);
    exit;
  }
}

$respaldos = $backupController->listarRespaldos();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Respaldos - Tracto Pensión</title>
    <link rel="stylesheet" href="public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="public/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="public/assets/css/demo_1/style.css">
    <link rel="shortcut icon" href="public/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <?= NavBarView(); ?>
      <div class="container-fluid page-body-wrapper">
        <?= SideBarView(); ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Respaldos de Base de Datos</h4>
                <p class="text-muted">Puedes crear, importar o descargar copias de seguridad de la base de datos.</p>

                <div class="row mb-4">
                  <div class="col-md-6">
                    <a id="btnGenerar" href="index.php?menu=respaldo&action=generar" class="btn btn-primary">Generar respaldo</a>
                  </div>
                  <div class="col-md-6">
                    <form id="formImportar" method="post" action="index.php?menu=respaldo" enctype="multipart/form-data">
                      <input type="hidden" name="action" value="importar">
                      <div class="custom-file mb-2">
                        <input type="file" class="custom-file-input" id="archivo" name="archivo" accept=".sql" required>
                        <label class="custom-file-label" for="archivo">Seleccionar archivo .sql</label>
                      </div>
                      <button type="submit" class="btn btn-outline-success">Importar respaldo</button>
                    </form>
                  </div>
                </div>

                <?php if (!empty($mensaje)): ?>
                  <div id="mensaje" class="alert alert-<?= htmlspecialchars($tipoMensaje) ?>" role="alert">
                    <?= htmlspecialchars($mensaje) ?>
                  </div>
                <?php else: ?>
                  <div id="mensaje" class="alert d-none" role="alert"></div>
                <?php endif; ?>

                <div class="table-responsive mt-3">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Archivo</th>
                        <th>Tamaño</th>
                        <th>Modificado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (empty($respaldos)): ?>
                        <tr>
                          <td colspan="4" class="text-center text-muted">No hay respaldos disponibles.</td>
                        </tr>
                      <?php else: ?>
                        <?php foreach ($respaldos as $respaldo): ?>
                          <tr>
                            <td><?= htmlspecialchars($respaldo['name']) ?></td>
                            <td><?= number_format($respaldo['size'] / 1024, 2) ?> KB</td>
                            <td><?= htmlspecialchars($respaldo['modified']) ?></td>
                            <td>
                              <a class="btn btn-sm btn-outline-primary" href="api/backup.php?action=descargar&filename=<?= urlencode(basename($respaldo['name'])) ?>">Descargar</a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <footer class="footer">
            <div class="footer-inner-wraper">
              <div class="d-flex justify-content-start">
                <span class="text-muted text-left d-block">Copyright © 2025 Tracto Pensión San Leonardo. Todos los derechos reservados.</span>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </div>

    <!-- plugins:js -->
    <script src="public/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="public/assets/js/off-canvas.js"></script>
    <script src="public/assets/js/hoverable-collapse.js"></script>
    <script src="public/assets/js/misc.js"></script>
    <script src="public/assets/js/settings.js"></script>
    <script src="public/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script>
      // Actualizar el nombre del archivo seleccionado en el label del input file personalizado
      document.getElementById('archivo').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Seleccionar archivo .sql';
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
      });
    </script>
  </body>
</html>
