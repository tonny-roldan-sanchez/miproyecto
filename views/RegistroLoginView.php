<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connect Plus</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="public/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="public/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="public/assets/css/demo_1/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="public/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
          <div class="row flex-grow">
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
              <div class="auth-form-transparent text-left p-3">
                <div class="brand-logo">
                  <img src="public/assets/images/logo-dark.svg" alt="logo">
                </div>
                <h4>¿Eres nuevo?</h4>
                <h6 class="font-weight-light">¡Regístrate hoy! Solo toma unos pasos</h6>
                <?php if (!empty($errores)): ?>
                  <div class="alert alert-danger">
                    <?= e(implode(' ', $errores)) ?>
                  </div>
                <?php endif; ?>
                <form class="pt-3" method="POST" action="index.php?menu=registro">
                  <?= csrf_input() ?>
                  <div class="form-group">
                    <label for="nombre">Nombre de usuario</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="mdi mdi-account-outline text-primary"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control form-control-lg border-left-0" id="nombre" name="nombre" placeholder="Nombre de usuario" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="mdi mdi-email-outline text-primary"></i>
                        </span>
                      </div>
                      <input type="email" class="form-control form-control-lg border-left-0" id="email" name="email" placeholder="Correo electrónico" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="mdi mdi-lock-outline text-primary"></i>
                        </span>
                      </div>
                      <input type="password" class="form-control form-control-lg border-left-0" id="password" name="password" placeholder="Contraseña" minlength="6" required>
                    </div>
                  </div>
                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input" name="terminos" required> Acepto todos los términos y condiciones </label>
                    </div>
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">REGISTRARSE</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light">¿Ya tienes una cuenta? <a href="?menu=login" class="text-primary">Iniciar sesión</a>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-lg-6 register-half-bg d-flex flex-row"></div>
          </div>
          <?php if (!empty($usuarioRepetido)): ?>
            <div class="modal fade" id="usuarioRepetidoModal" tabindex="-1" role="dialog" aria-labelledby="usuarioRepetidoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="usuarioRepetidoLabel">Usuario repetido</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    Elige otro nombre de usuario.
                  </div>
                  <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <footer class="footer position-fixed fixed-bottom">
            <div class="footer-inner-wraper">
              <span class="text-muted text-left d-block">Copyright © 2025 Tracto Pensión San Leonardo. Todos los derechos reservados.</span>
            </div>
          </footer>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
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
    <?php if (!empty($usuarioRepetido)): ?>
      <script>
        $(function() {
          $('#usuarioRepetidoModal').modal('show');
        });
      </script>
    <?php endif; ?>
    <!-- endinject -->
  </body>
</html>