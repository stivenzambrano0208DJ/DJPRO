<?php
/**
 * Controlador de DJs
 */
class Djs extends Core\Controller {
    private $djModel;
    private $contratacionModel;
    private $usuarioModel;
    private $resenaModel;

    public function __construct() {
        $this->djModel = $this->model('Dj');
        $this->contratacionModel = $this->model('Contratacion');
        $this->usuarioModel = $this->model('Usuario');
        $this->resenaModel = $this->model('Resena');

        // Obtener el método actual de la URL
        $url = isset($_GET['url']) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : [];
        $method = $url[1] ?? 'index';

        // Definir métodos públicos
        $publicMethods = ['perfil', 'explorar'];

        // Solo proteger métodos que no sean públicos
        if (!in_array($method, $publicMethods)) {
            if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'dj') {
                header('Location: ' . URL_ROOT . '/usuarios/login');
                exit;
            }
        }
    }

    public function explorar() {
        // Capturar filtros
        $filtros = [
            'ciudad' => $_GET['ciudad'] ?? '',
            'genero' => $_GET['genero'] ?? '',
            'evento' => $_GET['evento'] ?? ''
        ];

        $djs = $this->usuarioModel->obtenerDjsConPerfil($filtros);
        $generos = $this->usuarioModel->obtenerGeneros();
        $tiposEvento = $this->usuarioModel->obtenerTiposEvento();
        
        $datos = [
            'djs' => $djs,
            'generos' => $generos,
            'tipos_evento' => $tiposEvento,
            'filtros' => $filtros // Para persistir en la vista
        ];

        if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_rol'] == 'dj') {
            $datos['perfil'] = $this->djModel->obtenerPerfil($_SESSION['usuario_id']);
        }
        
        $this->view('clientes/explorar', $datos);
    }

    public function perfil($id) {
        $perfil = $this->djModel->obtenerPerfil($id);
        if (!$perfil) {
            header('Location: ' . URL_ROOT . '/pages/index');
            exit;
        }
        $videos = $this->djModel->obtenerVideos($id);
        $resenas = $this->resenaModel->obtenerPorDj($id);
        
        $datos = [
            'perfil' => $perfil,
            'videos' => $videos,
            'resenas' => $resenas
        ];
        $this->view('djs/perfil', $datos);
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $perfil = $this->djModel->obtenerPerfil($_SESSION['usuario_id']);
        $videos = $this->djModel->obtenerVideos($_SESSION['usuario_id']);
        $contrataciones = $this->contratacionModel->obtenerPorDj($_SESSION['usuario_id']);
        $stats = $this->djModel->obtenerEstadisticas($_SESSION['usuario_id']);
        
        $datos = [
            'perfil' => $perfil,
            'videos' => $videos,
            'contrataciones' => $contrataciones,
            'stats' => $stats
        ];
        $this->view('djs/panel', $datos);
    }

    public function estadisticas() {
        $perfil = $this->djModel->obtenerPerfil($_SESSION['usuario_id']);
        $stats = $this->djModel->obtenerEstadisticas($_SESSION['usuario_id']);
        $proyeccion = $this->djModel->obtenerProyeccionMensual($_SESSION['usuario_id']);
        $contrataciones = $this->contratacionModel->obtenerPorDj($_SESSION['usuario_id']);

        // Calcular métricas adicionales desde las contrataciones
        $pendientes  = 0;
        $canceladas  = 0;
        $ticket_sum  = 0;
        $ticket_count = 0;
        foreach ($contrataciones as $c) {
            if ($c->estado === 'pendiente') $pendientes++;
            if (in_array($c->estado, ['cancelada', 'rechazada'])) $canceladas++;
            if (in_array($c->estado, ['terminada', 'completada'])) {
                $ticket_sum += $c->precio_total;
                $ticket_count++;
            }
        }
        $ticket_promedio = $ticket_count > 0 ? $ticket_sum / $ticket_count : 0;
        
        $datos = [
            'perfil'          => $perfil,
            'stats'           => $stats,
            'proyeccion'      => $proyeccion,
            'pendientes'      => $pendientes,
            'canceladas'      => $canceladas,
            'ticket_promedio' => $ticket_promedio,
        ];
        $this->view('djs/estadisticas', $datos);
    }

    public function editar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $datos = [
                'usuario_id' => $_SESSION['usuario_id'],
                'username' => trim($_POST['username'] ?? ''),
                'biografia' => trim($_POST['biografia'] ?? ''),
                'lugares_trabajo' => !empty($_POST['lugares_trabajo']) ? (is_array($_POST['lugares_trabajo']) ? implode(',', $_POST['lugares_trabajo']) : $_POST['lugares_trabajo']) : '',
                'ciudad' => trim($_POST['ciudad'] ?? ''),
                'departamento' => trim($_POST['departamento'] ?? ''),
                'generos' => !empty($_POST['generos']) ? (is_array($_POST['generos']) ? implode(',', $_POST['generos']) : $_POST['generos']) : '',
                'eventos' => !empty($_POST['eventos']) ? (is_array($_POST['eventos']) ? implode(',', $_POST['eventos']) : $_POST['eventos']) : '',
                'precio_hora' => !empty($_POST['precio_hora']) ? $_POST['precio_hora'] : null,
                'auto_respuesta' => trim($_POST['auto_respuesta'] ?? ''),
                'bot_activo' => isset($_POST['bot_activo']) ? 1 : 0,
                'foto_perfil' => '',
                'success' => '',
                'error' => ''
            ];

            // Validar username
            if (!empty($datos['username'])) {
                if (!preg_match('/^[a-zA-Z0-9_]+$/', $datos['username'])) {
                    $datos['error'] = 'El nombre de usuario solo puede contener letras, números y guiones bajos (sin espacios ni emojis)';
                } else {
                    $usernameExistente = $this->usuarioModel->buscarPorUsername($datos['username']);
                    if ($usernameExistente && $usernameExistente->id != $_SESSION['usuario_id']) {
                        $datos['error'] = 'Este nombre de usuario ya está en uso por otro DJ.';
                    }
                }
            }

            // Manejo de subida de archivos
            if (!empty($_FILES['foto_perfil']['name'])) {
                $nombreArchivo = $_FILES['foto_perfil']['name'];
                $tempArchivo = $_FILES['foto_perfil']['tmp_name'];
                $errorArchivo = $_FILES['foto_perfil']['error'];
                $tamanoArchivo = $_FILES['foto_perfil']['size'];
                $tipoArchivo = $_FILES['foto_perfil']['type'];

                if ($errorArchivo === 0) {
                    // Validar Tamaño (Máximo 2MB)
                    if ($tamanoArchivo > 2 * 1024 * 1024) {
                        $datos['error'] = 'El archivo es demasiado grande (Máximo 2MB)';
                    } else {
                        $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                        $extLower = strtolower($ext);
                        $extPermitidas = ['jpg', 'jpeg', 'png'];
                        $tiposMIME = ['image/jpeg', 'image/jpg', 'image/png'];

                        if (in_array($extLower, $extPermitidas) && in_array($tipoArchivo, $tiposMIME)) {
                            $nuevoNombre = uniqid('dj_', true) . '.' . $extLower;
                            $destino = APPROOT . '/public/assets/uploads/' . $nuevoNombre;

                            if (move_uploaded_file($tempArchivo, $destino)) {
                                $datos['foto_perfil'] = $nuevoNombre;
                            } else {
                                $datos['error'] = 'Error al guardar la imagen en el servidor. Verifica los permisos.';
                            }
                        } else {
                            $datos['error'] = 'Solo se permiten imágenes reales (JPG, JPEG o PNG)';
                        }
                    }
                } else {
                    $uploadErrors = [
                        UPLOAD_ERR_INI_SIZE => 'La imagen excede el límite de peso permitido por el servidor.',
                        UPLOAD_ERR_FORM_SIZE => 'La imagen excede el límite de peso del formulario.',
                        UPLOAD_ERR_PARTIAL => 'La imagen se subió parcialmente.',
                        UPLOAD_ERR_NO_FILE => 'No se subió ninguna imagen.',
                        UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal en el servidor.',
                        UPLOAD_ERR_CANT_WRITE => 'Error al escribir la imagen en el disco.',
                        UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida de la imagen.'
                    ];
                    $datos['error'] = $uploadErrors[$errorArchivo] ?? 'Error desconocido al subir la imagen.';
                }
            }

            if (empty($datos['error'])) {
                // Actualizar Username en tabla Usuarios
                if (!empty($datos['username'])) {
                    $this->usuarioModel->actualizarUsername($_SESSION['usuario_id'], $datos['username']);
                    $_SESSION['usuario_username'] = $datos['username'];
                }

                if ($this->djModel->actualizarPerfil($datos)) {
                    $datos['success'] = '¡Perfil actualizado correctamente!';
                }
            }

            // Recargar perfil y mostrar vista
            $perfil = $this->djModel->obtenerPerfil($_SESSION['usuario_id']);
            $videos = $this->djModel->obtenerVideos($_SESSION['usuario_id']);
            $generos = $this->djModel->obtenerGeneros();
            $tiposEvento = $this->djModel->obtenerTiposEvento();
            
            $datos['perfil'] = $perfil;
            $datos['videos'] = $videos;
            $datos['generos_lista'] = $generos;
            $datos['tipos_evento_lista'] = $tiposEvento;
            $this->view('djs/editar', $datos);

        } else {
            $perfil = $this->djModel->obtenerPerfil($_SESSION['usuario_id']);
            $videos = $this->djModel->obtenerVideos($_SESSION['usuario_id']);
            $generos = $this->djModel->obtenerGeneros();
            $tiposEvento = $this->djModel->obtenerTiposEvento();
            $datos = [
                'perfil' => $perfil,
                'videos' => $videos,
                'generos_lista' => $generos,
                'tipos_evento_lista' => $tiposEvento,
                'success' => ''
            ];
            $this->view('djs/editar', $datos);
        }
    }

    public function agregar_video() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $datos = [
                'dj_id' => $_SESSION['usuario_id'],
                'titulo' => trim($_POST['titulo']),
                'url_video' => trim($_POST['url_video'])
            ];

            $success = $this->djModel->agregarVideo($datos);

            // Manejar peticiones AJAX
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => $success]);
                exit;
            }

            if ($success) {
                $redirect = ($_POST['from'] == 'editar') ? '/djs/editar' : '/djs/panel';
                header('Location: ' . URL_ROOT . $redirect);
            } else {
                $_SESSION['flash_message'] = 'No se pudo agregar el video.';
                $_SESSION['flash_type'] = 'error';
                header('Location: ' . URL_ROOT . '/djs/dashboard');
            }
        }
    }

    public function eliminar_video($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $success = $this->djModel->eliminarVideo($id, $_SESSION['usuario_id']);

            // Manejar peticiones AJAX
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => $success]);
                exit;
            }

            if ($success) {
                $redirect = (isset($_POST['from']) && $_POST['from'] == 'editar') ? '/djs/editar' : '/djs/panel';
                header('Location: ' . URL_ROOT . $redirect);
            } else {
                $_SESSION['flash_message'] = 'No se pudo eliminar el video.';
                $_SESSION['flash_type'] = 'error';
                header('Location: ' . URL_ROOT . '/djs/dashboard');
            }
        }
    }
}
