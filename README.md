# DJPRO

Aplicacion web PHP tipo MVC para gestion de DJs, clientes, reservas, resenas y mensajeria.

## Requisitos

- PHP 8.x con PDO MySQL habilitado
- MySQL/MariaDB
- Apache con `mod_rewrite`
- XAMPP en desarrollo local

## Configuracion

La aplicacion lee configuracion desde variables de entorno. Usa `.env.example` como referencia y configura estos valores en Apache, XAMPP o el entorno donde ejecutes PHP:

- `URL_ROOT`: URL publica de la aplicacion.
- `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`: conexion a MySQL.
- `SMTP_HOST`, `SMTP_USER`, `SMTP_PASS`, `SMTP_PORT`, `SMTP_SECURE`, `SMTP_FROM`, `SMTP_FROM_NAME`: envio de correos. Usa `SMTP_SECURE=tls` para proveedores que requieren STARTTLS.

No guardes credenciales reales dentro de `config/config.php` ni en archivos publicos.

## Ejecucion local

1. Copia el proyecto en `c:\xampp\htdocs\djro_v3.0`.
2. Crea la base de datos indicada en `DB_NAME` e importa el esquema/datos del proyecto si aplica.
3. Configura las variables de entorno o usa los valores locales por defecto para desarrollo.
4. Abre `http://localhost/djro_v3.0` en el navegador.

## Seguridad aplicada

- Las contrasenas nuevas se guardan con `password_hash`.
- Si existe una contrasena antigua en texto claro, se migra automaticamente a hash tras un login correcto.
- Las consultas del modelo usan PDO con parametros preparados.
- Los formularios y endpoints POST validan token CSRF.
- Las cookies de sesion usan `HttpOnly`, `SameSite=Lax`, modo estricto y `Secure` cuando se sirve por HTTPS.
- Los scripts publicos de diagnostico/migracion (`public/check_db.php`, `public/update_db.php`) fueron neutralizados.
- Las credenciales SMTP y de base de datos salen de variables de entorno.

## Recomendaciones pendientes

- Mover migraciones de base de datos fuera de `public/` y ejecutarlas solo por CLI.
- Convertir acciones sensibles que hoy usan rutas GET a formularios POST con CSRF.
- Agregar pruebas automatizadas para autenticacion, autorizacion y reservas.
- Revisar autorizacion por recurso en cada endpoint administrativo y API.
- Rotar cualquier credencial que haya estado versionada o expuesta.

## Contribucion

- Mantener controladores, modelos y vistas separados.
- Usar consultas preparadas y validacion de entrada para toda interaccion con base de datos.
- No subir secretos, dumps de produccion ni archivos temporales.
- Ejecutar `php -l` sobre archivos modificados antes de entregar cambios.
