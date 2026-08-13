<?php

namespace Libraries;

use PDO;
use Throwable;

/**
 * Sincronizacion de cuentas con la plataforma hermana NeivActiva.
 *
 * DJPRO y NeivActiva tienen bases de datos SEPARADAS, pero queremos que el mismo
 * correo + contrasena sirva para iniciar sesion en ambas. Las dos usan
 * password_hash()/password_verify() de PHP, asi que basta con replicar la cuenta
 * (o su contrasena) en la base de datos de la otra app.
 *
 * Regla de oro: esto NUNCA debe romper el flujo de DJPRO. Si NeivActiva no esta
 * accesible, se registra el error en el log y se continua con normalidad.
 *
 * Configuracion (opcional) via variables de entorno; por defecto asume que ambas
 * bases viven en el mismo servidor MySQL con las mismas credenciales:
 *   NEIV_DB_HOST, NEIV_DB_NAME, NEIV_DB_USER, NEIV_DB_PASS
 */
class AccountSync
{
    /**
     * Lee una variable de entorno de forma fiable: primero getenv() (lo que
     * inyecta Docker/Dokploy) y si no, $_ENV como respaldo.
     */
    private static function env(string $clave, ?string $porDefecto = null): ?string
    {
        $v = getenv($clave);
        if ($v !== false && $v !== '') {
            return $v;
        }
        if (isset($_ENV[$clave]) && $_ENV[$clave] !== '') {
            return (string) $_ENV[$clave];
        }
        return $porDefecto;
    }

    private static function conexionNeivactiva(): PDO
    {
        $host = self::env('NEIV_DB_HOST', self::env('DB_HOST', 'localhost'));
        $port = self::env('NEIV_DB_PORT', '3306');
        $name = self::env('NEIV_DB_NAME', 'neivactiva_db');
        $user = self::env('NEIV_DB_USER', self::env('DB_USER', 'root'));
        $pass = self::env('NEIV_DB_PASS', self::env('DB_PASS', ''));

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    /**
     * Crea la cuenta espejo en NeivActiva si el correo aun no existe alli.
     * Si ya existe, se respeta (no se toca su contrasena).
     */
    public static function alRegistrar(string $nombre, string $correo, string $passwordPlano): void
    {
        $correo = strtolower(trim($correo));
        if ($correo === '' || $passwordPlano === '') {
            return;
        }

        try {
            $pdo = self::conexionNeivactiva();

            $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE correo = ? LIMIT 1');
            $stmt->execute([$correo]);
            if ($stmt->fetch()) {
                return; // Ya existe en NeivActiva: no lo tocamos.
            }

            $ins = $pdo->prepare(
                'INSERT INTO usuarios (nombre, correo, documento_identidad, telefono, password, rol)
                 VALUES (?, ?, NULL, NULL, ?, "cliente")'
            );
            $ins->execute([
                trim($nombre),
                $correo,
                password_hash($passwordPlano, PASSWORD_DEFAULT),
            ]);
        } catch (Throwable $e) {
            error_log('[AccountSync->NeivActiva] alRegistrar: ' . $e->getMessage());
        }
    }

    /**
     * Propaga un cambio de contrasena a NeivActiva (solo si el correo existe alli).
     */
    public static function alCambiarPassword(string $correo, string $passwordPlano): void
    {
        $correo = strtolower(trim($correo));
        if ($correo === '' || $passwordPlano === '') {
            return;
        }

        try {
            $pdo = self::conexionNeivactiva();
            $upd = $pdo->prepare('UPDATE usuarios SET password = ? WHERE correo = ?');
            $upd->execute([
                password_hash($passwordPlano, PASSWORD_DEFAULT),
                $correo,
            ]);
        } catch (Throwable $e) {
            error_log('[AccountSync->NeivActiva] alCambiarPassword: ' . $e->getMessage());
        }
    }
}
