<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;


class Email {
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
       $this->email = $email; 
       $this->nombre = $nombre; 
       $this->token = $token; 
    }

    
    //Metodo para enviar correo
    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '849148c6c745d4';
        $mail->Password = 'e9d7accf207c98';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuntas@uptask.com','uptask.com');
        $mail->Subject = 'Confirma tucuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> Has creado tu cuenta en UpTask
        solo debes confirmarla en el siguiente enlace</p>";
        $contenido .= "<p>Presiona Aqui: <a href='http://localhost:8300/confirmar?token=" .
        $this->token . "'>Confirmar Cuenta<a></p>";
        $contenido .= "<p> Si tu no creaste esta cuenta, Ignora el Mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
        
    }

    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '849148c6c745d4';
        $mail->Password = 'e9d7accf207c98';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuntas@uptask.com','uptask.com');
        $mail->Subject = 'Restablece Tu password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> Has solicitado recuperar tu contraseña, a continuacion 
        preciona en el siguiente Enlace</p>";
        $contenido .= "<p>Presiona Aqui: <a href='http://localhost:8300/reestablecer?token=" .
        $this->token . "'>Confirmar Cuenta<a></p>";
        $contenido .= "<p> Si tu no solicitaste recuperar contraseña, Ignora el Mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();

    }
}

?>