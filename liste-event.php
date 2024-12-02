<?php
session_start();
$isAdmin = $_SESSION['isadmin'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Événements</title>
    <link rel="stylesheet" href="assets/css/inscription.css">
    <link rel="stylesheet" href="assets/css/liste-event.css">
</head>
<body>
    <!-- Menu de navigation -->
    <nav>
        <canvas id="cnv"></canvas>
        <img src="assets/images/santa.jpeg" alt="Logo">
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

    <!-- Liste des événements -->
    <div class="events-container">
        <?php
        require 'connexion.php'; // Inclure la connexion à la base de données
        // Récupérer tous les événements depuis la table 'events'
        $result = $dsb->query("SELECT * FROM events");

        if ($result->rowCount() > 0): // Vérifier si des résultats existent
            while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="event-card">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Image de l'événement">
            <div class="event-description">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
            </div>
            <div class="event-actions">
                <?php if ($isAdmin==1): ?>
                    <a href="edit-event.php?id=<?= $row['id']; ?>" class="btn btn-edit">Modifier</a>
                    <a href="delete-event.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Voulez-vous vraiment supprimer cet événement ?')">Supprimer</a>
                <?php else: ?>
                    <!-- Si l'utilisateur n'est pas administrateur, afficher le bouton réserver -->
                    <a href="reservation.php?event_id=<?php echo $row['id']; ?>" class="btn btn-reserve">Réserver</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
            <p>Aucun événement trouvé.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
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

    <?php
    // Inclure le fichier PHP qui contient la logique
    require_once('event-config.php');
    ?>
    <script src="./assets/js/snow.js"></script>
</body>
</html>