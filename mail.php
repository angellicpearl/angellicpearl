<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hrabisalma9@gmail.com';
    $mail->Password = 'bqka ovtt boga xxjm ';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('hrabisalma9@gmail.com', 'Test');
    $mail->addAddress('hrabisalma9@gmail.com'); // Remplacez par une adresse valide

    $mail->isHTML(true);
    $mail->Subject = 'Test email';
    $mail->Body = 'Ceci est un test.';

    $mail->send();
    echo 'Email envoyé avec succès.';
} catch (Exception $e) {
    echo "Erreur : " . $mail->ErrorInfo;
}
?>
