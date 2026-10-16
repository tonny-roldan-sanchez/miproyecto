<?php
/**
 * Controlador para la gestión de respaldos de base de datos
 */
require_once __DIR__ . '/../functions.php';

class BackupController
{
    private $db;
    
    public function __construct()
    {
        require_once __DIR__ . '/../config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }

    private function obtenerConfiguracionBD()
    {
        $env = require __DIR__ . '/../env.php';

        return [
            'host' => $env['DB_HOST'],
            'user' => $env['DB_USER'],
            'pass' => $env['DB_PASS'],
            'dbname' => $env['DB_NAME'],
        ];
    }

    private function obtenerDirectorioRespaldos()
    {
        $dir = __DIR__ . '/../respaldos';

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $dir;
    }

    /**
     * Genera un respaldo (backup) de la base de datos
     */
    public function generarRespaldo()
    {
        try {
            $config = $this->obtenerConfiguracionBD();
            $dir = $this->obtenerDirectorioRespaldos();

            // Nombre del archivo con timestamp
            $timestamp = date('Y-m-d_H-i-s');
            $filename = 'respaldo_' . $config['dbname'] . '_' . $timestamp . '.sql';
            $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

            // Ruta de mysqldump (se intenta en varios lugares)
            $mysqldump = $this->obtenerMysqldump();
            if (!$mysqldump) {
                return [
                    'success' => false,
                    'message' => 'Error: mysqldump no se encuentra en el servidor'
                ];
            }

            // Comando para exportar la base de datos
            $command = escapeshellarg($mysqldump) . ' --host=' . escapeshellarg($config['host']) . ' --user=' . escapeshellarg($config['user']);

            // Agregar contraseña si existe
            if (!empty($config['pass'])) {
                $command .= ' --password=' . escapeshellarg($config['pass']);
            }

            $command .= ' ' . escapeshellarg($config['dbname']) . ' > ' . escapeshellarg($filepath) . ' 2>&1';

            // Ejecutar el comando
            $output = [];
            $result_code = 0;
            exec($command, $output, $result_code);

            if ($result_code !== 0) {
                $error_msg = implode(' ', $output);
                return [
                    'success' => false,
                    'message' => 'Error: ' . ($error_msg ? substr($error_msg, 0, 200) : 'No se pudo generar el respaldo'),
                ];
            }

            // Verificar que el archivo existe y tiene contenido
            if (!file_exists($filepath) || filesize($filepath) === 0) {
                return [
                    'success' => false,
                    'message' => 'Error: El archivo de respaldo no fue creado correctamente'
                ];
            }

            return [
                'success' => true,
                'message' => 'Respaldo generado exitosamente',
                'filename' => 'respaldos/' . $filename,
                'file' => 'respaldos/' . $filename
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    private function obtenerMysqldump()
    {
        // Buscar mysqldump en Laragon
        $paths = [
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-5.7.26-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mariadb-10.5.8-winx64\\bin\\mysqldump.exe',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Lista los respaldos disponibles en la carpeta de respaldos
     */
    public function listarRespaldos()
    {
        try {
            $dir = $this->obtenerDirectorioRespaldos();
            $files = [];

            if (!is_dir($dir)) {
                return $files;
            }

            $items = scandir($dir);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }

                $filepath = $dir . DIRECTORY_SEPARATOR . $item;
                if (!is_file($filepath) || pathinfo($filepath, PATHINFO_EXTENSION) !== 'sql') {
                    continue;
                }

                $files[] = [
                    'name' => $item,
                    'path' => 'respaldos/' . $item,
                    'size' => filesize($filepath),
                    'modified' => date('Y-m-d H:i:s', filemtime($filepath))
                ];
            }

            usort($files, function ($a, $b) {
                return strcmp($b['name'], $a['name']);
            });

            return $files;
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Importa un respaldo (backup) desde un archivo SQL
     */
    public function importarRespaldo($filePath)
    {
        try {
            // Verificar que el archivo existe
            if (!file_exists($filePath)) {
                return [
                    'success' => false,
                    'message' => 'El archivo no existe'
                ];
            }
            
            // Verificar que es un archivo .sql
            if (pathinfo($filePath, PATHINFO_EXTENSION) !== 'sql') {
                return [
                    'success' => false,
                    'message' => 'Solo se permiten archivos .sql'
                ];
            }
            
            $config = $this->obtenerConfiguracionBD();
            
            // Obtener ruta de mysql
            $mysql = $this->obtenerMysql();
            if (!$mysql) {
                return [
                    'success' => false,
                    'message' => 'Error: mysql no se encuentra en el servidor'
                ];
            }
            
            // Comando para importar la base de datos
            $command = escapeshellarg($mysql) . ' --host=' . escapeshellarg($config['host']) . ' --user=' . escapeshellarg($config['user']);
            
            // Agregar contraseña si existe
            if (!empty($config['pass'])) {
                $command .= ' --password=' . escapeshellarg($config['pass']);
            }
            
            $command .= ' ' . escapeshellarg($config['dbname']) . ' < ' . escapeshellarg($filePath) . ' 2>&1';
            
            // Ejecutar el comando
            $output = [];
            $result_code = 0;
            exec($command, $output, $result_code);
            
            if ($result_code !== 0) {
                $error_msg = implode(' ', $output);
                return [
                    'success' => false,
                    'message' => 'Error: ' . ($error_msg ? substr($error_msg, 0, 200) : 'Error al importar el respaldo')
                ];
            }
            
            return [
                'success' => true,
                'message' => 'Respaldo importado exitosamente'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    private function obtenerMysql()
    {
        // Buscar mysql en Laragon
        $paths = [
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysql.exe',
            'C:\\laragon\\bin\\mysql\\mysql-5.7.26-winx64\\bin\\mysql.exe',
            'C:\\laragon\\bin\\mysql\\mariadb-10.5.8-winx64\\bin\\mysql.exe',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Obtiene un archivo de respaldo para descargar
     */
    public function descargarRespaldo($filename)
    {
        try {
            $projectRoot = realpath(__DIR__ . '/..');
            $backupDir = $projectRoot . DIRECTORY_SEPARATOR . 'respaldos';

            if (!is_dir($backupDir)) {
                return [
                    'success' => false,
                    'message' => 'No existe el directorio de respaldos'
                ];
            }

            if (strpos($filename, DIRECTORY_SEPARATOR) === false) {
                $candidate = $backupDir . DIRECTORY_SEPARATOR . $filename;
            } else if ($filename[0] === DIRECTORY_SEPARATOR || preg_match('/^[A-Za-z]:\\/', $filename)) {
                $candidate = $filename;
            } else {
                $candidate = $projectRoot . DIRECTORY_SEPARATOR . $filename;
            }

            $resolvedPath = realpath($candidate);

            if ($resolvedPath === false || !is_file($resolvedPath)) {
                return [
                    'success' => false,
                    'message' => 'El archivo no existe'
                ];
            }

            $backupDirReal = realpath($backupDir);
            if ($backupDirReal === false || strpos($resolvedPath, $backupDirReal) !== 0) {
                return [
                    'success' => false,
                    'message' => 'Nombre de archivo inválido'
                ];
            }
            
            // Limpiar buffers antes de enviar archivo binario
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            // Descargar el archivo
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($resolvedPath) . '"');
            header('Content-Length: ' . filesize($resolvedPath));
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');
            readfile($resolvedPath);
            exit;
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}
?>
