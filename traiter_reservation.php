<?php
session_start();
require_once('connexion.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("location : inscription.php");
}

// Vérifier si les données du formulaire sont envoyées
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur_id = $_SESSION['user_id'];
    $evenement_id = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);
    $places_demandees = filter_input(INPUT_POST, 'places_demandees', FILTER_VALIDATE_INT);

    if (!$evenement_id || !$places_demandees || $places_demandees < 1) {
        die("Données invalides.");
    }

    try {
        // Vérifier si l'événement existe et récupérer les places disponibles
        $sql = "SELECT places_disponibles, titre FROM Evenement WHERE id = ?";
        $stmt = $dsb->prepare($sql);
        $stmt->execute([$evenement_id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            die("L'événement n'existe pas.");
        }

        // Insérer la réservation dans la table Reservation
        $sql = "INSERT INTO Reservation (utilisateur_id, evenement_id, nombre_de_places) 
                VALUES (?, ?, ?)";
        $stmt = $dsb->prepare($sql);
        $stmt->execute([$utilisateur_id, $evenement_id, $places_demandees]);

        // Mettre à jour le nombre de places restantes dans la table Evenement
        $places_restantes = $places_disponibles - $places_demandees;
        $sql = "UPDATE Evenement SET places_disponibles = ? WHERE id = ?";
        $stmt = $dsb->prepare($sql);
        $stmt->execute([$places_restantes, $evenement_id]);

        // Envoyer un email de confirmation
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
            // Contenu du message
            $mail->isHTML(true);
            $mail->Subject = 'Réservation confirmée';
            $mail->Body    = 'Votre réservation est confirmée, vous êtes les bienvenus !';

            // Envoi de l'email
            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur d'envoi d'email : {$mail->ErrorInfo}");
        }

        // Rediriger avec un message de succès
        header("Location: confirmation.php?success=1");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la réservation : " . htmlspecialchars($e->getMessage());
    }
} else {
    die("Aucune donnée reçue.");
}
