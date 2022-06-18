<?php
	//print_r($_POST);
    if(empty($_POST["oculto"]) || empty($_POST["txtNombre"]) || empty($_POST["txtEmail"]) || empty($_POST["txtEmpresa"]) || empty($_POST["txtCargo"]) || empty($_POST["txtTelefono"])){
        header('Location: index.php?mensaje=falta');
        exit();
    }

    include_once 'model/conexion.php';
    $Nombre = $_POST["txtNombre"];
    $Email = $_POST["txtEmail"];
    $Empresa = $_POST["txtEmpresa"];
    $Cargo = $_POST["txtCargo"];
    $Telefono = $_POST["txtTelefono"];
    
    //Formato del asunto
$header = 'From: ' . $Email . " \r\n";
$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$header .= "Mime-Version: 1.0 \r\n";
$header .= "Content-Type: text/plain";
//Formato del mensaje
$mensaje = "Este mensaje fue enviado por " . $Nombre . ",\r\n";
$mensaje .= "Su e-mail es: " . $Email . " \r\n";
$mensaje .= "De la empresa: " . $Empresa . ",\r\n";
$mensaje .= "Su cargo es: " . $Cargo . ",\r\n";
$mensaje .= "Su número de teléfono es: " . $Telefono . ",\r\n";
$mensaje .= "Enviado el " . date('d/m/Y', time());

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
    $mail->setFrom($Email, utf8_decode($Nombre));
    $mail->addAddress('mioficina.co@gmail.com', 'Mi Oficina.co');     //Add a recipient
    $mail->addReplyTo('andres.rodriguez@mioficina.co', 'Información');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = utf8_decode('Nuevo mensaje de inscripción al evento');
    $mail->Body    = utf8_decode($header);
    $mail->Body    = utf8_decode($mensaje);

$paraCliente    = $Email;
$tituloCliente  = "Su inscripción ha sido realizada";
$mensajeCliente = "Buen día " . $_POST['txtNombre'] . ". Gracias por inscribirse a nuestro evento </strong>Pruebas de continuidad con VMware vSphere y AWS</strong>";

$cabecerasCliente  = 'MIME-Version: 1.0' . "\r\n";
$cabecerasCliente .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabecerasCliente .= 'From: Mi Oficina.co<servicios@mioficina.co>';
$enviadoCliente   = mail($paraCliente, $tituloCliente, $mensajeCliente, $cabecerasCliente);

$sentencia = $bd->prepare("INSERT INTO prueba(Nombre,Email,Empresa,Cargo,Telefono) VALUES (?, ?, ?, ?, ?);");
$resultado = $sentencia->execute([$Nombre,$Email,$Empresa,$Cargo,$Telefono]);
    
    $mail->send();
    header('Location: https://www.mioficina.co/mensaje-de-envio');
} catch (Exception $e) {
    header('Location: https://www.mioficina.co/mensaje-de-error');
}

?>