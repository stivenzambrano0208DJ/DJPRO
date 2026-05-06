<?php
/**
 * Controlador de Contrataciones
 */
class Contrataciones extends Core\Controller {
    private $contratacionModel;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_ROOT . '/usuarios/login');
            exit;
        }
        $this->contratacionModel = $this->model('Contratacion');
        $this->usuarioModel = $this->model('Usuario');
    }

    // El cliente envía una solicitud
    public function solicitar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $datos = [
                'cliente_id' => $_SESSION['usuario_id'],
                'dj_id' => $_POST['dj_id'],
                'fecha_evento' => $_POST['fecha_evento'],
                'precio_total' => $_POST['precio_total'],
                'tipo_evento' => $_POST['evento'] ?? '',
                'mensaje_cliente' => trim($_POST['mensaje_cliente'])
            ];

            $success = $this->contratacionModel->crear($datos);

            if ($success) {
                // Notificar al DJ por correo
                $dj = $this->usuarioModel->buscarPorId($datos['dj_id']);
                if ($dj) {
                    \Libraries\EmailSender::enviarNotificacionReservaDj($dj->correo, $dj->nombre, $_SESSION['usuario_nombre'], $datos['fecha_evento']);
                }
            }

            // Verificar si es una petición AJAX
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                if ($success) {
                    echo json_encode(['success' => true, 'message' => '¡Solicitud enviada con éxito! El DJ recibirá tu propuesta.']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'No se pudo procesar la solicitud. Intente nuevamente.']);
                }
                exit;
            }

            if ($success) {
                header('Location: ' . URL_ROOT . '/clientes/dashboard');
            } else {
                die('Algo salió mal');
            }
        }
    }

    // El DJ acepta, rechaza o finaliza
    public function responder($id, $estado) {
        $contratacion = $this->contratacionModel->obtenerPorId($id);
        
        if (!$contratacion || $contratacion->dj_id != $_SESSION['usuario_id']) {
            header('Location: ' . URL_ROOT . '/djs/dashboard');
            exit;
        }

        // RESTRICCIÓN: No puede finalizar hasta 1 día después del evento
        if ($estado == 'terminada' || $estado == 'completada') {
            $fechaEvento = new DateTime($contratacion->fecha_evento);
            $hoy = new DateTime();
            $intervalo = $hoy->diff($fechaEvento);
            
            // Si el evento aún no ha pasado o no ha pasado 1 día
            if ($hoy <= $fechaEvento || $intervalo->days < 1) {
                $_SESSION['flash_message'] = '⚠️ Solo puedes finalizar el evento 24 horas después de su realización.';
                header('Location: ' . URL_ROOT . '/djs/dashboard');
                exit;
            }
        }

        $estadosPermitidos = ['aceptada', 'rechazada', 'cancelada', 'terminada', 'completada'];
        if (in_array($estado, $estadosPermitidos)) {
            if ($this->contratacionModel->actualizarEstado($id, $estado)) {
                // Notificaciones
                if ($estado == 'aceptada') {
                    $cliente = $this->usuarioModel->buscarPorId($contratacion->cliente_id);
                    if ($cliente) {
                        \Libraries\EmailSender::enviarNotificacionAceptacionCliente($cliente->correo, $cliente->nombre, $_SESSION['usuario_nombre'], $contratacion->fecha_evento);
                    }
                }
                
                if ($estado == 'cancelada' || $estado == 'rechazada') {
                    $cliente = $this->usuarioModel->buscarPorId($contratacion->cliente_id);
                    if ($cliente) {
                        \Libraries\EmailSender::enviarNotificacionCancelacionCliente($cliente->correo, $cliente->nombre, $_SESSION['usuario_nombre'], $contratacion->fecha_evento);
                    }
                }

                if ($estado == 'terminada' || $estado == 'completada') {
                    $cliente = $this->usuarioModel->buscarPorId($contratacion->cliente_id);
                    if ($cliente) {
                        \Libraries\EmailSender::enviarNotificacionFinalizacionCliente($cliente->correo, $cliente->nombre, $_SESSION['usuario_nombre']);
                    }
                }
                header('Location: ' . URL_ROOT . '/djs/dashboard');
            }
        }
    }

    // El Cliente cancela su propia solicitud
    public function cancelar_cliente($id) {
        $contratacion = $this->contratacionModel->obtenerPorId($id);
        
        if (!$contratacion || $contratacion->cliente_id != $_SESSION['usuario_id']) {
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
            exit;
        }

        if ($this->contratacionModel->actualizarEstado($id, 'cancelada')) {
            // Notificar al DJ
            $dj = $this->usuarioModel->buscarPorId($contratacion->dj_id);
            if ($dj) {
                \Libraries\EmailSender::enviarNotificacionCancelacionDj($dj->correo, $dj->nombre, $_SESSION['usuario_nombre'], $contratacion->fecha_evento);
            }
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
        }
    }
}
