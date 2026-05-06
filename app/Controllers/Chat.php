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

        $this->view('chat/index', $datos);
    }

    public function enviar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                'emisor_id' => $_SESSION['usuario_id'],
                'receptor_id' => $_POST['receptor_id'],
                'contenido' => trim($_POST['contenido'])
            ];

            if (!empty($datos['contenido'])) {
                $this->mensajeModel->enviar($datos);
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
            $datos = [
                'emisor_id' => $_SESSION['usuario_id'],
                'receptor_id' => $_POST['receptor_id'],
                'contenido' => trim($_POST['contenido'])
            ];

            if (!empty($datos['contenido'])) {
                if ($this->mensajeModel->enviar($datos)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error']);
                }
            }
        }
        exit;
    }
}
