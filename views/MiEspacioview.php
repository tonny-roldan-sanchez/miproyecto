<?php 
require_once 'views/includes/SideBarView.php'; 
require_once 'views/includes/NavBarView.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Mi Espacio</title>

    <link rel="stylesheet" href="public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="public/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="public/assets/css/demo_1/style.css">

</head>

<body>

<div class="container-scroller">

    <?=NavBarView();?>

    <div class="container-fluid page-body-wrapper">

        <?=SideBarView();?>

        <div class="main-panel">

            <div class="content-wrapper">

                <!-- TITULO -->
                <div class="page-header">

                    <h3 class="page-title">

                        <i class="mdi mdi-parking text-dark mr-2"></i>
                        Mi Espacio

                    </h3>

                </div>

                <!-- CARD -->
                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-body">

                        <h2 class="text-center font-weight-bold mb-5">
                            Mi Espacio
                        </h2>

                        <!-- MAPA -->
                        <div class="d-flex flex-wrap justify-content-center mb-5">

                            <?php for($i = 1; $i <= 23; $i++): ?>

                                <button
                                    class="btn m-1 espacio-btn <?=($i == 12) ? 'btn-warning' : 'btn-secondary';?>"
                                    onclick="seleccionarEspacio(<?=$i;?>)"
                                    id="espacio<?=$i;?>"
                                    disabled>

                                    <?=$i;?>

                                </button>

                            <?php endfor; ?>

                        </div>

                        <!-- TABLA -->
                        <div class="table-responsive">

                            <table class="table table-bordered text-center">

                                <thead class="bg-light">

                                    <tr>

                                        <th colspan="2"
                                            class="text-primary font-weight-bold">

                                            Detalles Del Espacio

                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                        <td class="font-weight-bold">
                                            Número de Espacio
                                        </td>

                                        <td>

                                            <input type="text"
                                                   id="numeroEspacio"
                                                   class="form-control text-center"
                                                   value="12"
                                                   disabled>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td class="font-weight-bold">
                                            Terreno Asignado
                                        </td>

                                        <td>

                                            <input type="text"
                                                   id="terreno"
                                                   class="form-control text-center"
                                                   value="Terreno 2"
                                                   disabled>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td class="font-weight-bold">
                                            Estado
                                        </td>

                                        <td>

                                            <label id="estadoBadge"
                                                   class="badge badge-success p-2">

                                                En Uso

                                            </label>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <!-- BOTONES -->
                        <div class="text-center mt-4">

                            <button class="btn btn-primary rounded-pill mr-2"
                                    onclick="editarEspacio()">

                                <i class="mdi mdi-pencil"></i>
                                Editar Espacio

                            </button>

                            <button class="btn btn-danger rounded-pill"
                                    onclick="liberarEspacio()">

                                <i class="mdi mdi-close-circle"></i>
                                Liberar Espacio

                            </button>

                        </div>

                    </div>

                </div>

            </div>

            <!-- SCRIPT -->
            <script>

            let modoEdicion = false;
            let espacioActual = 12;

            function editarEspacio() {

                modoEdicion = true;

                let botones = document.querySelectorAll('.espacio-btn');

                botones.forEach(function(btn) {

                    btn.disabled = false;

                });

            }

            function seleccionarEspacio(numero) {

                if(!modoEdicion) return;

                // quitar color anterior
                document.getElementById("espacio" + espacioActual)
                    .classList.remove("btn-warning");

                document.getElementById("espacio" + espacioActual)
                    .classList.add("btn-secondary");

                // nuevo espacio
                espacioActual = numero;

                document.getElementById("espacio" + numero)
                    .classList.remove("btn-secondary");

                document.getElementById("espacio" + numero)
                    .classList.add("btn-warning");

                // actualizar tabla
                document.getElementById("numeroEspacio").value = numero;

                // cambiar terreno automático
                let terreno = "Terreno 1";

                if(numero >= 8 && numero <= 15) {

                    terreno = "Terreno 2";

                }

                if(numero >= 16) {

                    terreno = "Terreno 3";

                }

                document.getElementById("terreno").value = terreno;

            }

            function liberarEspacio() {

                document.getElementById("espacio" + espacioActual)
                    .classList.remove("btn-warning");

                document.getElementById("espacio" + espacioActual)
                    .classList.add("btn-secondary");

                document.getElementById("numeroEspacio").value = "";

                document.getElementById("terreno").value = "";

                let estado = document.getElementById("estadoBadge");

                estado.innerHTML = "Fuera de Uso";

                estado.classList.remove("badge-success");

                estado.classList.add("badge-danger");

            }

            </script>

            <!-- FOOTER -->
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
<script src="public/assets/js/settings.js"></script>
<script src="public/assets/js/todolist.js"></script>

</body>
</html>