<?php

namespace Libraries;

use Database;
use Throwable;

/**
 * Invalidacion de sesiones por cambio de contrasena (token_version).
 *
 * Cada usuario tiene una columna `token_version` (entero). Al iniciar sesion se
 * guarda ese numero en $_SESSION['token_version']. En cada request comparamos el
 * valor de la sesion con el de la base de datos: si difieren, la contrasena se
 * cambio despues de que esta sesion se abrio, asi que la cerramos.
 *
 * Como DJPRO y NeivActiva comparten cuenta (mismo correo+contrasena), un cambio
 * de clave incrementa el contador en AMBAS bases, de modo que cerrar la sesion
 * en una app tambien cierra la de la otra.
 *
 * Regla de oro: esto NUNCA debe tumbar la app. Si algo falla (columna aun no
 * provisionada, DB inaccesible), se registra en el log y se continua (fail-open).
 */
class SessionGuard
{
    /**
     * Se asegura de que exista la columna usuarios.token_version. Usa un marcador
     * temporal para no consultar information_schema en cada request.
     */
    public static function ensureSchema(): void
    {
        $marcador = sys_get_temp_dir() . '/djpro_token_version.ok';
        if (is_file($marcador)) {
            return;
        }

        try {
            $db = new Database();
            $db->query(
                "SELECT COLUMN_NAME FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = 'usuarios'
                   AND COLUMN_NAME = 'token_version'"
            );
            if (!$db->single()) {
                $db->query('ALTER TABLE usuarios ADD COLUMN token_version INT NOT NULL DEFAULT 0');
                $db->execute();
            }
            @touch($marcador);
        } catch (Throwable $e) {
            error_log('[SessionGuard] ensureSchema: ' . $e->getMessage());
        }
    }

    /**
     * Cierra la sesion si el token_version guardado no coincide con el de la BD.
     * Debe llamarse en cada request, despues de session_start() y de cargar la
     * configuracion/base de datos.
     */
    public static function enforce(): void
    {
        if (empty($_SESSION['usuario_id'])) {
            return;
        }

        try {
            $db = new Database();
            $db->query('SELECT token_version FROM usuarios WHERE id = :id');
            $db->bind(':id', $_SESSION['usuario_id']);
            $fila = $db->single();

            // Si el usuario ya no existe, o cambio su token_version, cerramos.
            $versionBd = $fila ? (int) ($fila->token_version ?? 0) : 0;
            $versionSesion = isset($_SESSION['token_version']) ? (int) $_SESSION['token_version'] : 0;

            if (!$fila || $versionBd !== $versionSesion) {
                self::cerrarSesion();
            }
        } catch (Throwable $e) {
            // Fail-open: no rompemos la navegacion por un fallo de comprobacion.
            error_log('[SessionGuard] enforce: ' . $e->getMessage());
        }
    }

    private static function cerrarSesion(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => time() - 42000,
                'path' => $params['path'] ?? '/',
                'domain' => $params['domain'] ?? '',
                'secure' => (bool) ($params['secure'] ?? false),
                'httponly' => true,
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }
        session_destroy();

        $destino = (defined('URL_ROOT') ? URL_ROOT : '') . '/usuarios/login?msg=sesion_cerrada';
        header('Location: ' . $destino);
        exit;
    }
}
