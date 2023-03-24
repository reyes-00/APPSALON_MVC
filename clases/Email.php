<?php

namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
  
  public $nombre;
  public $email;
  public $token;

  public function __construct($nombre, $email,$token){

    $this->nombre = $nombre;
    $this->email = $email;
    $this->token = $token;
  }

  public function enviarConfirmacion(){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = 'e6954ad4db04b8';
    $mail->Password = 'c6746fe979f696';

    // Set Html

    $mail->isHTML(true);
    $mail->CharSet = 'utf-8';

    $mail-> setFrom( 'cuentas@appsalon.com');
    $mail-> addAddress('cuenta@appsalon.com');
    $mail->Subject = 'Confirma tu cuenta';

    $contenido = "<html>";
    $contenido .="<p><strong>Hola: ".$this->nombre ."</strong></p>";
    $contenido .="<p>Para confirmar tu cuenta da click en el siguiente enlace :";
    $contenido .= "<a href='http://localhost:3000/confirmar-cuenta?token=".$this->token."'>Aqui</a></p>";
    $contenido .= "</html>";
    
    $mail-> Body = $contenido;
    $mail->send();

  }

  public function enviarInstrucciones(){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = 'e6954ad4db04b8';
    $mail->Password = 'c6746fe979f696';

    // Set Html

    $mail->isHTML(true);
    $mail->CharSet = 'utf-8';

    $mail-> setFrom( 'cuentas@appsalon.com');
    $mail-> addAddress('cuenta@appsalon.com');
    $mail->Subject = 'Restablecer tu cuenta';

    $contenido = "<html>";
    $contenido .="<p><strong>Hola: ".$this->nombre ."</strong></p>";
    $contenido .="<p>Para restablecer tu cuenta da click en el siguiente enlace :";
    $contenido .= "<a href='http://localhost:3000/recuperar?token=".$this->token."'>Aqui</a></p>";
    $contenido .= "</html>";
    
    $mail-> Body = $contenido;
    $mail->send();
  }

}

?>