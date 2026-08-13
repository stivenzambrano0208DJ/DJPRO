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
            $this->validateCsrf();
            // Procesar formulario
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $datos = [
                'nombre' => trim($_POST['nombre']),
                'username' => !empty(trim($_POST['username'] ?? '')) ? trim($_POST['username']) : null,
                'correo' => trim($_POST['correo']),
                'password' => trim($_POST['password']),
                'rol' => trim($_POST['rol']),
                'confirm_password' => trim($_POST['confirm_password']),
                'error' => ''
            ];

            // Validaciones simples
            if (empty($datos['nombre']) || empty($datos['correo']) || empty($datos['password'])) {
                $datos['error'] = 'Por favor llene todos los campos';
            } elseif ($datos['rol'] == 'dj' && empty($datos['username'])) {
                $datos['error'] = 'El nombre de usuario es obligatorio para DJs';
            } elseif (strlen($datos['password']) < 8) {
                $datos['error'] = 'La contraseña debe tener al menos 8 caracteres para mayor seguridad';
            } elseif (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
                $datos['error'] = 'Por favor ingrese un correo electrónico válido';
            } elseif ($datos['password'] != $datos['confirm_password']) {
                $datos['error'] = 'Las contraseñas no coinciden';
            } elseif (!empty($datos['username']) && !preg_match('/^[a-zA-Z0-9_]+$/', $datos['username'])) {
                $datos['error'] = 'El nombre de usuario solo puede contener letras, números y guiones bajos (sin espacios ni emojis)';
            } else {
                $usuarioExistente = $this->usuarioModel->buscarUsuarioPorCorreo($datos['correo']);
                if ($usuarioExistente) {
                    $datos['error'] = 'Este correo ya está registrado. No puedes crear otra cuenta (ni como Cliente ni como DJ) con el mismo correo. Por favor inicia sesión o usa otro correo.';
                }

                if (!empty($datos['username'])) {
                    $usernameExistente = $this->usuarioModel->buscarPorUsername($datos['username']);
                    if ($usernameExistente) {
                        $datos['error'] = 'Este nombre de usuario ya está en uso. Por favor elige otro.';
                    }
                }
            }

            if (empty($datos['error'])) {
                // Guardamos la contrasena en texto plano ANTES de cifrarla, para
                // poder sincronizar la cuenta con NeivActiva (misma clave en ambas).
                $passwordPlano = $datos['password'];

                // Hash Password
                $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);

                if ($this->usuarioModel->registrar($datos)) {
                    // Sincronizar la cuenta con NeivActiva (no debe bloquear el registro).
                    \Libraries\AccountSync::alRegistrar($datos['nombre'], $datos['correo'], $passwordPlano);

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
                    $_SESSION['flash_message'] = 'Error al registrar el usuario. Por favor intenta de nuevo.';
                    $_SESSION['flash_type'] = 'error';
                    $this->view('usuarios/registro', $datos);
                }
            } else {
                $this->view('usuarios/registro', $datos);
            }

        } else {
            // Mostrar vista
            $datos = [
                'nombre' => '',
                'username' => '',
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
            $this->validateCsrf();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
        // BUG-006: Regenerar ID de sesión para prevenir Session Fixation
        session_regenerate_id(true);

        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['usuario_nombre'] = $usuario->nombre;
        $_SESSION['usuario_username'] = $usuario->username;
        $_SESSION['usuario_correo'] = $usuario->correo;
        $_SESSION['usuario_rol'] = $usuario->rol;
        // Version de sesion para invalidacion por cambio de contrasena.
        $_SESSION['token_version'] = (int) ($usuario->token_version ?? 0);

        $this->redirigirPorRol();
    }

    private function redirigirPorRol() {
        if (isset($_SESSION['redirect_to'])) {
            $url = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']);
            
            // BUG-008: Validar que la URL sea interna y no contenga esquemas maliciosos
            if (!empty($url) && !preg_match('/^(http|https|ftp):\/\//i', $url) && strpos($url, '..') === false && strpos($url, ':') === false) {
                header('Location: ' . URL_ROOT . '/' . ltrim($url, '/'));
                exit;
            }
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

    // Olvidó su contraseña - Solicitar token
    public function recuperar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $email = trim($_POST['correo']);

            if (empty($email)) {
                $_SESSION['flash_message'] = 'Por favor ingrese su correo electrónico';
                $_SESSION['flash_type'] = 'warning';
                $this->view('usuarios/recuperar');
                return;
            }

            $usuario = $this->usuarioModel->buscarUsuarioPorCorreo($email);
            if ($usuario) {
                // Generar código de 6 dígitos
                $codigo = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                if ($this->usuarioModel->guardarTokenRecuperacion($email, $codigo)) {
                    if (EmailSender::enviarRecuperacion($email, $usuario->nombre, $codigo)) {
                        $_SESSION['flash_message'] = 'Se ha enviado un código de seguridad a tu correo.';
                        $_SESSION['flash_type'] = 'success';
                        
                        // Guardar email en sesión para el siguiente paso
                        $_SESSION['recuperar_email'] = $email;
                        header('Location: ' . URL_ROOT . '/usuarios/verificar_codigo');
                        exit;
                    } else {
                        $_SESSION['flash_message'] = 'Error al enviar el correo. Intente más tarde.';
                        $_SESSION['flash_type'] = 'error';
                    }
                }
            } else {
                // Por seguridad, no decimos si el correo existe o no
                $_SESSION['flash_message'] = 'Si el correo está registrado, recibirás un enlace pronto.';
                $_SESSION['flash_type'] = 'info';
            }
            header('Location: ' . URL_ROOT . '/usuarios/login');
            exit;
        } else {
            $this->view('usuarios/recuperar');
        }
    }

    // Nueva vista para verificar el código de 6 dígitos
    public function verificar_codigo() {
        if (!isset($_SESSION['recuperar_email'])) {
            header('Location: ' . URL_ROOT . '/usuarios/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $codigo = implode('', $_POST['codigo']); // Unir los 6 inputs
            
            $reset = $this->usuarioModel->validarTokenRecuperacion($codigo);
            if ($reset && $reset->email == $_SESSION['recuperar_email']) {
                // Código válido, ir a resetear pasándole el código como token
                header('Location: ' . URL_ROOT . '/usuarios/resetear/' . $codigo);
                exit;
            } else {
                $data = ['error' => 'El código ingresado es incorrecto o ha expirado.'];
                $this->view('usuarios/verificar_codigo', $data);
            }
        } else {
            $this->view('usuarios/verificar_codigo');
        }
    }

    // Resetear contraseña - Con el código verificado
    public function resetear($token) {
        $reset = $this->usuarioModel->validarTokenRecuperacion($token);
        if (!$reset || (isset($_SESSION['recuperar_email']) && $reset->email != $_SESSION['recuperar_email'])) {
            $_SESSION['flash_message'] = 'Sesión de recuperación no válida.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ' . URL_ROOT . '/usuarios/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $password = trim($_POST['password']);
            $confirm = trim($_POST['confirm_password']);

            if (empty($password) || strlen($password) < 8) {
                $data = ['token' => $token, 'error' => 'La contraseña debe tener al menos 8 caracteres'];
                $this->view('usuarios/resetear', $data);
            } elseif ($password != $confirm) {
                $data = ['token' => $token, 'error' => 'Las contraseñas no coinciden'];
                $this->view('usuarios/resetear', $data);
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                if ($this->usuarioModel->actualizarPassword($reset->email, $hashed)) {
                    // Cerrar todas las sesiones abiertas de esta cuenta en DJPRO.
                    $this->usuarioModel->incrementarTokenVersion($reset->email);

                    // Propagar el cambio de contrasena a NeivActiva (misma clave en ambas).
                    // AccountSync tambien invalida las sesiones abiertas alla.
                    \Libraries\AccountSync::alCambiarPassword($reset->email, $password);

                    $_SESSION['flash_message'] = 'Contraseña actualizada con éxito. Ya puedes iniciar sesión.';
                    $_SESSION['flash_type'] = 'success';
                    header('Location: ' . URL_ROOT . '/usuarios/login');
                    exit;
                }
            }
        } else {
            $data = ['token' => $token];
            $this->view('usuarios/resetear', $data);
        }
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
