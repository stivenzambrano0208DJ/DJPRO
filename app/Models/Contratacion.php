<?php
/**
 * Modelo de Contrataciones
 */
class Contratacion extends Core\Model {
    
    // Crear solicitud de contratación
    public function crear($datos) {
        $this->db->query('INSERT INTO contrataciones (cliente_id, dj_id, fecha_evento, tipo_evento, precio_total, mensaje_cliente, horas, presupuesto_estimado) 
                          VALUES (:cliente_id, :dj_id, :fecha_evento, :tipo_evento, :precio_total, :mensaje_cliente, :horas, :presupuesto_estimado)');
        $this->db->bind(':cliente_id', $datos['cliente_id']);
        $this->db->bind(':dj_id', $datos['dj_id']);
        $this->db->bind(':fecha_evento', $datos['fecha_evento']);
        $this->db->bind(':tipo_evento', $datos['tipo_evento']);
        $this->db->bind(':precio_total', $datos['precio_total']);
        $this->db->bind(':mensaje_cliente', $datos['mensaje_cliente']);
        $this->db->bind(':horas', $datos['horas'] ?? 1);
        $this->db->bind(':presupuesto_estimado', $datos['presupuesto_estimado'] ?? null);

        return $this->db->execute();
    }

    // Enviar contra-oferta del DJ
    public function enviarContraOferta($id, $monto) {
        $this->db->query('UPDATE contrataciones SET contra_oferta = :monto WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':monto', $monto);
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

    // Obtener todas las contrataciones (Admin)
    public function obtenerTodas() {
        $this->db->query('SELECT c.*, u1.nombre as cliente_nombre, u2.nombre as dj_nombre 
                          FROM contrataciones c 
                          INNER JOIN usuarios u1 ON c.cliente_id = u1.id 
                          INNER JOIN usuarios u2 ON c.dj_id = u2.id 
                          ORDER BY c.fecha_creacion DESC');
        return $this->db->resultSet();
    }
}
