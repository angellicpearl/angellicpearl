
<?php
session_start(); // Démarrer la session
require_once('connexion.php');

// Vérifier si un event_id est passé dans l'URL pour afficher les détails de l'événement
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

if ($event_id) {
    // Récupérer les détails de l'événement
    $sql = "SELECT * FROM events WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'événement n'existe pas
    if (!$event) {
        die("Événement introuvable.");
    }
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia&effect=neon|outline|emboss|shadow-multiple">
</head>

<body>
<nav>
    <canvas id="cnv"></canvas>
    <img src="assets/images/santa.jpeg">
    <ul>
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
          
            <li>Bonjour, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Invité'); ?></li>
  
            <li><a href="déconnexion.php">Se déconnecter</a></li>
                        <!-- Si l'utilisateur est administrateur -->
                        <?php if ($_SESSION['isadmin'] == 1): ?>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="inscription.php">Connexion</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div>
<?php
    require_once('connexion.php');
    $sql = "SELECT * FROM events LIMIT 4"; 
    $stmt = $dsb->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <h2 id="t2">Événements actuels</h2>
    <div class="event-container">
        <?php
            require_once('connexion.php');
        ?>
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
    <div class="footer-socials">
        <p>Suivez-nous :</p>
        <ul>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Instagram</a></li>
        </ul>
    </div>
</footer>
<script src="./assets/js/snow.js"></script>
</body>
</html>
