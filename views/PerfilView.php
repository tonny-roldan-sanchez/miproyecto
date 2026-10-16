<?php
require_once base_path('views/includes/SideBarView.php');
require_once base_path('views/includes/NavBarView.php');

$usuario = $_SESSION['usuario'] ?? [];
$usuario['nombre'] = $usuario['nombre'] ?? 'Usuario';
$usuario['correo'] = $usuario['correo'] ?? $usuario['email'] ?? '';
$usuario['telefono'] = $usuario['telefono'] ?? 'No registrado';
$usuario['rol'] = $usuario['rol'] ?? 'Usuario';
$usuario['foto'] = $usuario['foto'] ?? '/dist/img/avatar.png';
$mensajePerfil = $_SESSION['mensaje_perfil'] ?? '';
$errorPerfil = $_SESSION['error_perfil'] ?? '';
unset($_SESSION['mensaje_perfil'], $_SESSION['error_perfil']);
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Perfil</title>

    <link rel="stylesheet" href="/assets/css/demo_1/style.css">
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">

</head>

<body>

    <div class="container-scroller">

        <?= NavBarView(); ?>

        <div class="container-fluid page-body-wrapper">

            <?= SideBarView(); ?>

            <div class="main-panel">

                <div class="content-wrapper">

                    <!-- Título -->
                    <div class="page-header">

                        <h3 class="page-title">

                            <i class="fas fa-users mr-2"></i>
                            Usuarios

                        </h3>

                    </div>

                    <?php if ($mensajePerfil !== ''): ?>
                        <div class="alert alert-success"><?= e($mensajePerfil) ?></div>
                    <?php endif; ?>
                    <?php if ($errorPerfil !== ''): ?>
                        <div class="alert alert-danger"><?= e($errorPerfil) ?></div>
                    <?php endif; ?>

                    <!-- Card -->
                    <div class="card shadow-sm border-0 profile-card">

                        <div class="card-body">

                            <div class="row">

                                <!-- Foto -->
                                <div class="col-md-4 text-center">

                                    <img src="<?= e($usuario['foto']) ?>"
                                        class="rounded-circle shadow"
                                        width="180">

                                    <h4 class="mt-3">
                                        <?= e($usuario['nombre']) ?>
                                    </h4>

                                    <label class="badge badge-primary p-2">
                                        <?= e($usuario['rol']) ?>
                                    </label>

                                </div>

                                <!-- Información -->
                                <div class="col-md-8">

                                    <form method="POST" enctype="multipart/form-data">
                                        <?= csrf_field() ?>

                                        <div class="form-group">
                                            <label for="foto">Foto de perfil</label>
                                            <input type="file" class="form-control-file" id="foto" name="foto"
                                                accept="image/jpeg,image/png,image/gif,image/webp">
                                            <small class="form-text text-muted">Formatos JPG, PNG, GIF o WEBP. Máximo 5 MB.</small>
                                        </div>

                                        <div class="form-group">

                                            <label>
                                                Nombre
                                            </label>

                                            <input type="text"
                                                class="form-control"
                                                value="<?= e($usuario['nombre']) ?>">

                                        </div>

                                        <div class="form-group">

                                            <label>
                                                Correo
                                            </label>

                                            <input type="email"
                                                class="form-control"
                                                value="<?= e($usuario['correo']) ?>">

                                        </div>

                                        <div class="form-group">

                                            <label>
                                                Teléfono
                                            </label>

                                            <input type="text"
                                                class="form-control"
                                                value="<?= e($usuario['telefono']) ?>">

                                        </div>

                                        <div class="form-group">

                                            <label>
                                                Contraseña
                                            </label>

                                            <input type="password"
                                                class="form-control"
                                                placeholder="********">

                                        </div>

                                        <div class="mt-4">

                                            <button class="btn btn-primary mr-2">

                                                <i class="mdi mdi-content-save"></i>
                                                Guardar Cambios

                                            </button>

                                            <button class="btn btn-danger">

                                                <i class="mdi mdi-delete"></i>
                                                Eliminar Perfil

                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0"><i class="fas fa-users mr-2"></i>Usuarios registrados</h4>
                                <input type="search" id="buscarUsuario" class="form-control" placeholder="Buscar usuario..." style="max-width: 260px;">
                            </div>

                            <form action="<?= e(route('usuarios.store')) ?>" method="POST" class="user-form">
                                <?= csrf_field() ?>
                                <div class="user-form-grid">
                                    <input class="form-control" name="nombre" placeholder="Nombre" required>
                                    <input class="form-control" name="apellidos" placeholder="Apellidos" required>
                                    <input class="form-control" type="email" name="correo" placeholder="Correo" required>
                                    <input class="form-control" name="telefono" placeholder="Teléfono" required>
                                    <input class="form-control" type="password" name="contrasena" placeholder="Contraseña" required>
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-user-plus mr-1"></i>Agregar</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-hover" id="tablaUsuarios">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuarios as $registro): ?>
                                            <tr>
                                                <td><?= e($registro['id_usuario'] ?? '') ?></td>
                                                <td><?= e($registro['nombre'] ?? '') ?></td>
                                                <td><?= e($registro['apellidos'] ?? '') ?></td>
                                                <td><?= e($registro['email'] ?? '') ?></td>
                                                <td><?= e($registro['telefono'] ?? '') ?></td>
                                                <td class="actions-cell">
                                                    <button type="button" class="btn btn-sm btn-outline-primary js-edit-user" data-user='<?= e(json_encode($registro, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)) ?>' title="Editar"><i class="fas fa-edit"></i></button>
                                                    <form action="<?= e(route('usuarios.destroy', $registro['id_usuario'])) ?>" method="POST" class="inline-form" onsubmit="return confirm('¿Eliminar este usuario?');">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button class="btn btn-sm btn-outline-danger" type="submit" title="Eliminar"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <small id="resumenUsuarios" class="text-muted"></small>
                        </div>
                    </div>

                    <div id="editarUsuario" class="card shadow-sm border-0 mt-4 edit-user-card" hidden>
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-user-edit mr-2"></i>Editar usuario</h4>
                            <form id="formEditarUsuario" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="PUT">
                                <div class="user-form-grid">
                                    <input id="editarNombre" class="form-control" name="nombre" required>
                                    <input id="editarApellidos" class="form-control" name="apellidos" required>
                                    <input id="editarCorreo" class="form-control" type="email" name="correo" required>
                                    <input id="editarTelefono" class="form-control" name="telefono" required>
                                    <input class="form-control" type="password" name="contrasena" placeholder="Nueva contraseña (opcional)">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i>Guardar cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <footer class="footer">
            <div class="footer-inner-wraper">
                <span class="text-muted text-left d-block">Copyright © 2025 Tracto Pensión San Leonardo. Todos los derechos reservados.</span>
            </div>
        </footer>

    </div>

    <!-- plugins:js -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- inject:js -->
    <script src="/assets/layout.js"></script>

