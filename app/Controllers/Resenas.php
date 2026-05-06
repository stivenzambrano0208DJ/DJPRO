<?php
/**
 * Controlador de Reseñas
 */
class Resenas extends Core\Controller {
    private $resenaModel;
    private $contratacionModel;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_ROOT . '/usuarios/login');
            exit;
        }
        $this->resenaModel = $this->model('Resena');
        $this->contratacionModel = $this->model('Contratacion');
    }

    public function publicar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $datos = [
                'contratacion_id' => $_POST['contratacion_id'],
                'cliente_id' => $_SESSION['usuario_id'],
                'dj_id' => $_POST['dj_id'],
                'puntuacion' => (int)$_POST['puntuacion'],
                'comentario' => trim($_POST['comentario'])
            ];

            // Validar que la contratación pertenezca al cliente y esté terminada
            $contratacion = $this->contratacionModel->obtenerPorId($datos['contratacion_id']);
            
            if (!$contratacion || $contratacion->cliente_id != $_SESSION['usuario_id'] || !in_array($contratacion->estado, ['terminada', 'completada'])) {
                header('Location: ' . URL_ROOT . '/clientes/dashboard');
                exit;
            }

            if ($this->resenaModel->crear($datos)) {
                // Si es AJAX
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => '¡Reseña publicada! Gracias por tu feedback.']);
                    exit;
                }
                header('Location: ' . URL_ROOT . '/clientes/dashboard');
            } else {
                die('Algo salió mal');
            }
        }
    }
}
