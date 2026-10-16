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

    <!-- plugins:css -->
    <link rel="stylesheet" href="public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="public/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="public/assets/vendors/css/vendor.bundle.base.css">

    <!-- Plugin css -->
    <link rel="stylesheet" href="public/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="public/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">

    <!-- Layout styles -->
    <link rel="stylesheet" href="public/assets/css/demo_1/style.css">

    <link rel="shortcut icon" href="public/assets/images/favicon.png" />

</head>

<body>

<div class="container-scroller">

    <!-- Navbar -->
    <?=NavBarView(); ?>

    <div class="container-fluid page-body-wrapper">

        <!-- Configuración -->
        <div id="settings-trigger">
            <i class="mdi mdi-settings"></i>
        </div>

        <div id="theme-settings" class="settings-panel">

            <i class="settings-close mdi mdi-close"></i>

            <p class="settings-heading">SIDEBAR SKINS</p>

            <div class="sidebar-bg-options selected" id="sidebar-default-theme">
                <div class="img-ss rounded-circle bg-dark border mr-3"></div>
                Default
            </div>

            <div class="sidebar-bg-options" id="sidebar-dark-theme">
                <div class="img-ss rounded-circle bg-light border mr-3"></div>
                Light
            </div>

            <p class="settings-heading mt-2">HEADER SKINS</p>

            <div class="color-tiles mx-0 px-4">
                <div class="tiles primary"></div>
                <div class="tiles success"></div>
                <div class="tiles warning"></div>
                <div class="tiles danger"></div>
                <div class="tiles info"></div>
                <div class="tiles dark"></div>
                <div class="tiles default light"></div>
            </div>

        </div>

        <!-- Sidebar -->
        <?=SideBarView(); ?>

        <!-- Main -->
        <div class="main-panel">

            <div class="content-wrapper">

                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <h3 class="text-dark font-weight-bold mb-1">Mi Camión</h3>
                                        <p class="text-muted mb-0">Información general del vehículo registrado</p>
                                    </div>
                                    <button type="button" class="btn btn-warning rounded-pill" onclick="habilitarEdicion()">
                                        <i class="mdi mdi-pencil"></i>
                                        Editar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-5 col-md-12 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center">
                                <img src="public/assets/images/samples/1280x768/12.jpg"
                                     alt="Camión"
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height: 280px; object-fit: cover; width: 100%;">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-12 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h4 class="font-weight-bold mb-4">Información del Camión</h4>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Placa</label>
                                            <input type="text" name="placa" class="form-control editable" value="123-BF-5" disabled>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Marca</label>
                                            <input type="text" name="marca" class="form-control editable" value="Freightliner" disabled>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Modelo</label>
                                            <input type="text" name="modelo" class="form-control editable" value="Cascadia 2020" disabled>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Color</label>
                                            <input type="text" name="color" class="form-control editable" value="Blanco" disabled>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Fecha de Entrada</label>
                                            <input type="date" name="fecha" class="form-control editable" value="2026-04-22" disabled>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Hora de Entrada</label>
                                            <input type="time" name="hora" class="form-control editable" value="19:55" disabled>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label class="font-weight-bold">Estado</label>
                                            <select name="estado" class="form-control editable" disabled>
                                                <option value="En pensión" selected>En pensión</option>
                                                <option value="Fuera de pensión">Fuera de pensión</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-4 d-flex flex-wrap">
                                        <button type="submit" id="btnGuardar" class="btn btn-success rounded-pill mr-2 mb-2" disabled>
                                            <i class="mdi mdi-content-save"></i>
                                            Guardar Cambios
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<!-- SCRIPT -->
<script>

function habilitarEdicion() {

    let campos = document.querySelectorAll('.editable');

    campos.forEach(function(campo) {
        campo.disabled = false;
    });

    document.getElementById('btnGuardar').disabled = false;
}

</script>

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

<!-- Plugin js -->
<script src="public/assets/vendors/chart.js/Chart.min.js"></script>
<script src="public/assets/vendors/jquery-circle-progress/js/circle-progress.min.js"></script>

<!-- inject:js -->
<script src="public/assets/js/off-canvas.js"></script>
<script src="public/assets/js/hoverable-collapse.js"></script>
<script src="public/assets/js/misc.js"></script>
<script src="public/assets/js/settings.js"></script>
<script src="public/assets/js/todolist.js"></script>

<!-- Custom js -->
<script src="public/assets/js/dashboard.js"></script>

</body>
</html>