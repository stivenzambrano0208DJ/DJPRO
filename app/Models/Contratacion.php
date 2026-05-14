<?php
/**
 * Modelo de Contrataciones
 */
class Contratacion extends Core\Model {
    
    // Crear solicitud de contratación
    public function crear($datos) {
        $this->db->query('INSERT INTO contrataciones (cliente_id, dj_id, fecha_evento, hora_inicio, hora_fin, tipo_evento, horas, precio_total, mensaje_cliente, presupuesto_estimado) VALUES (:cliente_id, :dj_id, :fecha_evento, :hora_inicio, :hora_fin, :evento, :horas, :precio_total, :mensaje_cliente, :presupuesto_estimado)');
        $this->db->bind(':cliente_id', $datos['cliente_id']);
        $this->db->bind(':dj_id', $datos['dj_id']);
        $this->db->bind(':fecha_evento', $datos['fecha_evento']);
        $this->db->bind(':hora_inicio', $datos['hora_inicio']);
        $this->db->bind(':hora_fin', $datos['hora_fin']);
        $this->db->bind(':evento', $datos['evento']);
        $this->db->bind(':horas', $datos['horas']);
        $this->db->bind(':precio_total', $datos['precio_total']);
        $this->db->bind(':mensaje_cliente', $datos['mensaje_cliente']);
        $this->db->bind(':presupuesto_estimado', $datos['presupuesto_estimado']);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // Verificar si el DJ tiene conflicto de horario para una fecha y hora dada
    // Asume que cada evento tiene una duración (horas) + 1 hora de traslado/buffer
    public function verificarDisponibilidad($dj_id, $fecha, $hora_inicio = null, $horas_nuevas = 1, $excluir_id = null) {
        // Obtener todas las contrataciones aceptadas/confirmadas del DJ en esa fecha
        $sql = 'SELECT id, hora_inicio, horas FROM contrataciones 
                WHERE dj_id = :dj_id AND fecha_evento = :fecha 
                AND (estado = "aceptada" OR estado = "confirmada")';
        if ($excluir_id) {
            $sql .= ' AND id != :excluir_id';
        }
        $this->db->query($sql);
        $this->db->bind(':dj_id', $dj_id);
        $this->db->bind(':fecha', $fecha);
        if ($excluir_id) {
            $this->db->bind(':excluir_id', $excluir_id);
        }
        $reservas = $this->db->resultSet();

        // Si no hay reservas en esa fecha, está libre
        if (empty($reservas)) {
            return true;
        }

        // Si no se especifica hora, bloquear todo el día (comportamiento anterior de seguridad)
        if (empty($hora_inicio)) {
            return false;
        }

        $buffer = 1; // 1 hora de traslado entre eventos
        $nueva_inicio = strtotime($hora_inicio);
        $nueva_fin    = $nueva_inicio + ($horas_nuevas + $buffer) * 3600;

        foreach ($reservas as $reserva) {
            // Si la reserva existente no tiene hora, bloquear todo el día
            if (empty($reserva->hora_inicio)) {
                return false;
            }

            $existente_inicio = strtotime($reserva->hora_inicio);
            $existente_horas  = $reserva->horas ?: 1;
            $existente_fin    = $existente_inicio + ($existente_horas + $buffer) * 3600;

            // Hay conflicto si los intervalos se solapan
            if ($nueva_inicio < $existente_fin && $nueva_fin > $existente_inicio) {
                return false;
            }
        }

        return true; // No hay conflicto
    }

    // Enviar contra-oferta
    public function enviarContraOferta($id, $monto, $quien) {
        $this->db->query('UPDATE contrataciones SET contra_oferta = :monto, quien_contraoferto = :quien WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':monto', $monto);
        $this->db->bind(':quien', $quien);
        return $this->db->execute();
    }

    // Aceptar contra-oferta (actualiza el precio total y limpia la contra-oferta)
    public function aceptarContraOferta($id, $nuevoPrecio) {
        $this->db->query('UPDATE contrataciones SET precio_total = :nuevoPrecio, contra_oferta = 0, quien_contraoferto = NULL, estado = "aceptada" WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':nuevoPrecio', $nuevoPrecio);
        return $this->db->execute();
    }

    // Reiniciar contra-oferta (cuando se rechaza o se envía una nueva)
    public function reiniciarContraOferta($id) {
        $this->db->query('UPDATE contrataciones SET contra_oferta = 0, quien_contraoferto = NULL WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Cancelar contra-oferta
    public function cancelarContraOferta($id) {
        $this->db->query('UPDATE contrataciones SET contra_oferta = 0, quien_contraoferto = NULL WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Obtener contrataciones de un DJ
    public function obtenerPorDj($dj_id) {
        $this->db->query('SELECT c.*, u.nombre as cliente_nombre 
                          FROM contrataciones c 
                          INNER JOIN usuarios u ON c.cliente_id = u.id 
                          WHERE c.dj_id = :dj_id 
                          ORDER BY c.fecha_creacion DESC');
        $this->db->bind(':dj_id', $dj_id);
        return $this->db->resultSet();
    }

    // Obtener contrataciones de un Cliente
    public function obtenerPorCliente($cliente_id) {
        $this->db->query('SELECT c.*, u.nombre as dj_nombre 
                          FROM contrataciones c 
                          INNER JOIN usuarios u ON c.dj_id = u.id 
                          WHERE c.cliente_id = :cliente_id 
                          ORDER BY c.fecha_creacion DESC');
        $this->db->bind(':cliente_id', $cliente_id);
        return $this->db->resultSet();
    }

    // Actualizar estado de contratación
    public function actualizarEstado($id, $estado) {
        $this->db->query('UPDATE contrataciones SET estado = :estado WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':estado', $estado);
        return $this->db->execute();
    }

    // Obtener una sola contratación
    public function obtenerPorId($id) {
        $this->db->query('SELECT * FROM contrataciones WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Obtener todas las contrataciones (Admin) con paginación opcional
    public function obtenerTodas($limit = null, $offset = null) {
        $sql = 'SELECT c.*, u.nombre as cliente_nombre, u2.nombre as dj_nombre 
                FROM contrataciones c 
                JOIN usuarios u ON c.cliente_id = u.id 
                JOIN usuarios u2 ON c.dj_id = u2.id 
                ORDER BY c.fecha_creacion DESC';
        
        if ($limit !== null) {
            $sql .= ' LIMIT :limit';
        }
        if ($offset !== null) {
            $sql .= ' OFFSET :offset';
        }

        $this->db->query($sql);
        
        if ($limit !== null) $this->db->bind(':limit', $limit);
        if ($offset !== null) $this->db->bind(':offset', $offset);
        
        return $this->db->resultSet();
    }

    // Obtener estadísticas globales para el admin
    public function obtenerEstadisticasGlobales() {
        // Volumen total
        $this->db->query('SELECT SUM(precio_total) as total FROM contrataciones WHERE estado = "terminada" OR estado = "confirmada"');
        $volumen = $this->db->single();
        
        // Conteo por estado
        $this->db->query('SELECT estado, COUNT(*) as cantidad FROM contrataciones GROUP BY estado');
        $estados = $this->db->resultSet();
        
        return [
            'volumen' => $volumen->total ?? 0,
            'estados' => $estados
        ];
    }

    // Obtener proyección de servicios (últimos 6 meses)
    public function obtenerProyeccionMensual() {
        $this->db->query("SELECT 
                            DATE_FORMAT(fecha_creacion, '%M') as mes,
                            COUNT(*) as total
                          FROM contrataciones 
                          WHERE fecha_creacion >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                          GROUP BY DATE_FORMAT(fecha_creacion, '%Y-%m')
                          ORDER BY fecha_creacion ASC");
        return $this->db->resultSet();
    }
}
