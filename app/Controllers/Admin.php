<?php
/**
 * Controlador de Administración
 */
class Admin extends Core\Controller {
    private $usuarioModel;
    private $contratacionModel;
    private $db;

    public function __construct() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin') {
            header('Location: ' . URL_ROOT . '/usuarios/login');
            exit;
        }
        $this->usuarioModel = $this->model('Usuario');
        $this->db = new Database();
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $contratacionModel = $this->model('Contratacion');
        
        $totalDjs = $this->usuarioModel->contarPorRol('dj');
        $totalClientes = $this->usuarioModel->contarPorRol('cliente');
        $totalEventos = $this->usuarioModel->contarContrataciones();
        
        // Obtener estadísticas globales desde el modelo
        $stats = $contratacionModel->obtenerEstadisticasGlobales();
        
        $proyeccion = $contratacionModel->obtenerProyeccionMensual();
        $usuariosRecientes = $this->usuarioModel->obtenerUsuariosRecientes(5);

        $datos = [
            'total_djs' => $totalDjs,
            'total_clientes' => $totalClientes,
            'total_eventos' => $totalEventos,
            'volumen_negocio' => $stats['volumen'],
            'metricas_estado' => $stats['estados'],
            'proyeccion_mensual' => $proyeccion,
            'usuarios_recientes' => $usuariosRecientes
        ];

        $this->view('admin/dashboard', $datos);
    }

    public function usuarios() {
        $usuarios = $this->usuarioModel->obtenerTodos();
        $datos = ['usuarios' => $usuarios];
        $this->view('admin/usuarios', $datos);
    }

    public function reservas() {
        $contratacionModel = $this->model('Contratacion');
        $reservas = $contratacionModel->obtenerTodas();
        $datos = ['reservas' => $reservas];
        $this->view('admin/reservas', $datos);
    }

    public function editar_usuario($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $datos = [
                'id' => $id,
                'nombre' => trim($_POST['nombre']),
                'correo' => trim($_POST['correo']),
                'rol' => trim($_POST['rol'])
            ];

            if ($this->usuarioModel->actualizar($datos)) {
                $_SESSION['flash_message'] = 'Usuario actualizado correctamente.';
                header('Location: ' . URL_ROOT . '/admin/usuarios');
            } else {
                $_SESSION['flash_message'] = 'No se pudo actualizar el usuario.';
                $_SESSION['flash_type'] = 'error';
                header('Location: ' . URL_ROOT . '/admin/usuarios');
            }
        } else {
            $usuario = $this->usuarioModel->buscarPorId($id);
            $datos = ['usuario' => $usuario];
            $this->view('admin/editar_usuario', $datos);
        }
    }

    public function eliminar_usuario($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            if ($this->usuarioModel->eliminar($id)) {
                $_SESSION['flash_message'] = 'Usuario eliminado correctamente.';
                header('Location: ' . URL_ROOT . '/admin/usuarios');
            } else {
                $_SESSION['flash_message'] = 'No se pudo eliminar el usuario.';
                $_SESSION['flash_type'] = 'error';
                header('Location: ' . URL_ROOT . '/admin/usuarios');
            }
        }
    }

    public function verificar_dj($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $this->db->query('UPDATE usuarios SET verificado = 1 WHERE id = :id AND rol = "dj"');
            $this->db->bind(':id', $id);
            
            if ($this->db->execute()) {
                $_SESSION['flash_message'] = 'DJ verificado con éxito.';
            }
            header('Location: ' . URL_ROOT . '/admin/usuarios');
            exit;
        }
    }

    public function desverificar_dj($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $this->db->query('UPDATE usuarios SET verificado = 0 WHERE id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();
            header('Location: ' . URL_ROOT . '/admin/usuarios');
            exit;
        }
    }

    public function resenas() {
        $this->db->query('SELECT r.*, u.nombre as cliente_nombre, u2.nombre as dj_nombre 
                          FROM resenas r 
                          JOIN contrataciones c ON r.contratacion_id = c.id
                          JOIN usuarios u ON c.cliente_id = u.id
                          JOIN usuarios u2 ON c.dj_id = u2.id
                          ORDER BY r.fecha_creacion DESC');
        $resenas = $this->db->resultSet();
        $datos = ['resenas' => $resenas];
        $this->view('admin/resenas', $datos);
    }

    public function eliminar_resena($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $this->db->query('DELETE FROM resenas WHERE id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();
            $_SESSION['flash_message'] = 'Reseña eliminada.';
            header('Location: ' . URL_ROOT . '/admin/resenas');
            exit;
        }
    }

    public function seguridad() {
        $djs = $this->usuarioModel->obtenerDjsConCredenciales();
        $datos = ['djs' => $djs];
        $this->view('admin/seguridad', $datos);
    }

    public function actualizar_credenciales() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $id = $_POST['usuario_id'];
            $username = trim($_POST['username']);
            $correo = trim($_POST['correo']);
            $password = $_POST['password'];

            $datos = [
                'id' => $id,
                'username' => $username,
                'correo' => $correo
            ];

            if (!empty($password)) {
                $datos['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            if ($this->usuarioModel->actualizarMaster($datos)) {
                $_SESSION['flash_message'] = 'Credenciales actualizadas.';
            } else {
                $_SESSION['flash_message'] = 'Error al actualizar.';
                $_SESSION['flash_type'] = 'error';
            }
            header('Location: ' . URL_ROOT . '/admin/seguridad');
            exit;
        }
    }

    public function api_recent_users() {
        header('Content-Type: application/json');
        $usuariosRecientes = $this->usuarioModel->obtenerUsuariosRecientes(10);
        
        echo json_encode([
            'usuarios' => $usuariosRecientes,
            'timestamp' => date('H:i:s')
        ]);
        exit;
    }
}
