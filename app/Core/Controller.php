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
        $data['csrf_token'] = $this->generateCsrfToken();

        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }

    // Generate CSRF token for forms and AJAX requests.
    public function generateCsrfToken() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Validate CSRF token on state-changing requests.
    public function validateCsrf() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $sessionToken = $_SESSION['csrf_token'] ?? '';
            $postToken = $_POST['csrf_token'] ?? '';
            $headerToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            $token = $postToken ?: $headerToken;

            if (empty($token) || empty($sessionToken) || !hash_equals($sessionToken, $token)) {
                http_response_code(403);
                die('Error de seguridad: Token CSRF no valido o expirado.');
            }
        }
    }

    protected function requirePost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Metodo no permitido.');
        }
    }
}
