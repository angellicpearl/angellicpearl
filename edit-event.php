<?php
session_start(); // Démarrer la session
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/event.css">
    <title>Modifier l'événement</title>
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
    <h1>Modifier l'événement</h1>
        <?php
        require 'connexion.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $dsb->prepare("SELECT * FROM events WHERE id = ?");
            $stmt->execute([$id]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$event) {
                die("Événement non trouvé !");
            }
        } else {
            die("ID invalide !");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $event_date = $_POST['event_date'];
                $location = $_POST['location'];
                $places = $_POST['places'];
        
                if (empty($title) || empty($description) || empty($event_date) || empty($location) || empty($places)) {
                    die("Tous les champs sont obligatoires !");
                }
        
                $stmt = $dsb->prepare("UPDATE Evenement SET titre = ?, description = ?, date = ?, lieu = ?, places_disponibles = ? WHERE id = ?");
                $stmt->execute([$title, $description, $event_date, $location, $places, $id]);

                echo "<script>
                    alert('L\'événement a été modifié avec succès !');
                    window.location.href = 'liste-event.php';
                </script>";
                exit;
            } catch (PDOException $e) {
                die("Erreur lors de la mise à jour : " . $e->getMessage());
            }
        }
        
        
        ?>
    <form action="" method="POST">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($event['description']); ?></textarea><br>

        <label for="event_date">Date :</label>
        <input type="date" id="event_date" name="event_date" value="<?php echo htmlspecialchars($event['event_date']); ?>" required><br>

        <label for="location">Lieu :</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required><br>

        <label for="places">Nombre de places :</label>
        <input type="number" id="places" name="places" value="<?php echo htmlspecialchars($event['places']); ?>" required><br>

        <button type="submit">Modifier</button>
    </form>
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
