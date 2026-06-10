<?php
/**
 * Controlador de Clientes
 */
class Clientes extends Core\Controller {
    private $usuarioModel;
    private $contratacionModel;
    
    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_ROOT . '/usuarios/login');
            exit;
        }
        $this->usuarioModel = $this->model('Usuario');
        $this->contratacionModel = $this->model('Contratacion');
    }

    public function index() {
        $this->dashboard();
    }

    public function dashboard() {
        $contrataciones = $this->contratacionModel->obtenerPorCliente($_SESSION['usuario_id']);
        $generos = $this->usuarioModel->obtenerGeneros();
        $datos = [
            'contrataciones' => $contrataciones,
            'generos' => $generos
        ];

        if ($_SESSION['usuario_rol'] == 'dj') {
            $djModel = $this->model('Dj');
            $datos['perfil'] = $djModel->obtenerPerfil($_SESSION['usuario_id']);
        }

        $this->view('clientes/panel', $datos);
    }

}
