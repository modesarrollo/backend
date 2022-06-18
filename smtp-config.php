<?php

//Datos asignados a la inscripción mediante POST
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$empresa = $_POST['empresa'];
$ciudad = $_POST['ciudad'];
$subject = $_POST['subject'];
$mensaje = $_POST['mensaje'];
//Formato del asunto
$header = 'From: ' . $email . " \r\n";
$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$header .= "Mime-Version: 1.0 \r\n";
$header .= "Content-Type: text/plain";
//Formato del mensaje
$mensaje = "Este mensaje fue enviado por " . $nombre . ",\r\n";
$mensaje .= "Su número de teléfono es: " . $telefono . ",\r\n";
$mensaje .= "Su e-mail es: " . $email . " \r\n";
$mensaje .= "De la empresa: " . $empresa . ",\r\n";
$mensaje .= "De la ciudad de: " . $ciudad . ",\r\n";
$mensaje .= "Su asunto es: " . $subject . ",\r\n";
$mensaje .= "Mensaje: " . $_POST['mensaje'] . " \r\n";
$mensaje .= date_default_timezone_set('America/Bogota');
$mensaje .= "Enviado el " . date('l-d/m/Y g:i:s a', time());

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'mioficina.co@gmail.com';                     //SMTP username
    $mail->Password   = 'Oficina102938#';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($email, $nombre);
    $mail->addAddress('mioficina.co@gmail.com', 'Mi Oficina.co');     //Add a recipient
    $mail->addReplyTo('andres.rodriuez@mioficina.co', 'Información de datos de contacto de Mi Oficina.co');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = utf8_decode($subject);
    $mail->Body    = utf8_decode($header);
    $mail->Body    = utf8_decode($mensaje);

$paraCliente    = $email;
$tituloCliente  = "Su mensaje ha sido recibido";
$mensajeCliente = "Buen día " . $_POST['nombre'] . ". Muchas gracias por contactarnos, prontamente nuestra área comercial se comunicará con usted para atender su solicitud.</strong>";

$cabecerasCliente  = 'MIME-Version: 1.0' . "\r\n";
$cabecerasCliente .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabecerasCliente .= 'From: Mi Oficina.co<comercial@mioficina.co>';
$enviadoCliente   = mail($paraCliente, $tituloCliente, $mensajeCliente, $cabecerasCliente);

    $mail->send();
    header('Location: https://www.mioficina.co/contactenos-mensaje-enviado?mensaje=registrado');
} catch (Exception $e) {
    header('Location: https://www.mioficina.co/contactenos-mensaje-error?mensaje=error');
}

?>
