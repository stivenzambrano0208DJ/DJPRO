<?php
/**
 * Modelo de Usuario
 */
class Usuario extends Core\Model {
    
    // Registrar usuario
    public function registrar($datos) {
        $this->db->query('INSERT INTO usuarios (nombre, username, correo, password, rol) VALUES (:nombre, :username, :correo, :password, :rol)');
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':username', $datos['username'] ?? null);
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

    // Buscar usuario por Username
    public function buscarPorUsername($username) {
        $this->db->query('SELECT * FROM usuarios WHERE username = :username');
        $this->db->bind(':username', $username);
        return $this->db->single();
    }

    // Buscar perfil de DJ específico por ID de usuario
    public function buscarDjPerfil($id) {
        $this->db->query('SELECT u.*, p.*,
                                (SELECT GROUP_CONCAT(g.nombre) FROM dj_generos dg JOIN generos g ON dg.genero_id = g.id WHERE dg.dj_id = u.id) as generos,
                                (SELECT GROUP_CONCAT(te.nombre) FROM dj_tipos_evento dte JOIN tipos_evento te ON dte.tipo_evento_id = te.id WHERE dte.dj_id = u.id) as tipos_evento
                          FROM usuarios u 
                          JOIN perfiles_dj p ON u.id = p.usuario_id 
                          WHERE u.id = :id');
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
        if (is_numeric($filtros)) {
            $limite = $filtros;
            $filtros = [];
        }

        $sql = 'SELECT u.*, p.foto_perfil, p.biografia, p.lugares_trabajo, p.ciudad, p.departamento, p.calificacion_promedio, p.precio_hora,
                       (SELECT GROUP_CONCAT(g.nombre) FROM dj_generos dg JOIN generos g ON dg.genero_id = g.id WHERE dg.dj_id = u.id) as generos,
                       (SELECT GROUP_CONCAT(te.nombre) FROM dj_tipos_evento dte JOIN tipos_evento te ON dte.tipo_evento_id = te.id WHERE dte.dj_id = u.id) as tipos_evento
                FROM usuarios u 
                INNER JOIN perfiles_dj p ON u.id = p.usuario_id 
                WHERE u.rol = "dj"';
        
        // Aplicar filtros
        if (!empty($filtros['ciudad'])) {
            $sql .= ' AND p.ciudad = :ciudad';
        }
        if (!empty($filtros['genero'])) {
            $sql .= ' AND EXISTS (SELECT 1 FROM dj_generos dg2 JOIN generos g2 ON dg2.genero_id = g2.id WHERE dg2.dj_id = u.id AND g2.nombre LIKE :genero)';
        }
        if (!empty($filtros['evento'])) {
            $sql .= ' AND EXISTS (SELECT 1 FROM dj_tipos_evento dte2 JOIN tipos_evento te2 ON dte2.tipo_evento_id = te2.id WHERE dte2.dj_id = u.id AND te2.nombre LIKE :evento)';
        }

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

    // Obtener todos los usuarios con paginación
    public function obtenerTodos($limit = null, $offset = null) {
        $sql = 'SELECT * FROM usuarios ORDER BY fecha_registro DESC';
        if ($limit !== null) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        if ($offset !== null) {
            $sql .= ' OFFSET ' . (int)$offset;
        }
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    // Actualizar usuario (Admin)
    public function actualizar($datos) {
        $this->db->query('UPDATE usuarios SET nombre = :nombre, username = :username, correo = :correo, rol = :rol WHERE id = :id');
        $this->db->bind(':id', $datos['id']);
        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':username', $datos['username']);
        $this->db->bind(':correo', $datos['correo']);
        $this->db->bind(':rol', $datos['rol']);
        return $this->db->execute();
    }

    // Actualizar solo el username
    public function actualizarUsername($id, $username) {
        $this->db->query('UPDATE usuarios SET username = :username WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':username', $username);
        return $this->db->execute();
    }

    // [ADMIN] Obtener DJs para sección Seguridad
    public function obtenerDjsConCredenciales() {
        $this->db->query('SELECT id, nombre, username, correo FROM usuarios WHERE rol = "dj" ORDER BY nombre ASC');
        return $this->db->resultSet();
    }

    // [ADMIN] Actualización Maestra de Credenciales
    public function actualizarMaster($datos) {
        $sql = 'UPDATE usuarios SET username = :username, correo = :correo';
        if (isset($datos['password'])) {
            $sql .= ', password = :password';
        }
        $sql .= ' WHERE id = :id';

        $this->db->query($sql);
        $this->db->bind(':username', $datos['username']);
        $this->db->bind(':correo', $datos['correo']);
        $this->db->bind(':id', $datos['id']);
        if (isset($datos['password'])) {
            $this->db->bind(':password', $datos['password']);
        }
        return $this->db->execute();
    }

    // Guardar token de recuperación
    public function guardarTokenRecuperacion($email, $token) {
        $this->db->query('DELETE FROM recuperacion_claves WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();

        $this->db->query('INSERT INTO recuperacion_claves (email, token) VALUES (:email, :token)');
        $this->db->bind(':email', $email);
        $this->db->bind(':token', $token);
        return $this->db->execute();
    }

    // Validar token de recuperación
    public function validarTokenRecuperacion($token) {
        $this->db->query('SELECT * FROM recuperacion_claves WHERE token = :token');
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    // Actualizar contraseña por email
    public function actualizarPassword($email, $password) {
        $this->db->query('UPDATE usuarios SET password = :password WHERE correo = :email');
        $this->db->bind(':email', $email);
        $this->db->bind(':password', $password);
        
        if ($this->db->execute()) {
            $this->db->query('DELETE FROM recuperacion_claves WHERE email = :email');
            $this->db->bind(':email', $email);
            $this->db->execute();
            return true;
        }
        return false;
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
