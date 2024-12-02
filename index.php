<?php
session_start(); // Démarrer la session
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('connexion.php');

// Vérifier si un event_id est passé dans l'URL pour afficher les détails de l'événement
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;
if ($event_id) {
    // Récupérer les détails de l'événement
    $sql = "SELECT * FROM events WHERE id = ?";
    $stmt = $dsb->prepare($sql);
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    // Si l'événement n'existe pas
    if (!$event) {
        die("Événement introuvable.");
    }
}
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $sql = "SELECT * FROM events WHERE title LIKE ? OR description LIKE ?";    
    $stmt = $dsb->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->execute([$search_param, $search_param]);
} else {
    $sql = "SELECT * FROM events LIMIT 4"; // Par défaut, on affiche 4 événements
    $stmt = $dsb->prepare($sql);
    $stmt->execute();
}

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
$event_count = count($events); // Compter le nombre d'événements

if (empty($events)) {
    echo "<p>Aucun événement trouvé pour la recherche : " . htmlspecialchars($search) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/css/style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
<canvas id="cnv"></canvas>

<nav>
    <img src="assets/images/santa.jpeg">
    <ul>
    <form action="index.php" method="GET">
    <div class="search-container">
        <input type="text" name="search" placeholder="Rechercher un événement..." 
        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
        style="padding: 6px; font-size: 14px;">
        <button type="submit" style="padding: 6px 12px;">Rechercher</button>
    </div>
</form>

        <li><a href="index.php">Accueil</a></li>
        <li class="dropdown">
                <a href="#">Événements à venir ▼</a>
                <ul class="dropdown-menu">
                    <li><a href="liste-event.php">Liste des événements </a></li>
                    <li><a href="event.php"> Ajouter un événement</a></li>
                </ul>
            </li>
            <li><a href="mon-compte.php">Mon compte</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li class="user-greeting">
                Bonjour, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </li>
            <li><a href="déconnexion.php">Se déconnecter</a></li>
        <?php else: ?>
            <li><a href="inscription.php">Connexion</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div>
<h2 id="t2">Événements actuels</h2>
<div class="event-container <?php echo ($event_count == 1) ? 'single-event' : ''; ?>">
    <?php foreach ($events as $event): ?>
        <div class="event-card">
            <div class="event-image">
                <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="Event Image">
            </div>
            <div class="event-details">
                <h2 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h2>
                <p class="event-description"><?php echo htmlspecialchars($event['description']); ?></p>
                <p class="event-price">Prix: <?php echo htmlspecialchars($event['price']); ?></p><br>
                <button class="reserve-btn" onclick="window.location.href='reservation.php?event_id=<?php echo $event['id']; ?>'">Réserver</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</div>

<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2024 Mon Site Web. Tous droits réservés.</p>
        <ul class="footer-links">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">À propos</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>
</footer>

<script src="./assets/js/snow.js"></script>
</body>
</html>
