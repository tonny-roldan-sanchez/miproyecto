<?php
require_once __DIR__ . '/../models/Historial.php';

$historialModel = new HistorialModel();

// Procesar acciones CRUD enviadas desde la vista
$action = $_GET['action'] ?? null;

if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'fecha' => $_POST['fecha'] ?? null,
        'usuario' => $_POST['usuario'] ?? null,
        'accion' => $_POST['accion'] ?? null,
        'detalles' => $_POST['detalles'] ?? null,
    ];
    try {
        $historialModel->create($data);
    } catch (Exception $e) {
        error_log('Error creando historial: ' . $e->getMessage());
    }
    header('Location: index.php?menu=historial');
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $data = [
        'fecha' => $_POST['fecha'] ?? null,
        'usuario' => $_POST['usuario'] ?? null,
        'accion' => $_POST['accion'] ?? null,
        'detalles' => $_POST['detalles'] ?? null,
    ];
    try {
        $historialModel->update($id, $data);
    } catch (Exception $e) {
        error_log('Error actualizando historial: ' . $e->getMessage());
    }
    header('Location: index.php?menu=historial');
    exit;
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    try {
        $historialModel->delete($id);
    } catch (Exception $e) {
        error_log('Error eliminando historial: ' . $e->getMessage());
    }
    header('Location: index.php?menu=historial');
    exit;
}

// Consultar un registro (para llenar modal) — devuelve JSON si ajax=1
if ($action === 'find' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $row = $historialModel->find($id);
    if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
        header('Content-Type: application/json');
        echo json_encode($row ?: []);
        exit;
    }
}

// Antes de cargar la vista, obtener todos los registros para mostrar
$historial = [];
try {
    $historial = $historialModel->all();
} catch (Exception $e) {
    error_log('Error cargando historial: ' . $e->getMessage());
    $historial = [];
}

?>
