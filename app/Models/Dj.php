<?php
/**
 * Modelo de DJ
 */
class Dj extends Core\Model {
    
    // Obtener perfil por ID de usuario
    public function obtenerPerfil($usuario_id) {
        $this->db->query('SELECT p.*, u.nombre, u.username, u.correo, u.fecha_registro, u.verificado,
                                (SELECT GROUP_CONCAT(g.id) FROM dj_generos dg JOIN generos g ON dg.genero_id = g.id WHERE dg.dj_id = u.id) as generos_ids,
                                (SELECT GROUP_CONCAT(te.id) FROM dj_tipos_evento dte JOIN tipos_evento te ON dte.tipo_evento_id = te.id WHERE dte.dj_id = u.id) as eventos_ids,
                                (SELECT GROUP_CONCAT(g.nombre) FROM dj_generos dg JOIN generos g ON dg.genero_id = g.id WHERE dg.dj_id = u.id) as generos,
                                (SELECT GROUP_CONCAT(te.nombre) FROM dj_tipos_evento dte JOIN tipos_evento te ON dte.tipo_evento_id = te.id WHERE dte.dj_id = u.id) as tipos_evento
                          FROM perfiles_dj p
                          INNER JOIN usuarios u ON p.usuario_id = u.id 
                          WHERE p.usuario_id = :usuario_id');
        $this->db->bind(':usuario_id', $usuario_id);
        return $this->db->single();
    }

    // Actualizar perfil
    public function actualizarPerfil($datos) {
        $sql = 'UPDATE perfiles_dj SET biografia = :biografia, lugares_trabajo = :lugares_trabajo, ciudad = :ciudad, departamento = :departamento, precio_hora = :precio_hora, auto_respuesta = :auto_respuesta, bot_activo = :bot_activo';
        
        if (!empty($datos['foto_perfil'])) {
            $sql .= ', foto_perfil = :foto_perfil';
        }
        
        $sql .= ' WHERE usuario_id = :usuario_id';

        $this->db->query($sql);
        $this->db->bind(':biografia', $datos['biografia']);
        $this->db->bind(':lugares_trabajo', $datos['lugares_trabajo']);
        $this->db->bind(':ciudad', $datos['ciudad']);
        $this->db->bind(':departamento', $datos['departamento']);
        $this->db->bind(':precio_hora', $datos['precio_hora']);
        $this->db->bind(':auto_respuesta', $datos['auto_respuesta']);
        $this->db->bind(':bot_activo', $datos['bot_activo']);
        $this->db->bind(':usuario_id', $datos['usuario_id']);
        
        if (!empty($datos['foto_perfil'])) {
            $this->db->bind(':foto_perfil', $datos['foto_perfil']);
        }

        if ($this->db->execute()) {
            // Actualizar Géneros (Pivot)
            $this->db->query('DELETE FROM dj_generos WHERE dj_id = :dj_id');
            $this->db->bind(':dj_id', $datos['usuario_id']);
            $this->db->execute();

            if (!empty($datos['generos'])) {
                $generos = is_array($datos['generos']) ? $datos['generos'] : explode(',', $datos['generos']);
                foreach ($generos as $genId) {
                    $this->db->query('INSERT INTO dj_generos (dj_id, genero_id) VALUES (:dj_id, :gen_id)');
                    $this->db->bind(':dj_id', $datos['usuario_id']);
                    $this->db->bind(':gen_id', $genId);
                    $this->db->execute();
                }
            }

            // Actualizar Tipos de Evento (Pivot)
            $this->db->query('DELETE FROM dj_tipos_evento WHERE dj_id = :dj_id');
            $this->db->bind(':dj_id', $datos['usuario_id']);
            $this->db->execute();

            if (!empty($datos['eventos'])) {
                $eventos = is_array($datos['eventos']) ? $datos['eventos'] : explode(',', $datos['eventos']);
                foreach ($eventos as $evId) {
                    $this->db->query('INSERT INTO dj_tipos_evento (dj_id, tipo_evento_id) VALUES (:dj_id, :ev_id)');
                    $this->db->bind(':dj_id', $datos['usuario_id']);
                    $this->db->bind(':ev_id', $evId);
                    $this->db->execute();
                }
            }

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

    // Obtener estadísticas para el dashboard del DJ (WARN-004: Optimizado en una sola consulta)
    public function obtenerEstadisticas($dj_id) {
        $this->db->query('
            SELECT 
                COUNT(*) as solicitudes,
                SUM(CASE WHEN estado = "aceptada" THEN 1 ELSE 0 END) as aceptadas,
                SUM(CASE WHEN estado = "terminada" THEN precio_total ELSE 0 END) as ganancias,
                SUM(CASE WHEN estado = "terminada" THEN 1 ELSE 0 END) as finalizados,
                (SELECT COUNT(*) FROM resenas WHERE dj_id = :dj_id_sub) as resenas
            FROM contrataciones 
            WHERE dj_id = :dj_id
        ');
        
        $this->db->bind(':dj_id', $dj_id);
        $this->db->bind(':dj_id_sub', $dj_id);
        
        $row = $this->db->single();

        return [
            'solicitudes' => $row->solicitudes ?? 0,
            'aceptadas' => $row->aceptadas ?? 0,
            'ganancias' => $row->ganancias ?? 0,
            'finalizados' => $row->finalizados ?? 0,
            'resenas' => $row->resenas ?? 0
        ];
    }

    // Obtener proyección de servicios (últimos 6 meses) específicos para un DJ
    public function obtenerProyeccionMensual($dj_id) {
        $this->db->query("SELECT
                            DATE_FORMAT(fecha_creacion, '%b') as mes,
                            DATE_FORMAT(fecha_creacion, '%Y-%m') as periodo,
                            COUNT(*) as total
                          FROM contrataciones
                          WHERE dj_id = :dj_id
                          AND fecha_creacion >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                          GROUP BY DATE_FORMAT(fecha_creacion, '%Y-%m'), DATE_FORMAT(fecha_creacion, '%b')
                          ORDER BY periodo ASC");
        $this->db->bind(':dj_id', $dj_id);
        return $this->db->resultSet();
    }
}
