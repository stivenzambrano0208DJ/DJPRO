<?php
/**
 * Modelo de DJ
 */
class Dj extends Core\Model {
    
    // Obtener perfil por ID de usuario
    public function obtenerPerfil($usuario_id) {
        $this->db->query('SELECT perfiles_dj.*, usuarios.nombre, usuarios.correo, usuarios.fecha_registro 
                          FROM perfiles_dj 
                          INNER JOIN usuarios ON perfiles_dj.usuario_id = usuarios.id 
                          WHERE perfiles_dj.usuario_id = :usuario_id');
        $this->db->bind(':usuario_id', $usuario_id);
        return $this->db->single();
    }

    // Actualizar perfil
    public function actualizarPerfil($datos) {
        $sql = 'UPDATE perfiles_dj SET biografia = :biografia, lugares_trabajo = :lugares_trabajo, ciudad = :ciudad, departamento = :departamento, generos = :generos, tipos_evento = :eventos';
        
        if (!empty($datos['foto_perfil'])) {
            $sql .= ', foto_perfil = :foto_perfil';
        }
        
        $sql .= ' WHERE usuario_id = :usuario_id';
 
        $this->db->query($sql);
        $this->db->bind(':biografia', $datos['biografia']);
        $this->db->bind(':lugares_trabajo', $datos['lugares_trabajo']);
        $this->db->bind(':ciudad', $datos['ciudad']);
        $this->db->bind(':departamento', $datos['departamento']);
        $this->db->bind(':generos', $datos['generos']);
        $this->db->bind(':eventos', $datos['eventos']);
        $this->db->bind(':usuario_id', $datos['usuario_id']);
        
        if (!empty($datos['foto_perfil'])) {
            $this->db->bind(':foto_perfil', $datos['foto_perfil']);
        }

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Obtener géneros musicales maestros
    public function obtenerGeneros() {
        $this->db->query('SELECT * FROM generos');
        return $this->db->resultSet();
    }

    // Obtener tipos de eventos maestros
    public function obtenerTiposEvento() {
        $this->db->query('SELECT * FROM tipos_evento');
        return $this->db->resultSet();
    }

    // Obtener videos de la galería del DJ
    public function obtenerVideos($dj_id) {
        $this->db->query('SELECT * FROM dj_videos WHERE dj_id = :dj_id');
        $this->db->bind(':dj_id', $dj_id);
        return $this->db->resultSet();
    }

    // Agregar video a la galería
    public function agregarVideo($datos) {
        $this->db->query('INSERT INTO dj_videos (dj_id, url_video, titulo) VALUES (:dj_id, :url_video, :titulo)');
        $this->db->bind(':dj_id', $datos['dj_id']);
        $this->db->bind(':url_video', $datos['url_video']);
        $this->db->bind(':titulo', $datos['titulo']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Eliminar video
    public function eliminarVideo($id, $dj_id) {
        $this->db->query('DELETE FROM dj_videos WHERE id = :id AND dj_id = :dj_id');
        $this->db->bind(':id', $id);
        $this->db->bind(':dj_id', $dj_id);
        return $this->db->execute();
    }

    // Obtener estadísticas para el dashboard del DJ
    public function obtenerEstadisticas($dj_id) {
        // Solicitudes totales
        $this->db->query('SELECT COUNT(*) as total FROM contrataciones WHERE dj_id = :dj_id');
        $this->db->bind(':dj_id', $dj_id);
        $solicitudes = $this->db->single()->total;

        // Ganancias totales (Eventos terminados)
        $this->db->query('SELECT SUM(precio_total) as total FROM contrataciones WHERE dj_id = :dj_id AND estado = "terminada"');
        $this->db->bind(':dj_id', $dj_id);
        $ganancias = $this->db->single()->total ?? 0;

        // Eventos finalizados
        $this->db->query('SELECT COUNT(*) as total FROM contrataciones WHERE dj_id = :dj_id AND estado = "terminada"');
        $this->db->bind(':dj_id', $dj_id);
        $finalizados = $this->db->single()->total;

        // Eventos aceptados (pendientes de realizar)
        $this->db->query('SELECT COUNT(*) as total FROM contrataciones WHERE dj_id = :dj_id AND estado = "aceptada"');
        $this->db->bind(':dj_id', $dj_id);
        $aceptadas = $this->db->single()->total;

        // Total reseñas reales
        $this->db->query('SELECT COUNT(*) as total FROM resenas WHERE dj_id = :dj_id');
        $this->db->bind(':dj_id', $dj_id);
        $resenas = $this->db->single()->total;

        return [
            'solicitudes' => $solicitudes,
            'aceptadas' => $aceptadas,
            'ganancias' => $ganancias,
            'finalizados' => $finalizados,
            'resenas' => $resenas
        ];
    }
}
