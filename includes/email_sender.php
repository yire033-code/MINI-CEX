<?php
/**
 * Shared Email Sender Utility using PHPMailer
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

if (!function_exists('log_email_activity')) {
    function log_email_activity($message) {
        $logFile = __DIR__ . '/../email_log.log';
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] " . $message . "\n";
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
    }
}

if (!function_exists('sendEvaluationEmail')) {
    function sendEvaluationEmail($email, $nombreAlumno, $promedio, $pdfContent, $asuntoPrincipal, $calificacionTotal) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            log_email_activity("FAILED: Invalid email address provided: {$email}");
            return false;
        }

        $mail = new PHPMailer(true);

        try {
            // Server settings from config.php or fallback to gmail for App Passwords
            $mail->isSMTP();
            
            // Auto-heal Host if SMTP is configured for gmail username but host is still example.com
            $host = SMTP_HOST;
            if ($host === 'smtp.example.com' && (strpos(SMTP_USERNAME, '@gmail.com') !== false)) {
                $host = 'smtp.gmail.com';
            }
            
            $mail->Host       = $host;
            $mail->SMTPAuth   = SMTP_AUTH;
            $mail->Username   = SMTP_USERNAME;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            // Recipients
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($email, $nombreAlumno);
            $mail->addReplyTo(SMTP_FROM_EMAIL, SMTP_FROM_NAME);

            // Content
            $promedioFormat = number_format($promedio / 10, 1);
            $calificacionFormat = number_format($calificacionTotal / 10, 1);
            $subject = "Resumen de Evaluacion Clinica MINI-CEX - " . $nombreAlumno;
            
            $message = "
            <html>
            <head>
                <style>
                    body { font-family: 'Segoe UI', Arial, sans-serif; color: #1e293b; line-height: 1.6; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #edf0f4; border-radius: 14px; background-color: #ffffff; }
                    .header { text-align: center; border-bottom: 2px solid #edf0f4; padding-bottom: 20px; }
                    .header h2 { color: #1b5e96; margin: 0; }
                    .header span { color: #b8860b; font-weight: bold; font-size: 14px; }
                    .content { padding: 20px 0; }
                    .highlight { background-color: #f7f8fa; border-left: 4px solid #1b5e96; padding: 15px; margin: 15px 0; border-radius: 0 8px 8px 0; }
                    .score { font-size: 24px; font-weight: bold; color: #b8860b; }
                    .footer { border-top: 1px solid #edf0f4; padding-top: 15px; font-size: 12px; color: #94a3b8; text-align: center; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>Evaluación Clínica MINI-CEX</h2>
                        <span>Terapia Física y Rehabilitación</span>
                    </div>
                    <div class='content'>
                        <p>Hola, <strong>{$nombreAlumno}</strong>:</p>
                        <p>Se ha registrado una evaluación clínica en tu expediente.</p>
                        <div class='highlight'>
                            <p style='margin: 0 0 10px 0;'><strong>Detalles de la Evaluación:</strong></p>
                            <p style='margin: 5px 0;'>Asunto principal: <strong>{$asuntoPrincipal}</strong></p>
                            <p style='margin: 5px 0;'>Calificación en esta evaluación: <span class='score'>{$calificacionFormat}/10</span></p>
                            <p style='margin: 5px 0;'>Tu promedio general actual: <strong>{$promedioFormat}/10</strong></p>
                        </div>
                        <p>Adjunto a este correo encontrarás el reporte completo en formato PDF con el desglose de las competencias evaluadas, observaciones y planes de mejora correspondientes.</p>
                    </div>
                    <div class='footer'>
                        <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
                        <p>&copy; " . date('Y') . " Universidad - MINI-CEX Terapia Física</p>
                    </div>
                </div>
            </body>
            </html>";
            
            $altMessage = "Hola, {$nombreAlumno}:\n\n" .
                          "Se ha registrado una nueva evaluación en tu expediente.\n" .
                          "Asunto: {$asuntoPrincipal}\n" .
                          "Calificación: {$calificacionFormat}/10\n" .
                          "Promedio general: {$promedioFormat}/10\n\n" .
                          "Se adjunta el reporte en PDF.";

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $altMessage;

            // Attachment
            $filename = "MINICEX_Evaluacion_" . date('Ymd_His') . ".pdf";
            $mail->addStringAttachment($pdfContent, $filename, 'base64', 'application/pdf');

            $mail->send();
            log_email_activity("SUCCESS: Email sent to {$email} for student {$nombreAlumno}.");
            return true;
        } catch (Exception $e) {
            log_email_activity("FAILED: Email to {$email} for student {$nombreAlumno}. Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
