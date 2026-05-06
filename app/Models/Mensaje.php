<?php
/**
 * Modelo de Mensajes
 */
class Mensaje extends Core\Model {
    
    // Obtener conversaciones del usuario (agrupadas por contacto)
    public function obtenerConversaciones($usuario_id) {
        $this->db->query('SELECT u.id as contacto_id, u.nombre as contacto_nombre, m.contenido, m.fecha_envio, m.leido,
                          (SELECT COUNT(*) FROM mensajes WHERE receptor_id = :usuario_id AND emisor_id = u.id AND leido = 0) as no_leidos
                          FROM usuarios u
                          INNER JOIN mensajes m ON (u.id = m.emisor_id OR u.id = m.receptor_id)
                          WHERE (m.emisor_id = :usuario_id OR m.receptor_id = :usuario_id)
                          AND u.id != :usuario_id
                          AND m.id IN (SELECT MAX(id) FROM mensajes WHERE emisor_id = :usuario_id OR receptor_id = :usuario_id GROUP BY IF(emisor_id = :usuario_id, receptor_id, emisor_id))
                          ORDER BY m.fecha_envio DESC');
        
        $this->db->bind(':usuario_id', $usuario_id);
        return $this->db->resultSet();
    }

    // Obtener chat específico con un contacto
    public function obtenerChat($usuario_id, $contacto_id) {
        $this->db->query('SELECT * FROM mensajes 
                          WHERE (emisor_id = :usuario_id AND receptor_id = :contacto_id)
                          OR (emisor_id = :contacto_id AND receptor_id = :usuario_id)
                          ORDER BY fecha_envio ASC');
        $this->db->bind(':usuario_id', $usuario_id);
        $this->db->bind(':contacto_id', $contacto_id);
        return $this->db->resultSet();
    }

    // Enviar mensaje
    public function enviar($datos) {
        $this->db->query('INSERT INTO mensajes (emisor_id, receptor_id, contenido) VALUES (:emisor_id, :receptor_id, :contenido)');
        $this->db->bind(':emisor_id', $datos['emisor_id']);
        $this->db->bind(':receptor_id', $datos['receptor_id']);
        $this->db->bind(':contenido', $datos['contenido']);

        return $this->db->execute();
    }

    // Marcar como leídos
    public function marcarComoLeidos($usuario_id, $contacto_id) {
        $this->db->query('UPDATE mensajes SET leido = 1 WHERE receptor_id = :usuario_id AND emisor_id = :contacto_id');
        $this->db->bind(':usuario_id', $usuario_id);
        $this->db->bind(':contacto_id', $contacto_id);
        return $this->db->execute();
    }
}
