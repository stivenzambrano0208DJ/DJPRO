<?php
namespace Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailSender {
    
    /**
     * Método base para enviar correos
     */
    private static function enviar($correo, $nombre, $asunto, $cuerpo, $altBody = '') {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = SMTP_USER !== '';
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            if (SMTP_SECURE !== '') {
                $mail->SMTPSecure = SMTP_SECURE === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : SMTP_SECURE;
            }
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';
            $mail->Timeout    = 5; // Timeout rápido de 5 segundos para no bloquear la aplicación

            /* 
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            */

            $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
            $mail->addAddress($correo, $nombre);

            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $cuerpo;
            $mail->AltBody = $altBody ?: strip_tags($cuerpo);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar correo: {$mail->ErrorInfo}");
            return false;
        }
    }

    public static function enviarBienvenida($correo, $nombre) {
        $asunto = "¡Bienvenido a DJPRO, $nombre!";
        $cuerpo = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee;'>
                <h2 style='color: #333;'>¡Hola, $nombre!</h2>
                <p>Gracias por registrarte en <strong>DJPRO</strong>. Tu cuenta ha sido creada con éxito.</p>
                <p>Ya puedes empezar a explorar nuestra plataforma, contactar DJs o gestionar tus eventos.</p>
                <br>
                <a href='" . URL_ROOT . "/usuarios/login' style='background-color: #f97316; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Iniciar Sesión</a>
                <br><br>
                <p>Saludos,<br>El equipo de DJPRO.</p>
            </div>
        ";
        return self::enviar($correo, $nombre, $asunto, $cuerpo);
    }

    // Notificar al DJ sobre una nueva reserva
    public static function enviarNotificacionReservaDj($correoDj, $nombreDj, $nombreCliente, $fechaEvento) {
        $asunto = "🔥 ¡Nueva solicitud de reserva para el $fechaEvento!";
        $cuerpo = "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background: #12121a; color: white; padding: 40px; border-radius: 20px; border: 1px solid #2a2a35;'>
                <h1 style='color: #f97316; text-transform: uppercase;'>¡Hola $nombreDj!</h1>
                <p style='font-size: 18px;'>Tienes una nueva solicitud de contratación en <strong>DJPRO</strong>.</p>
                <div style='background: #1c1c26; padding: 20px; border-radius: 15px; margin: 20px 0;'>
                    <p><strong>Cliente:</strong> $nombreCliente</p>
                    <p><strong>Fecha del Evento:</strong> $fechaEvento</p>
                </div>
                <p>Ingresa a tu panel de DJ para aceptar o rechazar esta solicitud.</p>
                <a href='" . URL_ROOT . "/djs/dashboard' style='display: inline-block; background: #f97316; color: white; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-weight: bold; margin-top: 20px;'>VER SOLICITUD</a>
                <p style='margin-top: 40px; font-size: 12px; color: #666;'>DJPRO Platform - Notificación Automática</p>
            </div>
        ";
        return self::enviar($correoDj, $nombreDj, $asunto, $cuerpo);
    }

    // Notificar al Cliente que su reserva fue aceptada
    public static function enviarNotificacionAceptacionCliente($correoCliente, $nombreCliente, $nombreDj, $fechaEvento) {
        $asunto = "✅ ¡Tu reserva con $nombreDj ha sido ACEPTADA!";
        $cuerpo = "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background: #12121a; color: white; padding: 40px; border-radius: 20px; border: 1px solid #2a2a35;'>
                <h1 style='color: #a855f7; text-transform: uppercase;'>¡Grandes noticias, $nombreCliente!</h1>
                <p style='font-size: 18px;'>El DJ <strong>$nombreDj</strong> ha aceptado tu solicitud para el evento del <strong>$fechaEvento</strong>.</p>
                <div style='background: #1c1c26; padding: 20px; border-radius: 15px; margin: 20px 0;'>
                    <p><strong>DJ:</strong> $nombreDj</p>
                    <p><strong>Estado:</strong> Confirmado ✅</p>
                </div>
                <p>Ahora puedes ponerte en contacto con el DJ a través del chat interno para coordinar los detalles finales.</p>
                <a href='" . URL_ROOT . "/chat' style='display: inline-block; background: #a855f7; color: white; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-weight: bold; margin-top: 20px;'>IR AL CHAT</a>
                <p style='margin-top: 40px; font-size: 12px; color: #666;'>DJPRO Platform - Notificación Automática</p>
            </div>
        ";
        return self::enviar($correoCliente, $nombreCliente, $asunto, $cuerpo);
    }

    // Notificar al Cliente que el evento terminó e invitar a dejar reseña
    public static function enviarNotificacionFinalizacionCliente($correoCliente, $nombreCliente, $nombreDj) {
        $asunto = "⭐ ¿Qué tal estuvo el show de $nombreDj?";
        $cuerpo = "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background: #12121a; color: white; padding: 40px; border-radius: 20px; border: 1px solid #2a2a35;'>
                <h1 style='color: #f97316; text-transform: uppercase;'>¡Evento Finalizado!</h1>
                <p style='font-size: 18px;'>Esperamos que tu evento con <strong>$nombreDj</strong> haya sido inolvidable.</p>
                <p>Tu opinión es muy importante para nuestra comunidad. ¿Podrías dedicar 1 minuto a calificar el servicio del DJ?</p>
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='" . URL_ROOT . "/clientes/dashboard' style='display: inline-block; background: #f97316; color: white; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-weight: bold;'>DEJAR RESEÑA ⭐⭐⭐⭐⭐</a>
                </div>
                <p style='font-size: 14px; color: #djpro-muted;'>Al dejar tu reseña ayudas a otros clientes a elegir el mejor talento.</p>
                <p style='margin-top: 40px; font-size: 12px; color: #666;'>DJPRO Platform - Gracias por confiar en nosotros</p>
            </div>
        ";
        return self::enviar($correoCliente, $nombreCliente, $asunto, $cuerpo);
    }
    // Notificar al Cliente que el DJ ACEPTÓ la reserva
    public static function enviarConfirmacionCliente($correoCliente, $nombreCliente, $nombreDj, $fechaEvento, $horario) {
        $asunto = "✅ ¡RESERVA CONFIRMADA! - $nombreDj ha aceptado tu solicitud";
        $cuerpo = "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background: #12121a; color: white; padding: 40px; border-radius: 20px; border: 1px solid #7c3aed;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <div style='background: #7c3aed; width: 60px; height: 60px; border-radius: 15px; margin: 0 auto; line-height: 60px; font-size: 30px;'>✅</div>
                </div>
                <h1 style='color: #7c3aed; text-transform: uppercase; text-align: center;'>¡Excelente Noticia!</h1>
                <p style='font-size: 18px; text-align: center;'>Hola <strong>$nombreCliente</strong>, el DJ <strong>$nombreDj</strong> ha aceptado tu solicitud de reserva.</p>
                
                <div style='background: #1c1c2e; padding: 25px; border-radius: 15px; margin: 30px 0;'>
                    <p style='margin: 0 0 10px 0; color: #64748b; font-size: 12px; text-transform: uppercase; font-weight: bold;'>Detalles del Evento:</p>
                    <p style='margin: 5px 0; font-size: 16px;'>📅 Fecha: <strong>$fechaEvento</strong></p>
                    <p style='margin: 5px 0; font-size: 16px;'>⏰ Horario: <strong>$horario</strong></p>
                </div>

                <p style='text-align: center;'>Ya puedes contactar directamente al DJ a través del chat de la plataforma para coordinar los últimos detalles.</p>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='" . URL_ROOT . "/chat' style='display: inline-block; background: #f97316; color: white; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-weight: bold;'>IR AL CHAT</a>
                </div>
                
                <p style='margin-top: 40px; font-size: 12px; color: #666; text-align: center;'>DJPRO Platform - Conectando con la mejor música</p>
            </div>
        ";
        return self::enviar($correoCliente, $nombreCliente, $asunto, $cuerpo);
    }
    // Notificar al DJ que el cliente canceló
    public static function enviarNotificacionCancelacionDj($correoDj, $nombreDj, $nombreCliente, $fechaEvento) {
        $asunto = "⚠️ CANCELACIÓN: Reserva de $nombreCliente para el $fechaEvento";
        $cuerpo = "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background: #12121a; color: white; padding: 40px; border-radius: 20px; border: 1px solid #ff4444;'>
                <h1 style='color: #ff4444; text-transform: uppercase;'>Reserva Cancelada</h1>
                <p style='font-size: 18px;'>Hola $nombreDj, te informamos que el cliente <strong>$nombreCliente</strong> ha cancelado la solicitud para el día <strong>$fechaEvento</strong>.</p>
                <p>Tu calendario vuelve a estar disponible para esa fecha.</p>
                <p style='margin-top: 40px; font-size: 12px; color: #666;'>DJPRO Platform - Notificación de Sistema</p>
            </div>
        ";
        return self::enviar($correoDj, $nombreDj, $asunto, $cuerpo);
    }

    // Notificar al Cliente que el DJ canceló
    public static function enviarNotificacionCancelacionCliente($correoCliente, $nombreCliente, $nombreDj, $fechaEvento) {
        $asunto = "⚠️ AVISO: Tu reserva con $nombreDj ha sido cancelada";
        $cuerpo = "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background: #12121a; color: white; padding: 40px; border-radius: 20px; border: 1px solid #ff4444;'>
                <h1 style='color: #ff4444; text-transform: uppercase;'>Reserva Cancelada</h1>
                <p style='font-size: 18px;'>Hola $nombreCliente, sentimos informarte que el DJ <strong>$nombreDj</strong> no podrá asistir a tu evento el día <strong>$fechaEvento</strong> y ha cancelado la reserva.</p>
                <p>Te invitamos a buscar otros DJs disponibles en nuestra plataforma para que tu evento no se quede sin música.</p>
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='" . URL_ROOT . "/djs/explorar' style='display: inline-block; background: #f97316; color: white; padding: 15px 30px; text-decoration: none; border-radius: 10px; font-weight: bold;'>BUSCAR OTRO DJ</a>
                </div>
                <p style='margin-top: 40px; font-size: 12px; color: #666;'>DJPRO Platform - Lamentamos los inconvenientes</p>
            </div>
        ";
        return self::enviar($correoCliente, $nombreCliente, $asunto, $cuerpo);
    }

    // Enviar correo de recuperación con CÓDIGO de 6 dígitos
    public static function enviarRecuperacion($correo, $nombre, $codigo) {
        $asunto = "🔐 Código de Seguridad - DJPRO";
        $cuerpo = "
            <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background: #12121a; color: white; padding: 40px; border-radius: 20px; border: 1px solid #2a2a35;'>
                <h1 style='color: #f97316; text-transform: uppercase;'>Recuperar Cuenta</h1>
                <p style='font-size: 18px;'>Hola $nombre, usa el siguiente código para restablecer tu contraseña:</p>
                <div style='text-align: center; margin: 40px 0;'>
                    <span style='display: inline-block; background: #1c1c26; color: #f97316; font-size: 48px; font-weight: bold; padding: 20px 40px; border-radius: 15px; letter-spacing: 10px; border: 2px solid #f97316;'>$codigo</span>
                </div>
                <p style='font-size: 14px; color: #djpro-muted; text-align: center;'>Este código es válido por tiempo limitado. No compartas este código con nadie.</p>
                <p style='margin-top: 40px; font-size: 12px; color: #666; text-align: center;'>DJPRO Platform - Seguridad de Cuenta</p>
            </div>
        ";
        return self::enviar($correo, $nombre, $asunto, $cuerpo);
    }
}
