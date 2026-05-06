<?php
/**
 * Modelo de Usuario
 */
class Usuario extends Core\Model {
    
    // Registrar usuario
    public function registrar($datos) {
        $this->db->query('INSERT INTO usuarios (nombre, correo, password, rol) VALUES (:nombre, :correo, :password, :rol)');
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':correo', $datos['correo']);
        $this->db->bind(':password', $datos['password']);
        $this->db->bind(':rol', $datos['rol']);

        if ($this->db->execute()) {
            // Si el usuario es DJ, crear entrada en perfiles_dj
            if ($datos['rol'] == 'dj') {
                $usuario_id = $this->db->lastInsertId();
                $this->db->query('INSERT INTO perfiles_dj (usuario_id) VALUES (:usuario_id)');
                $this->db->bind(':usuario_id', $usuario_id);
                $this->db->execute();
            }
            return true;
        } else {
            return false;
        }
    }

    // Buscar usuario por correo
    public function buscarUsuarioPorCorreo($correo) {
        $this->db->query('SELECT * FROM usuarios WHERE correo = :correo');
        $this->db->bind(':correo', $correo);
        return $this->db->single();
    }

    // Buscar usuario por ID
    public function buscarPorId($id) {
        $this->db->query('SELECT * FROM usuarios WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Login de usuario
    public function login($correo, $password) {
        $fila = $this->buscarUsuarioPorCorreo($correo);

        if ($fila) {
            $hashed_password = $fila->password;
            if (password_verify($password, $hashed_password)) {
                return $fila;
            }
        }
        return false;
    }

    // Contar usuarios por rol
    public function contarPorRol($rol) {
        $this->db->query('SELECT COUNT(*) as total FROM usuarios WHERE rol = :rol');
        $this->db->bind(':rol', $rol);
        $fila = $this->db->single();
        return $fila->total;
    }

    // Contar todas las contrataciones (necesitaremos este dato)
    public function contarContrataciones() {
        $this->db->query('SELECT COUNT(*) as total FROM contrataciones');
        $fila = $this->db->single();
        return $fila->total;
    }

    // Obtener todos los DJs con su perfil (con filtros opcionales)
    public function obtenerDjsConPerfil($filtros = [], $limite = null) {
        $sql = 'SELECT usuarios.*, perfiles_dj.foto_perfil, perfiles_dj.biografia, perfiles_dj.ciudad, perfiles_dj.departamento, perfiles_dj.calificacion_promedio, perfiles_dj.generos, perfiles_dj.tipos_evento 
                          FROM usuarios 
                          INNER JOIN perfiles_dj ON usuarios.id = perfiles_dj.usuario_id 
                          WHERE usuarios.rol = "dj"';
        
        // Aplicar filtros
        if (!empty($filtros['ciudad'])) {
            $sql .= ' AND perfiles_dj.ciudad = :ciudad';
        }
        if (!empty($filtros['genero'])) {
            $sql .= ' AND perfiles_dj.generos LIKE :genero';
        }
        if (!empty($filtros['evento'])) {
            $sql .= ' AND perfiles_dj.tipos_evento LIKE :evento';
        }

        $sql .= ' ORDER BY perfiles_dj.calificacion_promedio DESC';

        if ($limite) {
            $sql .= ' LIMIT ' . (int)$limite;
        }

        $this->db->query($sql);

        // Bindings
        if (!empty($filtros['ciudad'])) {
            $this->db->bind(':ciudad', $filtros['ciudad']);
        }
        if (!empty($filtros['genero'])) {
            $this->db->bind(':genero', '%' . $filtros['genero'] . '%');
        }
        if (!empty($filtros['evento'])) {
            $this->db->bind(':evento', '%' . $filtros['evento'] . '%');
        }

        return $this->db->resultSet();
    }

    // Obtener usuarios recientemente registrados
    public function obtenerUsuariosRecientes($limite = 5) {
        $this->db->query('SELECT id, nombre, correo, rol, fecha_registro FROM usuarios ORDER BY fecha_registro DESC LIMIT :limite');
        $this->db->bind(':limite', $limite);
        return $this->db->resultSet();
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

    // Obtener todos los usuarios
    public function obtenerTodos() {
        $this->db->query('SELECT * FROM usuarios ORDER BY fecha_registro DESC');
        return $this->db->resultSet();
    }

    // Actualizar usuario (Admin)
    public function actualizar($datos) {
        $this->db->query('UPDATE usuarios SET nombre = :nombre, correo = :correo, rol = :rol WHERE id = :id');
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':correo', $datos['correo']);
        $this->db->bind(':rol', $datos['rol']);
        return $this->db->execute();
    }

    // Eliminar usuario en cascada (Admin)
    public function eliminar($id) {
        // 1. Borrar reseñas relacionadas con las contrataciones de este usuario
        $this->db->query('DELETE FROM resenas WHERE contratacion_id IN (SELECT id FROM contrataciones WHERE cliente_id = :id OR dj_id = :id)');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // 2. Borrar mensajes (Usando los nombres de columna correctos: emisor_id y receptor_id)
        $this->db->query('DELETE FROM mensajes WHERE emisor_id = :id OR receptor_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // 3. Borrar contrataciones
        $this->db->query('DELETE FROM contrataciones WHERE cliente_id = :id OR dj_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // 4. Borrar perfil de DJ si existe
        $this->db->query('DELETE FROM perfiles_dj WHERE usuario_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // 5. Finalmente borrar el usuario
        $this->db->query('DELETE FROM usuarios WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
}
