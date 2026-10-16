<?php 
require_once 'views/includes/SideBarView.php'; 
require_once 'views/includes/NavBarView.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Cambiar Contraseña</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="public/assets/vendors/css/vendor.bundle.base.css">

    <!-- Layout styles -->
    <link rel="stylesheet" href="public/assets/css/demo_1/style.css">

</head>

<body>

<div class="container-scroller">

    <!-- Navbar -->
    <?= NavBarView(); ?>

    <div class="container-fluid page-body-wrapper">

        <!-- Sidebar -->
        <?= SideBarView(); ?>

        <!-- Main -->
        <div class="main-panel">

            <div class="content-wrapper">

                <!-- Header -->
                <div class="page-header">

                    <h3 class="page-title">

                        <i class="mdi mdi-lock-reset text-dark mr-2"></i>
                        Cambiar Contraseña

                    </h3>

                </div>

                <!-- Card -->
                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <div class="row justify-content-center">

                            <div class="col-md-7">

                                <div class="text-center mb-4">

                                    <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center mx-auto mb-3">

                                        <i class="mdi mdi-lock-reset icon-lg text-dark"></i>

                                    </div>

                                    <h4 class="font-weight-bold">
                                        Seguridad De Cuenta
                                    </h4>

                                    <p class="text-muted">
                                        Actualiza tu contraseña para mantener segura tu cuenta.
                                    </p>

                                </div>

                                <form method="POST">

                                    <!-- Contraseña actual -->
                                    <div class="form-group">

                                        <label>
                                            Contraseña Actual
                                        </label>

                                        <input type="password"
                                               class="form-control"
                                               placeholder="Ingrese su contraseña actual">

                                    </div>

                                    <!-- Nueva contraseña -->
                                    <div class="form-group">

                                        <label>
                                            Nueva Contraseña
                                        </label>

                                        <input type="password"
                                               class="form-control"
                                               placeholder="Ingrese la nueva contraseña">

                                    </div>

                                    <!-- Confirmar -->
                                    <div class="form-group">

                                        <label>
                                            Confirmar Nueva Contraseña
                                        </label>

                                        <input type="password"
                                               class="form-control"
                                               placeholder="Confirme la nueva contraseña">

                                    </div>

                                    <!-- Botones -->
                                    <div class="mt-4 text-center">

                                        <button type="submit"
                                                class="btn btn-primary rounded-pill mr-2">

                                            <i class="mdi mdi-content-save"></i>
                                            Guardar Cambios

                                        </button>

                                        <a href="?menu=perfil"
                                           class="btn btn-dark rounded-pill">

                                            <i class="mdi mdi-arrow-left"></i>
                                            Regresar

                                        </a>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Footer -->
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

<!-- inject:js -->
<script src="public/assets/js/off-canvas.js"></script>
<script src="public/assets/js/hoverable-collapse.js"></script>
<script src="public/assets/js/misc.js"></script>

</body>
</html>