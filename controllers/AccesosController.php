<?php
require_once 'models/AccesosModel.php';

class AccesosController {
    private $accesosmodel;
    
    public function __construct($conexion) {
        $this->accesosmodel = new AccesosModel($conexion);
    }

    /**
     * Muestra el historial de accesos del usuario
     */
    public function index(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header("Location: ?menu=login");
            exit;
        }

        $accesos = $this->accesosmodel->obtenerPorUsuario($id_usuario);
        $estadisticas = $this->accesosmodel->obtenerEstadisticas($id_usuario);
        $accesos_hoy = $this->accesosmodel->obtenerDelDia($id_usuario);
        include "views/Accesosview.php";
    }

    /**
     * Registra una entrada o salida
     */
    public function registrar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_camion = $_POST['id_camion'] ?? null;
        $tipo = $_POST['tipo'] ?? 'entrada'; // entrada o salida
        $observaciones = $_POST['observaciones'] ?? null;

        // Validar
        if (!$id_camion) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID de camion no especificado']);
            exit;
        }

        if (!in_array($tipo, ['entrada', 'salida'])) {
            echo json_encode(['exito' => false, 'mensaje' => 'Tipo de acceso inválido']);
            exit;
        }

        if ($this->accesosmodel->guardar($id_usuario, $id_camion, $tipo, $observaciones)) {
            logger($_SESSION['usuario_id'], "Registro de $tipo", "accesos", $id_camion);
            echo json_encode([
                'exito' => true, 
                'mensaje' => ucfirst($tipo) . ' registrada correctamente',
                'tipo' => $tipo
            ]);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al registrar el acceso']);
        }
    }

    /**
     * Obtiene el acceso más reciente de un camión
     */
    public function obtenerUltimo(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_camion = $_GET['id_camion'] ?? null;
        if (!$id_camion) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID de camion no especificado']);
            exit;
        }

        $acceso = $this->accesosmodel->obtenerUltimo($id_camion);
        if ($acceso) {
            echo json_encode(['exito' => true, 'data' => $acceso]);
        } else {
            echo json_encode(['exito' => true, 'data' => null, 'mensaje' => 'Sin registros']);
        }
    }

    /**
     * Obtiene accesos del día
     */
    public function obtenerDelDia(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $accesos = $this->accesosmodel->obtenerDelDia($id_usuario);
        echo json_encode(['exito' => true, 'data' => $accesos]);
    }

    /**
     * Obtiene accesos de un camión
     */
    public function obtenerPorCamion(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_camion = $_GET['id_camion'] ?? null;
        if (!$id_camion) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID de camion no especificado']);
            exit;
        }

        $accesos = $this->accesosmodel->obtenerPorCamion($id_camion);
        echo json_encode(['exito' => true, 'data' => $accesos]);
    }
}
?>
