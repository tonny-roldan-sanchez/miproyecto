<!DOCTYPE html>
<html lang="en">
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
                <h4>Bienvenido a Tracto Pension San Leonardo!</h4>
                <h6 class="font-weight-light">Acceso al sistema!</h6>
                <?php if (!empty($errorLogin)): ?>
                  <div class="alert alert-danger"><?= e($errorLogin) ?></div>
                <?php endif; ?>
                <form class="pt-3" method="post" action="index.php?menu=login">
                  <div class="form-group">
                    <label for="exampleInputEmail">Usuario</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="mdi mdi-account-outline text-primary"></i>
                        </span>
                      </div>
                      <input type="text" name="identificador" class="form-control form-control-lg border-left-0" placeholder="Nombre o correo del usuario" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword">Contraseña</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="mdi mdi-lock-outline text-primary"></i>
                        </span>
                      </div>
                      <input type="password" name="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Ingresa tu contraseña" required>
                    </div>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Mantener sesión iniciada </label>
                    </div>
                    <a href="#" class="auth-link text-black">¿Olvidaste tu contraseña?</a>
                  </div>
                  <div class="my-3">
                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Ingresar</button>
                  </div>
                  <div class="mb-2 d-flex">
                    
                  </div>
                  <div class="text-center mt-4 font-weight-light"> ¿No tienes cuenta? <a href="?menu=registro" class="text-primary">Crear</a>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-lg-6 login-half-bg d-flex flex-row"></div>
          </div>
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
    <!-- endinject -->
  </body>
</html>