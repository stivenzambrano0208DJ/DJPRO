<?php
/**
 * Controlador de Administración
 */
class Admin extends Core\Controller {
    private $usuarioModel;
    private $contratacionModel;

    public function __construct() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin') {
            header('Location: ' . URL_ROOT . '/usuarios/login');
            exit;
        }
        $this->usuarioModel = $this->model('Usuario');
        // $this->contratacionModel = $this->model('Contratacion');
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $totalDjs = $this->usuarioModel->contarPorRol('dj');
        $totalClientes = $this->usuarioModel->contarPorRol('cliente');
        $totalEventos = $this->usuarioModel->contarContrataciones();
        $usuariosRecientes = $this->usuarioModel->obtenerUsuariosRecientes(5);

        $datos = [
            'total_djs' => $totalDjs,
            'total_clientes' => $totalClientes,
            'total_eventos' => $totalEventos,
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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
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
                die('Algo salió mal');
            }
        } else {
            $usuario = $this->usuarioModel->buscarPorId($id);
            $datos = ['usuario' => $usuario];
            $this->view('admin/editar_usuario', $datos);
        }
    }

    public function eliminar_usuario($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->usuarioModel->eliminar($id)) {
                $_SESSION['flash_message'] = 'Usuario eliminado correctamente.';
                header('Location: ' . URL_ROOT . '/admin/usuarios');
            } else {
                die('Algo salió mal');
            }
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
