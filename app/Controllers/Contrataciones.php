<?php
/**
 * Controlador de Contrataciones
 */
class Contrataciones extends Core\Controller {
    private $contratacionModel;
    private $usuarioModel;

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
            $this->validateCsrf();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $datos = [
                'cliente_id' => $_SESSION['usuario_id'],
                'dj_id' => trim($_POST['dj_id']),
                'fecha_evento' => trim($_POST['fecha_evento']),
                'hora_inicio' => trim($_POST['hora_inicio']),
                'hora_fin' => trim($_POST['hora_fin']),
                'evento' => trim($_POST['evento']),
                'horas' => trim($_POST['horas']),
                'precio_total' => trim($_POST['precio_total']),
                'mensaje_cliente' => trim($_POST['mensaje_cliente']),
                'presupuesto_estimado' => $_POST['presupuesto_estimado'] ?? null
            ];

            // Validar disponibilidad del DJ (con hora y duración)
            if (!$this->contratacionModel->verificarDisponibilidad(
                    $datos['dj_id'], 
                    $datos['fecha_evento'], 
                    $datos['hora_inicio'], 
                    $datos['horas']
                )) {
                $mensaje = empty($datos['hora_inicio'])
                    ? '⚠️ El DJ ya tiene un compromiso confirmado para esta fecha.'
                    : '⚠️ El DJ ya tiene un evento en ese horario. Elige otra hora o fecha.';
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => $mensaje]);
                    exit;
                }
                $_SESSION['flash_message'] = $mensaje;
                $_SESSION['flash_type'] = 'warning';
                header('Location: ' . URL_ROOT . '/clientes/dashboard');
                exit;
            }

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
                $_SESSION['flash_message'] = 'Hubo un error al procesar tu solicitud. Por favor intenta de nuevo.';
                $_SESSION['flash_type'] = 'error';
                header('Location: ' . URL_ROOT . '/clientes/dashboard');
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
        // NOTA PARA PRESENTACIÓN: Se ha deshabilitado temporalmente esta validación para que 
        // puedas mostrar el flujo completo de calificación en vivo sin tener que esperar 24 horas.
        if ($estado == 'terminada' || $estado == 'completada') {
            /*
            $fechaEvento = new DateTime($contratacion->fecha_evento);
            $hoy = new DateTime();
            $intervalo = $hoy->diff($fechaEvento);
            
            // Si el evento aún no ha pasado o no ha pasado 1 día
            if ($hoy <= $fechaEvento || $intervalo->days < 1) {
                $_SESSION['flash_message'] = '⚠️ Solo puedes finalizar el evento 24 horas después de su realización.';
                header('Location: ' . URL_ROOT . '/djs/dashboard');
                exit;
            }
            */
        }

        $estadosPermitidos = ['aceptada', 'rechazada', 'cancelada', 'terminada', 'completada', 'confirmada', 'confirmada_total'];
        if (in_array($estado, $estadosPermitidos)) {
            // BUG-001 FIX: Validar disponibilidad ANTES de cambiar el estado
            if ($estado == 'aceptada') {
                if (!$this->contratacionModel->verificarDisponibilidad(
                        $contratacion->dj_id, 
                        $contratacion->fecha_evento,
                        $contratacion->hora_inicio,
                        $contratacion->horas,
                        $contratacion->id
                    )) {
                    $_SESSION['flash_message'] = '⚠️ No puedes aceptar esta reserva porque ya tienes otro evento en ese horario.';
                    $_SESSION['flash_type'] = 'warning';
                    header('Location: ' . URL_ROOT . '/djs/dashboard');
                    exit;
                }
            }

            if ($this->contratacionModel->actualizarEstado($id, $estado)) {
                // Notificaciones por email
                if ($estado == 'aceptada') {
                    // Obtener datos del cliente y DJ para el correo
                    $solicitud = $this->contratacionModel->obtenerPorId($id);
                    $dj = $this->usuarioModel->buscarPorId($solicitud->dj_id);
                    $cliente = $this->usuarioModel->buscarPorId($solicitud->cliente_id);
                    
                    // Formatear hora correctamente para evitar ceros
                    $hora_inicio_formateada = date('h:i A', strtotime($solicitud->hora_inicio));
                    $hora_fin_formateada = date('h:i A', strtotime($solicitud->hora_fin));
                    
                    \Libraries\EmailSender::enviarConfirmacionCliente(
                        $cliente->correo, 
                        $cliente->nombre, 
                        $dj->nombre, 
                        $solicitud->fecha_evento, 
                        $hora_inicio_formateada . ' - ' . $hora_fin_formateada
                    );
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

        // BUG-004 FIX: Solo permitir cancelar si está pendiente o aceptada
        if (!in_array($contratacion->estado, ['pendiente', 'aceptada'])) {
            $_SESSION['flash_message'] = '⚠️ No se puede cancelar una reserva que ya fue ' . $contratacion->estado . '.';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
            exit;
        }

        if ($this->contratacionModel->actualizarEstado($id, 'cancelada')) {
            // Notificar al DJ
            $dj = $this->usuarioModel->buscarPorId($contratacion->dj_id);
            if ($dj) {
                \Libraries\EmailSender::enviarNotificacionCancelacionDj($dj->correo, $dj->nombre, $_SESSION['usuario_nombre'], $contratacion->fecha_evento);
            }
            $_SESSION['flash_message'] = '✅ Reserva cancelada correctamente.';
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
        }
    }

    // El DJ envía una contra-oferta
    public function contra_oferta() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $id = $_POST['contratacion_id'];
            $monto = $_POST['monto_contra_oferta'];
            
            $contratacion = $this->contratacionModel->obtenerPorId($id);
            if (!$contratacion || $contratacion->dj_id != $_SESSION['usuario_id']) {
                header('Location: ' . URL_ROOT . '/djs/dashboard');
                exit;
            }

            if ($this->contratacionModel->enviarContraOferta($id, $monto, 'dj')) {
                // Opcional: Cambiar estado o simplemente notificar
                $_SESSION['flash_message'] = '✅ Contra-oferta enviada al cliente.';
                header('Location: ' . URL_ROOT . '/djs/dashboard');
            } else {
                $_SESSION['flash_message'] = 'No se pudo enviar la contra-oferta.';
                $_SESSION['flash_type'] = 'error';
                header('Location: ' . URL_ROOT . '/djs/dashboard');
            }
        }
    }

    // El Cliente acepta la contra-oferta del DJ
    public function aceptar_contra_oferta($id) {
        $contratacion = $this->contratacionModel->obtenerPorId($id);
        
        if (!$contratacion || $contratacion->cliente_id != $_SESSION['usuario_id']) {
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
            exit;
        }

        // Validar disponibilidad horaria antes de aceptar
        if (!$this->contratacionModel->verificarDisponibilidad(
                $contratacion->dj_id, 
                $contratacion->fecha_evento,
                $contratacion->hora_inicio,
                $contratacion->horas,
                $contratacion->id  // excluir esta misma contratación
            )) {
            $_SESSION['flash_message'] = '⚠️ El DJ ya tiene un evento en ese horario. No se puede proceder.';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
            exit;
        }

        // BUG-005 FIX: Usar aceptarContraOferta() para actualizar el precio
        if ($this->contratacionModel->aceptarContraOferta($id, $contratacion->contra_oferta)) {
            $_SESSION['flash_message'] = '🎉 ¡Reserva aceptada con el nuevo precio de $' . number_format($contratacion->contra_oferta, 0) . '!';
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
        }
    }

    // El Cliente rechaza la contra-oferta
    public function rechazar_contra_oferta($id) {
        $contratacion = $this->contratacionModel->obtenerPorId($id);
        if (!$contratacion || $contratacion->cliente_id != $_SESSION['usuario_id']) {
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
            exit;
        }

        if ($this->contratacionModel->reiniciarContraOferta($id)) {
            $_SESSION['flash_message'] = '❌ Has rechazado la propuesta de precio del DJ.';
            header('Location: ' . URL_ROOT . '/clientes/dashboard');
        }
    }

    // El Cliente envía una nueva contra-oferta al DJ
    public function contra_oferta_cliente() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validateCsrf();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $id = $_POST['contratacion_id'];
            $monto = $_POST['monto_contra_oferta'];
            
            $contratacion = $this->contratacionModel->obtenerPorId($id);
            if (!$contratacion || $contratacion->cliente_id != $_SESSION['usuario_id']) {
                header('Location: ' . URL_ROOT . '/clientes/dashboard');
                exit;
            }

            if ($this->contratacionModel->enviarContraOferta($id, $monto, 'cliente')) {
                $_SESSION['flash_message'] = '✅ Tu nueva propuesta ha sido enviada al DJ.';
                header('Location: ' . URL_ROOT . '/clientes/dashboard');
            }
        }
    }

    // El DJ acepta la contra-oferta del CLIENTE
    public function aceptar_contra_oferta_dj($id) {
        $contratacion = $this->contratacionModel->obtenerPorId($id);
        
        if (!$contratacion || $contratacion->dj_id != $_SESSION['usuario_id']) {
            header('Location: ' . URL_ROOT . '/djs/dashboard');
            exit;
        }

        if ($this->contratacionModel->aceptarContraOferta($id, $contratacion->contra_oferta)) {
            $_SESSION['flash_message'] = '🎉 ¡Has aceptado la propuesta del cliente! Precio actualizado a $' . number_format($contratacion->contra_oferta, 0);
            header('Location: ' . URL_ROOT . '/djs/dashboard');
        }
    }

    // El DJ rechaza la contra-oferta del CLIENTE
    public function rechazar_contra_oferta_dj($id) {
        $contratacion = $this->contratacionModel->obtenerPorId($id);
        if (!$contratacion || $contratacion->dj_id != $_SESSION['usuario_id']) {
            header('Location: ' . URL_ROOT . '/djs/dashboard');
            exit;
        }

        if ($this->contratacionModel->reiniciarContraOferta($id)) {
            $_SESSION['flash_message'] = '❌ Has rechazado la propuesta de precio del cliente.';
            header('Location: ' . URL_ROOT . '/djs/dashboard');
        }
    }

    // El DJ cancela su propia contra-oferta
    public function cancelar_contra_oferta($id) {
        $contratacion = $this->contratacionModel->obtenerPorId($id);
        if (!$contratacion || $contratacion->dj_id != $_SESSION['usuario_id']) {
            header('Location: ' . URL_ROOT . '/djs/dashboard');
            exit;
        }

        if ($this->contratacionModel->cancelarContraOferta($id)) {
            $_SESSION['flash_message'] = '❌ Contra-oferta cancelada.';
            header('Location: ' . URL_ROOT . '/djs/dashboard');
        }
    }
}
