<?php
/**
 * Controlador de Mensajería
 */
class Chat extends Core\Controller {
    private $mensajeModel;
    private $usuarioModel;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_ROOT . '/usuarios/login');
            exit;
        }
        $this->mensajeModel = $this->model('Mensaje');
        $this->usuarioModel = $this->model('Usuario');
    }

    public function index($contacto_id = null) {
        $conversaciones = $this->mensajeModel->obtenerConversaciones($_SESSION['usuario_id']);
        $chatActual = [];
        $contactoActual = null;

        if ($contacto_id) {
            $chatActual = $this->mensajeModel->obtenerChat($_SESSION['usuario_id'], $contacto_id);
            $contactoActual = $this->usuarioModel->buscarPorId($contacto_id);
            $this->mensajeModel->marcarComoLeidos($_SESSION['usuario_id'], $contacto_id);
        }

        $datos = [
            'conversaciones' => $conversaciones,
            'chat_actual' => $chatActual,
            'contacto_actual' => $contactoActual,
            'contacto_id' => $contacto_id
        ];

        // Si es DJ, cargar su perfil para el sidebar
        if($_SESSION['usuario_rol'] == 'dj') {
            $djModel = $this->model('Dj');
            $datos['perfil'] = $djModel->obtenerPerfil($_SESSION['usuario_id']);
        }

        $this->view('chat/index', $datos);
    }

    public function enviar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $datos = [
                'emisor_id' => $_SESSION['usuario_id'],
                'receptor_id' => $_POST['receptor_id'],
                'contenido' => htmlspecialchars(trim($_POST['contenido']), ENT_QUOTES, 'UTF-8')
            ];

            if (!empty($datos['contenido'])) {
                if ($this->mensajeModel->enviar($datos)) {
                    // Lógica del Bot de Auto-respuesta
                    $perfilDj = $this->usuarioModel->buscarDjPerfil($datos['receptor_id']);
                    if ($perfilDj && $perfilDj->bot_activo && !empty($perfilDj->auto_respuesta)) {
                        // Verificar si el DJ ya ha enviado mensajes antes en este chat
                        $chat = $this->mensajeModel->obtenerChat($datos['emisor_id'], $datos['receptor_id']);
                        $djMensajes = array_filter($chat, function($m) use ($datos) {
                            return $m->emisor_id == $datos['receptor_id'];
                        });

                        if (count($djMensajes) == 0) {
                            $botData = [
                                'emisor_id' => $datos['receptor_id'],
                                'receptor_id' => $datos['emisor_id'],
                                'contenido' => $perfilDj->auto_respuesta
                            ];
                            $this->mensajeModel->enviar($botData);
                        }
                    }
                }
            }
            header('Location: ' . URL_ROOT . '/chat/index/' . $datos['receptor_id']);
        }
    }

    public function api_get_messages($contacto_id) {
        header('Content-Type: application/json');
        $mensajes = $this->mensajeModel->obtenerChat($_SESSION['usuario_id'], $contacto_id);
        
        // Marcar como leídos al obtener vía API también
        $this->mensajeModel->marcarComoLeidos($_SESSION['usuario_id'], $contacto_id);

        echo json_encode([
            'mensajes' => $mensajes,
            'timestamp' => date('H:i:s')
        ]);
        exit;
    }

    public function api_send() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $datos = [
                'emisor_id' => $_SESSION['usuario_id'],
                'receptor_id' => $_POST['receptor_id'],
                'contenido' => htmlspecialchars(trim($_POST['contenido']), ENT_QUOTES, 'UTF-8')
            ];

            if (!empty($datos['contenido'])) {
                if ($this->mensajeModel->enviar($datos)) {
                    // Lógica del Bot de Auto-respuesta
                    $perfilDj = $this->usuarioModel->buscarDjPerfil($datos['receptor_id']);
                    if ($perfilDj && $perfilDj->bot_activo && !empty($perfilDj->auto_respuesta)) {
                        $chat = $this->mensajeModel->obtenerChat($datos['emisor_id'], $datos['receptor_id']);
                        $djMensajes = array_filter($chat, function($m) use ($datos) {
                            return $m->emisor_id == $datos['receptor_id'];
                        });

                        if (count($djMensajes) == 0) {
                            $botData = [
                                'emisor_id' => $datos['receptor_id'],
                                'receptor_id' => $datos['emisor_id'],
                                'contenido' => $perfilDj->auto_respuesta
                            ];
                            $this->mensajeModel->enviar($botData);
                        }
                    }
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error']);
                }
            }
        }
        exit;
    }

    public function api_check_notifications() {
        header('Content-Type: application/json');
        
        $noLeidos = $this->mensajeModel->contarNoLeidos($_SESSION['usuario_id']);
        $ultimo = $this->mensajeModel->obtenerUltimoNoLeido($_SESSION['usuario_id']);
        
        echo json_encode([
            'count' => $noLeidos,
            'latest' => $ultimo ? [
                'id' => $ultimo->id,
                'emisor_id' => $ultimo->emisor_id,
                'emisor' => $ultimo->emisor_nombre,
                'contenido' => $ultimo->contenido
            ] : null
        ]);
        exit;
    }
}
