<?php
require_once 'models/MiEspacioModel.php';

class MiEspacioController {
    private $miespaciomodel;
    
    public function __construct($conexion) {
        $this->miespaciomodel = new MiEspacioModel($conexion);
    }

    /**
     * Muestra la lista de apartados del usuario
     */
    public function index(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header("Location: ?menu=login");
            exit;
        }

        $apartados = $this->miespaciomodel->obtenerPorUsuario($id_usuario);
        $estadisticas = $this->miespaciomodel->obtenerEstadisticas();
        include "views/MiEspacioview.php";
    }

    /**
     * Muestra el formulario para crear un apartado
     */
    public function crear(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header("Location: ?menu=login");
            exit;
        }

        $espacios_disponibles = $this->miespaciomodel->obtenerEspaciosDisponibles();
        $accion = 'crear';
        include "views/MiEspacioview.php";
    }

    /**
     * Guarda una nueva reserva
     */
    public function guardar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_espacio = $_POST['id_espacio'] ?? null;
        $id_camion = $_POST['id_camion'] ?? null;
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $precio_total = $_POST['precio_total'] ?? 0;

        // Validar
        if (!$id_espacio || !$id_camion || empty($fecha_inicio)) {
            echo json_encode(['exito' => false, 'mensaje' => 'Faltan campos requeridos']);
            exit;
        }

        if ($this->miespaciomodel->guardar($id_usuario, $id_espacio, $id_camion, $fecha_inicio, $fecha_fin, $precio_total)) {
            logger($_SESSION['usuario_id'], "Apartado de espacio", "apartados", null, "Espacio: $id_espacio");
            echo json_encode(['exito' => true, 'mensaje' => 'Espacio apartado correctamente']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al apartar el espacio']);
        }
    }

    /**
     * Muestra el formulario para editar un apartado
     */
    public function editar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header("Location: ?menu=login");
            exit;
        }

        $id_apartado = $_GET['id'] ?? null;
        if (!$id_apartado) {
            header("Location: ?menu=miespacio");
            exit;
        }

        $apartado = $this->miespaciomodel->obtenerPorId($id_apartado);
        if (!$apartado || $apartado['id_usuario'] != $id_usuario) {
            header("Location: ?menu=miespacio");
            exit;
        }

        $accion = 'editar';
        include "views/MiEspacioview.php";
    }

    /**
     * Actualiza un apartado
     */
    public function actualizar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_apartado = $_POST['id_apartado'] ?? null;
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $motivo = $_POST['motivo'] ?? '';

        if (!$id_apartado) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID de apartado no especificado']);
            exit;
        }

        $apartado = $this->miespaciomodel->obtenerPorId($id_apartado);
        if (!$apartado || $apartado['id_usuario'] != $id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        if ($this->miespaciomodel->actualizar($id_apartado, $fecha_fin, $motivo)) {
            logger($_SESSION['usuario_id'], "Actualizacion de apartado", "apartados", $id_apartado);
            echo json_encode(['exito' => true, 'mensaje' => 'Apartado actualizado correctamente']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al actualizar el apartado']);
        }
    }

    /**
     * Finaliza un apartado
     */
    public function finalizar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_apartado = $_POST['id_apartado'] ?? null;
        if (!$id_apartado) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID de apartado no especificado']);
            exit;
        }

        $apartado = $this->miespaciomodel->obtenerPorId($id_apartado);
        if (!$apartado || $apartado['id_usuario'] != $id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        if ($this->miespaciomodel->finalizar($id_apartado)) {
            logger($_SESSION['usuario_id'], "Finalizacion de apartado", "apartados", $id_apartado);
            echo json_encode(['exito' => true, 'mensaje' => 'Apartado finalizado correctamente']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al finalizar el apartado']);
        }
    }
}
?>
