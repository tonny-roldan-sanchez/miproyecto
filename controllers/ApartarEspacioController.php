<?php
declare(strict_types=1);

class ApartarEspacioController
{
    private ApartarEspacioModel $model;

    public function __construct()
    {
        $this->model = new ApartarEspacioModel();
    }

    /**
     * Obtiene todos los espacios apartados
     */
    public function obtenerTodos(): array
    {
        return $this->model->getAll();
    }

    /**
     * Obtiene un espacio apartado por ID
     */
    public function obtenerPorId(int $id): ?array
    {
        return $this->model->getById($id);
    }

    /**
     * Crea un nuevo espacio apartado
     */
    public function crear(array $datos): array
    {
        // Validaciones básicas
        if (empty($datos['folio'])) {
            return ['success' => false, 'mensaje' => 'El folio es requerido.'];
        }

        if (empty($datos['estado'])) {
            return ['success' => false, 'mensaje' => 'El estado es requerido.'];
        }

        if ($this->model->create($datos)) {
            return ['success' => true, 'mensaje' => 'Espacio apartado creado correctamente.'];
        }

        return ['success' => false, 'mensaje' => 'Error al crear el espacio apartado.'];
    }

    /**
     * Actualiza un espacio apartado
     */
    public function actualizar(int $id, array $datos): array
    {
        // Validar que el espacio exista
        if (!$this->model->getById($id)) {
            return ['success' => false, 'mensaje' => 'Espacio apartado no encontrado.'];
        }

        if (empty($datos['folio'])) {
            return ['success' => false, 'mensaje' => 'El folio es requerido.'];
        }

        if ($this->model->update($id, $datos)) {
            return ['success' => true, 'mensaje' => 'Espacio apartado actualizado correctamente.'];
        }

        return ['success' => false, 'mensaje' => 'Error al actualizar el espacio apartado.'];
    }

    /**
     * Elimina un espacio apartado
     */
    public function eliminar(int $id): array
    {
        // Validar que el espacio exista
        if (!$this->model->getById($id)) {
            return ['success' => false, 'mensaje' => 'Espacio apartado no encontrado.'];
        }

        if ($this->model->delete($id)) {
            return ['success' => true, 'mensaje' => 'Espacio apartado eliminado correctamente.'];
        }

        return ['success' => false, 'mensaje' => 'Error al eliminar el espacio apartado.'];
    }

    /**
     * Obtiene el siguiente folio
     */
    public function getSiguienteFolio(): string
    {
        return $this->model->getSiguienteFolio();
    }

    /**
     * Procesa las acciones POST del formulario
     */
    public function procesarFormulario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        verify_csrf_token();

        $accion = $_POST['accion'] ?? '';
        $respuesta = null;

        switch ($accion) {
            case 'crear':
                $respuesta = $this->crear($_POST);
                break;
            case 'actualizar':
                $id = (int)($_POST['id_apartado'] ?? 0);
                $respuesta = $this->actualizar($id, $_POST);
                break;
            case 'eliminar':
                $id = (int)($_POST['id_apartado'] ?? 0);
                $respuesta = $this->eliminar($id);
                break;
        }

        if ($respuesta) {
            $_SESSION['mensaje'] = $respuesta['mensaje'];
            $_SESSION['tipo_mensaje'] = $respuesta['success'] ? 'success' : 'error';
            redirect('index.php?menu=apartarespacio');
        }
    }
}
