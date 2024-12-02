<?php
session_start(); // Démarrer la session
require_once('connexion.php');

// Vérifier si un event_id est passé dans l'URL
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

if ($event_id) {
    // Récupérer les détails de l'événement
    $sql = "SELECT * FROM events WHERE id = ?";
    $stmt = $dsb->prepare($sql); // Utilisez $dsb ici, pas $pdo
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'événement n'existe pas
    if (!$event) {
        die("Événement introuvable.");
    }
} else {
    die("Aucun événement sélectionné.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation</title>
    <link rel="stylesheet" href="assets/css/compte.css">
</head>
<script>
        var isUserLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
        function checkLoginAndReserve() {
    if (!isUserLoggedIn) {
        // Rediriger vers la page d'inscription si l'utilisateur n'est pas connecté
        window.location.href = 'inscription.php';
    } else {
        // Si l'utilisateur est connecté, exécuter la logique de réservation
        alert("Réservation effectuée !");
    }
}    
    </script>
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
            <li class="user-greeting">
                Bonjour, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </li>
            <li><a href="déconnexion.php">Se déconnecter</a></li>
            <!-- Si l'utilisateur est administrateur -->
            <?php if ($_SESSION['isadmin'] == 1): ?>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="inscription.php">Connexion</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div class="reservation-details-container">
    <div class="event-header">
        <h2>Réservation de l'événement</h2>
        <h3><?php echo htmlspecialchars($event['title']); ?></h3>
    </div>

    <div class="event-details">
        <div class="event-info">
            <form action="traiter_reservation.php" method="POST">
            <label for="description">Description :</label>
                <textarea id="description" readonly> <?php echo htmlspecialchars($event['description']); ?></p></textarea><br>
                </labe>
                <label for="prix">
                <p><strong>Prix:</strong> <?php echo htmlspecialchars($event['price']); ?></p>
                </label>
                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                    <label for="places_demandees">Nombre de places :</label>
                    <input type="number" name="places_demandees" id="places_demandees" min="1" max="<?php echo $event['places_disponibles']; ?>" required>
                    <button class="reserve-btn" onclick="checkLoginAndReserve()" onclick="window.location.href='reservation.php?event_id=<?php echo $event['id']; ?>'">Réserver</button>
            </div>
                </form>
        </div>
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
