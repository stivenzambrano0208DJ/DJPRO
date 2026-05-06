<?php
/**
 * Modelo de Reseñas
 */
class Resena extends Core\Model {
    
    // Crear una reseña
    public function crear($datos) {
        $this->db->query('INSERT INTO resenas (contratacion_id, cliente_id, dj_id, puntuacion, comentario) 
                          VALUES (:contratacion_id, :cliente_id, :dj_id, :puntuacion, :comentario)');
        $this->db->bind(':contratacion_id', $datos['contratacion_id']);
        $this->db->bind(':cliente_id', $datos['cliente_id']);
        $this->db->bind(':dj_id', $datos['dj_id']);
        $this->db->bind(':puntuacion', $datos['puntuacion']);
        $this->db->bind(':comentario', $datos['comentario']);

        if($this->db->execute()){
            $resena_id = $this->db->lastInsertId();
            // Actualizar la contratación con el ID de la reseña
            $this->db->query('UPDATE contrataciones SET resena_id = :resena_id WHERE id = :id');
            $this->db->bind(':resena_id', $resena_id);
            $this->db->bind(':id', $datos['contratacion_id']);
            $this->db->execute();

            // Recalcular el rating promedio del DJ
            $this->actualizarRatingDj($datos['dj_id']);
            return true;
        }
        return false;
    }

    // Recalcular rating del DJ
    private function actualizarRatingDj($dj_id) {
        $this->db->query('SELECT AVG(puntuacion) as promedio FROM resenas WHERE dj_id = :dj_id');
        $this->db->bind(':dj_id', $dj_id);
        $fila = $this->db->single();
        $promedio = $fila->promedio;

        $this->db->query('UPDATE perfiles_dj SET calificacion_promedio = :promedio WHERE usuario_id = :dj_id');
        $this->db->bind(':promedio', $promedio);
        $this->db->bind(':dj_id', $dj_id);
        $this->db->execute();
    }

    // Obtener reseñas de un DJ
    public function obtenerPorDj($dj_id) {
        $this->db->query('SELECT r.*, u.nombre as cliente_nombre 
                          FROM resenas r 
                          INNER JOIN usuarios u ON r.cliente_id = u.id 
                          WHERE r.dj_id = :dj_id 
                          ORDER BY r.fecha_creacion DESC');
        $this->db->bind(':dj_id', $dj_id);
        return $this->db->resultSet();
    }
}
