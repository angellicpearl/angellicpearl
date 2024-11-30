<?php
session_start();
require_once('connexion.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour effectuer une réservation.");
}

// Vérifier si les données du formulaire sont envoyées
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur_id = $_SESSION['user_id'];
    $evenement_id = $_POST['event_id'];
    $places_demandees = $_POST['places_demandees']; // Le nombre de places demandées par l'utilisateur

    try {
        // Vérifier si l'événement existe et récupérer les places disponibles
        $sql = "SELECT places_disponibles FROM Evenement WHERE id = ?";
        $stmt = $dsb->prepare($sql);
        $stmt->execute([$evenement_id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            die("L'événement n'existe pas.");
        }

        $places_disponibles = $event['places_disponibles'];

        // Vérifier si suffisamment de places sont disponibles
        if ($places_demandees > $places_disponibles) {
            die("Pas assez de places disponibles pour cet événement.");
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

        echo "Réservation effectuée avec succès.";
        // Rediriger vers une page de confirmation ou afficher un message
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la réservation : " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Aucune donnée reçue.";
}
?>
