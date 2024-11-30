<?php
require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $lieu = $_POST['lieu'];
    $places = (int)$_POST['places'];
    //parmetres nommes
    $sql = "INSERT INTO Evenement (titre, description, date, lieu, places_disponibles) 
            VALUES (:titre, :description, :date, :lieu, :places)";
    //prepartion de l'execution dans SGBD (plus securisé)
    $stmt = $dsb->prepare($sql);
    $stmt->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':date' => $date,
        ':lieu' => $lieu,
        ':places' => $places
    ]);
    echo "Événement ajouté avec succès.";
}
// Récupération des événements
$result = $dsb->query("SELECT * FROM evenement");
$events = $result->fetchAll(PDO::FETCH_ASSOC);
?>
