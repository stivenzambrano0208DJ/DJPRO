<?php
/**
 * Controlador de Usuarios (Auth)
 */
use Libraries\EmailSender;

class Usuarios extends Core\Controller {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = $this->model('Usuario');
    }

    public function index() {
        $this->login();
    }

    public function registro() {
        if (isset($_SESSION['usuario_id'])) {
            $this->redirigirPorRol();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesar formulario
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $datos = [
                'nombre' => trim($_POST['nombre']),
                'correo' => trim($_POST['correo']),
                'password' => trim($_POST['password']),
                'rol' => trim($_POST['rol']),
                'confirm_password' => trim($_POST['confirm_password']),
                'error' => ''
            ];

            // Validaciones simples
            if (empty($datos['nombre']) || empty($datos['correo']) || empty($datos['password'])) {
                $datos['error'] = 'Por favor llene todos los campos';
            } elseif ($datos['password'] != $datos['confirm_password']) {
                $datos['error'] = 'Las contraseñas no coinciden';
            } else {
                $usuarioExistente = $this->usuarioModel->buscarUsuarioPorCorreo($datos['correo']);
                if ($usuarioExistente) {
                    $datos['error'] = 'Este correo ya está registrado. No puedes crear otra cuenta (ni como Cliente ni como DJ) con el mismo correo. Por favor inicia sesión o usa otro correo.';
                }
            }

            if (empty($datos['error'])) {
                // Hash Password
                $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);

                if ($this->usuarioModel->registrar($datos)) {
                    // Enviar correo de bienvenida
                    EmailSender::enviarBienvenida($datos['correo'], $datos['nombre']);

                    // Guardar mensaje de éxito para mostrar en la siguiente página
                    $_SESSION['flash_message'] = '¡Registro exitoso! Se ha enviado una notificación a tu correo electrónico (' . $datos['correo'] . ').';

                    // Obtener el usuario recién registrado para iniciar sesión
                    $usuarioNuevo = $this->usuarioModel->buscarUsuarioPorCorreo($datos['correo']);
                    if ($usuarioNuevo) {
                        $this->crearSesionUsuario($usuarioNuevo);
                    } else {
                        header('Location: ' . URL_ROOT . '/usuarios/login');
                    }
                } else {
                    die('Algo salió mal');
                }
            } else {
                $this->view('usuarios/registro', $datos);
            }

        } else {
            // Mostrar vista
            $datos = [
                'nombre' => '',
                'correo' => '',
                'password' => '',
                'confirm_password' => '',
                'rol' => 'cliente',
                'error' => ''
            ];
            $this->view('usuarios/registro', $datos);
        }
    }

    public function login() {
        if (isset($_SESSION['usuario_id'])) {
            $this->redirigirPorRol();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $datos = [
                'correo' => trim($_POST['correo']),
                'password' => trim($_POST['password']),
                'redirect' => trim($_POST['redirect'] ?? ''),
                'error' => ''
            ];

            $usuarioLogueado = $this->usuarioModel->login($datos['correo'], $datos['password']);

            if ($usuarioLogueado) {
                // Guardar redirect en sesión temporalmente
                if (!empty($datos['redirect'])) {
                    $_SESSION['redirect_to'] = $datos['redirect'];
                }
                // Crear sesión
                $this->crearSesionUsuario($usuarioLogueado);
            } else {
                $datos['error'] = 'Correo o contraseña incorrectos';
                $this->view('usuarios/login', $datos);
            }

        } else {
            $datos = [
                'correo' => '',
                'password' => '',
                'redirect' => $_GET['redirect'] ?? '',
                'error' => ''
            ];
            $this->view('usuarios/login', $datos);
        }
    }

    public function crearSesionUsuario($usuario) {
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nombre'] = $usuario->nombre;
        $_SESSION['usuario_correo'] = $usuario->correo;
        $_SESSION['usuario_rol'] = $usuario->rol;

        $this->redirigirPorRol();
    }

    private function redirigirPorRol() {
        if (isset($_SESSION['redirect_to'])) {
            $url = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']);
            header('Location: ' . URL_ROOT . '/' . $url);
            exit;
        }

        if ($_SESSION['usuario_rol'] == 'dj') {
            header('Location: ' . URL_ROOT . '/djs/dashboard');
        } elseif ($_SESSION['usuario_rol'] == 'admin') {
            header('Location: ' . URL_ROOT . '/admin/dashboard');
        } else {
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
        }
        exit;
    }

    public function logout() {
        unset($_SESSION['usuario_id']);
        unset($_SESSION['usuario_nombre']);
        unset($_SESSION['usuario_correo']);
        unset($_SESSION['usuario_rol']);
        session_destroy();
        header('Location: ' . URL_ROOT . '/usuarios/login');
    }
}
