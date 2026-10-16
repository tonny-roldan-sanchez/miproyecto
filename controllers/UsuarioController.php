<?php
require_once 'models/UsuarioModel.php';

class UsuarioController
{
    private Usuario $modelo;

    public function __construct(PDO $db)
    {
        $this->modelo = new Usuario($db);
    }

    public function index(): void
    {
        try {
            $usuarios = $this->modelo->listar();

            $viewPath = APP_ROOT . '/views/UsuarioView.php';
            
            if (!file_exists($viewPath)) {
                throw new Exception("La vista '$viewPath' no se encuentra en el servidor.");
            }

            include $viewPath;
          
        } catch (Throwable $e) {
            logger("Error en UsuarioController::index -> " . $e->getMessage());
            abort(500);
        }  
    }

    public function crear(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php');
        }

        verify_csrf_token();

        $nombre = trim((string) ($_POST['nombre'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));

        if ($nombre !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->modelo->guardar($nombre, $email);
        }

        redirect('index.php');
    }

    public function borrar(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            abort(404);
        }

        verify_csrf_token();
        $this->modelo->eliminar($id);

        redirect('index.php');
    }

  
    public function editar(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf_token();

            $nombre = trim((string) ($_POST['nombre'] ?? ''));
            $email = trim((string) ($_POST['email'] ?? ''));

            if ($nombre !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->modelo->actualizar($id, $nombre, $email);
            }

            redirect('index.php');
        }

        // Si es GET, buscamos al usuario para llenar el formulario
        $usuario = $this->modelo->obtenerPorId($id);
        if (!$usuario) {
            redirect('index.php');
        }
    
        include APP_ROOT . '/views/editUsuario.php';
    }
}
