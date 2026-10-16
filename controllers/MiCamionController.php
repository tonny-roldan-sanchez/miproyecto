<?php
require_once 'models/MiCamionModel.php';

class MiCamionController {
    private $micamionmodel;
    
    public function __construct($conexion) {
        $this->micamionmodel = new MiCamionModel($conexion);
    }

    /**
     * Muestra la lista de camiones del usuario
     */
    public function index(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header("Location: ?menu=login");
            exit;
        }

        $camiones = $this->micamionmodel->obtenerPorUsuario($id_usuario);
        include "views/MiCamionView.php";
    }

    /**
     * Muestra el formulario para agregar un camión
     */
    public function crear(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header("Location: ?menu=login");
            exit;
        }

        $accion = 'crear';
        include "views/MiCamionView.php";
    }

    /**
     * Guarda un nuevo camión
     */
    public function guardar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $placa = $_POST['placa'] ?? '';
        $marca = $_POST['marca'] ?? '';
        $modelo = $_POST['modelo'] ?? '';
        $color = $_POST['color'] ?? '';
        $anio = $_POST['anio'] ?? '';

        // Validar campos
        if (empty($placa) || empty($marca) || empty($modelo) || empty($anio)) {
            echo json_encode(['exito' => false, 'mensaje' => 'Faltan campos requeridos']);
            exit;
        }

        if ($this->micamionmodel->guardar($id_usuario, $placa, $marca, $modelo, $color, $anio)) {
            logger($_SESSION['usuario_id'], "Registro de camión", "camiones", null, "Placa: $placa");
            echo json_encode(['exito' => true, 'mensaje' => 'Camión registrado correctamente']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al registrar el camión']);
        }
    }

    /**
     * Muestra el formulario para editar un camión
     */
    public function editar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header("Location: ?menu=login");
            exit;
        }

        $id_camion = $_GET['id'] ?? null;
        if (!$id_camion) {
            header("Location: ?menu=micamion");
            exit;
        }

        $camion = $this->micamionmodel->obtenerPorId($id_camion);
        if (!$camion || $camion['id_usuario'] != $id_usuario) {
            header("Location: ?menu=micamion");
            exit;
        }

        $accion = 'editar';
        include "views/MiCamionView.php";
    }

    /**
     * Actualiza un camión
     */
    public function actualizar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_camion = $_POST['id_camion'] ?? null;
        $marca = $_POST['marca'] ?? '';
        $modelo = $_POST['modelo'] ?? '';
        $color = $_POST['color'] ?? '';
        $anio = $_POST['anio'] ?? '';

        if (!$id_camion || empty($marca) || empty($modelo)) {
            echo json_encode(['exito' => false, 'mensaje' => 'Faltan campos requeridos']);
            exit;
        }

        $camion = $this->micamionmodel->obtenerPorId($id_camion);
        if (!$camion || $camion['id_usuario'] != $id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        if ($this->micamionmodel->actualizar($id_camion, $marca, $modelo, $color, $anio)) {
            logger($_SESSION['usuario_id'], "Actualización de camión", "camiones", $id_camion);
            echo json_encode(['exito' => true, 'mensaje' => 'Camión actualizado correctamente']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al actualizar el camión']);
        }
    }

    /**
     * Elimina un camión
     */
    public function eliminar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_camion = $_POST['id_camion'] ?? null;
        if (!$id_camion) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID de camión no especificado']);
            exit;
        }

        $camion = $this->micamionmodel->obtenerPorId($id_camion);
        if (!$camion || $camion['id_usuario'] != $id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        if ($this->micamionmodel->eliminar($id_camion)) {
            logger($_SESSION['usuario_id'], "Eliminacion de camión", "camiones", $id_camion);
            echo json_encode(['exito' => true, 'mensaje' => 'Camión eliminado correctamente']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al eliminar el camión']);
        }
    }
}
?>
