<?php
namespace Core;

/**
 * Base Controller
 * Loads Models and Views
 */
class Controller {
    // Load Model
    public function model($model) {
        require_once '../app/Models/' . $model . '.php';
        return new $model();
    }

    // Load View
    public function view($view, $data = []) {
        // Generar token CSRF para todas las vistas
        $data['csrf_token'] = $this->generateCsrfToken();
        
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }

    // Generar Token CSRF
    public function generateCsrfToken() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Validar Token CSRF
    public function validateCsrf() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('Error de seguridad: Token CSRF no válido o expirado.');
            }
        }
    }
}
