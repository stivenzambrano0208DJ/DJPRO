<?php
/**
 * Default Pages Controller
 */
class Pages extends Core\Controller {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = $this->model('Usuario');
    }

    public function index() {
        $totalDjs = $this->usuarioModel->contarPorRol('dj');
        $totalClientes = $this->usuarioModel->contarPorRol('cliente');
        $totalEventos = $this->usuarioModel->contarContrataciones();
        $djs = $this->usuarioModel->obtenerDjsConPerfil(6); // Obtener 6 DJs para la landing
        $generos = $this->usuarioModel->obtenerGeneros();
        $tiposEvento = $this->usuarioModel->obtenerTiposEvento();

        $datos = [
            'total_djs' => $totalDjs,
            'total_clientes' => $totalClientes,
            'total_eventos' => $totalEventos,
            'djs' => $djs,
            'generos' => $generos,
            'tipos_evento' => $tiposEvento
        ];

        $this->view('pages/index', $datos);
    }

    public function api_stats() {
        header('Content-Type: application/json');
        $totalDjs = $this->usuarioModel->contarPorRol('dj');
        $totalClientes = $this->usuarioModel->contarPorRol('cliente');
        $totalEventos = $this->usuarioModel->contarContrataciones();

        echo json_encode([
            'total_djs' => $totalDjs,
            'total_clientes' => $totalClientes,
            'total_eventos' => $totalEventos,
            'timestamp' => date('H:i:s')
        ]);
        exit;
    }
}