</body>
<script>
    const inputUsuarios = document.getElementById('buscarUsuario');
    const filasUsuarios = Array.from(document.querySelectorAll('#tablaUsuarios tbody tr'));
    const resumenUsuarios = document.getElementById('resumenUsuarios');

    function filtrarUsuarios() {
        const busqueda = inputUsuarios.value.toLowerCase().trim();
        let visibles = 0;

        filasUsuarios.forEach((fila) => {
            const coincide = fila.textContent.toLowerCase().includes(busqueda);
            fila.style.display = coincide ? '' : 'none';
            if (coincide) visibles++;
        });

        resumenUsuarios.textContent = `Mostrando ${visibles} de ${filasUsuarios.length} usuarios`;
    }

    inputUsuarios.addEventListener('input', filtrarUsuarios);
    filtrarUsuarios();

    document.querySelectorAll('.js-edit-user').forEach((button) => {
        button.addEventListener('click', () => {
            const usuario = JSON.parse(button.dataset.user);
            document.getElementById('editarUsuario').hidden = false;
            document.getElementById('formEditarUsuario').action = `/datos/perfil/usuarios/${usuario.id_usuario}`;
            document.getElementById('editarNombre').value = usuario.nombre || '';
            document.getElementById('editarApellidos').value = usuario.apellidos || '';
            document.getElementById('editarCorreo').value = usuario.email || '';
            document.getElementById('editarTelefono').value = usuario.telefono || '';
            document.getElementById('editarUsuario').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
</script>

</html>