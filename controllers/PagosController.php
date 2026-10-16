<?php
require_once 'models/PagosModel.php';

class PagosController {
    private $pagosmodel;
    
    public function __construct($conexion) {
        $this->pagosmodel = new PagosModel($conexion);
    }

    /**
     * Muestra la lista de pagos del usuario
     */
    public function index(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header("Location: ?menu=login");
            exit;
        }

        $pagos = $this->pagosmodel->obtenerPorUsuario($id_usuario);
        $resumen = $this->pagosmodel->obtenerResumen($id_usuario);
        include "views/PagosView.php";
    }

    /**
     * Obtiene pagos pendientes del usuario
     */
    public function pendientes(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $pagos = $this->pagosmodel->obtenerPendientes($id_usuario);
        echo json_encode(['exito' => true, 'data' => $pagos]);
    }

    /**
     * Muestra el formulario para crear un pago
     */
    public function crear(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header("Location: ?menu=login");
            exit;
        }

        $accion = 'crear';
        include "views/PagosView.php";
    }

    /**
     * Guarda un nuevo pago
     */
    public function guardar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_apartado = $_POST['id_apartado'] ?? null;
        $monto = $_POST['monto'] ?? 0;
        $concepto = $_POST['concepto'] ?? '';
        $metodo_pago = $_POST['metodo_pago'] ?? 'efectivo';
        $fecha_vencimiento = $_POST['fecha_vencimiento'] ?? null;

        // Validar
        if (!$id_apartado || $monto <= 0 || empty($concepto)) {
            echo json_encode(['exito' => false, 'mensaje' => 'Faltan campos requeridos']);
            exit;
        }

        if ($this->pagosmodel->guardar($id_usuario, $id_apartado, $monto, $concepto, $metodo_pago, $fecha_vencimiento)) {
            logger($_SESSION['usuario_id'], "Registro de pago", "pagos", null, "Monto: $monto");
            echo json_encode(['exito' => true, 'mensaje' => 'Pago registrado correctamente']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al registrar el pago']);
        }
    }

    /**
     * Marca un pago como pagado
     */
    public function marcarPagado(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_pago = $_POST['id_pago'] ?? null;
        $metodo_pago = $_POST['metodo_pago'] ?? 'efectivo';
        $referencia = $_POST['referencia'] ?? null;

        if (!$id_pago) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID de pago no especificado']);
            exit;
        }

        $pago = $this->pagosmodel->obtenerPorId($id_pago);
        if (!$pago || $pago['id_usuario'] != $id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        if ($this->pagosmodel->marcarPagado($id_pago, $metodo_pago, $referencia)) {
            logger($_SESSION['usuario_id'], "Pago realizado", "pagos", $id_pago);
            echo json_encode(['exito' => true, 'mensaje' => 'Pago registrado correctamente']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al registrar el pago']);
        }
    }

    /**
     * Rechaza un pago
     */
    public function rechazar(): void {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        $id_pago = $_POST['id_pago'] ?? null;
        if (!$id_pago) {
            echo json_encode(['exito' => false, 'mensaje' => 'ID de pago no especificado']);
            exit;
        }

        $pago = $this->pagosmodel->obtenerPorId($id_pago);
        if (!$pago || $pago['id_usuario'] != $id_usuario) {
            echo json_encode(['exito' => false, 'mensaje' => 'No autorizado']);
            exit;
        }

        if ($this->pagosmodel->rechazar($id_pago)) {
            logger($_SESSION['usuario_id'], "Rechazo de pago", "pagos", $id_pago);
            echo json_encode(['exito' => true, 'mensaje' => 'Pago rechazado']);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Error al rechazar el pago']);
        }
    }
}
?>
