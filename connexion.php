<?php
// Database configuration
$db = 'event';
$host = 'localhost';
$user = 'dsi24';
$password = 'dsi2425';

try {
    // Establishing a connection with PDO
    $dsb = new PDO("mysql:host=$host;dbname=$db", $user, $password);

    //Permet une gestion des erreurs plus propre 
    $dsb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL statement
    $stmt = $dsb->prepare("SELECT * FROM events");
    $stmt->execute();

    // Récupérer les résultats sous forme de tableau associatif
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if the result is empty
    if (empty($events)) {
        echo "<p>Aucun événement trouvé.</p>";
    }
} catch (PDOException $e) {
    // Dafficher un message d erruer
    echo "Erreur lors de la connexion à la base de données : " . htmlspecialchars($e->getMessage());
    die;
}
?>