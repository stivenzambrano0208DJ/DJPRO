<?php
/**
 * Controlador de DJs
 */
class Djs extends Core\Controller {
    private $djModel;
    private $contratacionModel;

    public function __construct() {
        $this->djModel = $this->model('Dj');
        $this->contratacionModel = $this->model('Contratacion');
        $this->usuarioModel = $this->model('Usuario');

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
        
        $this->view('clientes/explorar', $datos);
    }

    public function perfil($id) {
        $perfil = $this->djModel->obtenerPerfil($id);
        if (!$perfil) {
            header('Location: ' . URL_ROOT . '/pages/index');
            exit;
        }
        $videos = $this->djModel->obtenerVideos($id);
        
        $datos = [
            'perfil' => $perfil,
            'videos' => $videos
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
        
        $datos = [
            'perfil' => $perfil,
            'stats' => $stats
        ];
        $this->view('djs/estadisticas', $datos);
    }

    public function editar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $datos = [
                'usuario_id' => $_SESSION['usuario_id'],
                'biografia' => trim($_POST['biografia']),
                'lugares_trabajo' => isset($_POST['lugares_trabajo']) ? implode(',', $_POST['lugares_trabajo']) : '',
                'ciudad' => trim($_POST['ciudad']),
                'departamento' => trim($_POST['departamento']),
                'generos' => isset($_POST['generos']) ? implode(',', $_POST['generos']) : '',
                'eventos' => isset($_POST['eventos']) ? implode(',', $_POST['eventos']) : '',
                'precio_hora' => $_POST['precio_hora'] ?? null,
                'auto_respuesta' => trim($_POST['auto_respuesta'] ?? ''),
                'bot_activo' => isset($_POST['bot_activo']) ? 1 : 0,
                'foto_perfil' => '',
                'success' => '',
                'error' => ''
            ];

            // Manejo de subida de archivos
            if (!empty($_FILES['foto_perfil']['name'])) {
                $nombreArchivo = $_FILES['foto_perfil']['name'];
                $tempArchivo = $_FILES['foto_perfil']['tmp_name'];
                $errorArchivo = $_FILES['foto_perfil']['error'];

                if ($errorArchivo === 0) {
                    $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                    $extLower = strtolower($ext);
                    $extPermitidas = ['jpg', 'jpeg', 'png'];

                    if (in_array($extLower, $extPermitidas)) {
                        $nuevoNombre = uniqid('dj_', true) . '.' . $extLower;
                        $destino = APPROOT . '/public/assets/uploads/' . $nuevoNombre;

                        if (move_uploaded_file($tempArchivo, $destino)) {
                            $datos['foto_perfil'] = $nuevoNombre;
                        } else {
                            $datos['error'] = 'Error al subir la imagen';
                        }
                    } else {
                        $datos['error'] = 'Solo se permiten archivos JPG, JPEG o PNG';
                    }
                }
            }

            if (empty($datos['error'])) {
                if ($this->djModel->actualizarPerfil($datos)) {
                    $datos['success'] = '¡Perfil actualizado correctamente!';
                }
            }

            // Recargar perfil y mostrar vista
            $perfil = $this->djModel->obtenerPerfil($_SESSION['usuario_id']);
            $generos = $this->djModel->obtenerGeneros();
            $tiposEvento = $this->djModel->obtenerTiposEvento();
            $datos['perfil'] = $perfil;
            $datos['generos_lista'] = $generos;
            $datos['tipos_evento_lista'] = $tiposEvento;
            $this->view('djs/editar', $datos);

        } else {
            $perfil = $this->djModel->obtenerPerfil($_SESSION['usuario_id']);
            $generos = $this->djModel->obtenerGeneros();
            $tiposEvento = $this->djModel->obtenerTiposEvento();
            $datos = [
                'perfil' => $perfil,
                'generos_lista' => $generos,
                'tipos_evento_lista' => $tiposEvento,
                'success' => ''
            ];
            $this->view('djs/editar', $datos);
        }
    }

    public function agregar_video() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $datos = [
                'dj_id' => $_SESSION['usuario_id'],
                'titulo' => trim($_POST['titulo']),
                'url_video' => trim($_POST['url_video'])
            ];

            if ($this->djModel->agregarVideo($datos)) {
                header('Location: ' . URL_ROOT . '/djs/panel');
            } else {
                die('Algo salió mal');
            }
        }
    }

    public function eliminar_video($id) {
        if ($this->djModel->eliminarVideo($id, $_SESSION['usuario_id'])) {
            header('Location: ' . URL_ROOT . '/djs/panel');
        }
    }
}
