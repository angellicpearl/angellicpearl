<?php
session_start();

require 'connexion.php';

// Check if the form is submitted via POST
//
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collecter les datas
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $lieu = $_POST['lieu'];
    $places = (int)$_POST['places'];

    try {
        $sql = "INSERT INTO Evenement (titre, description, date, lieu, places_disponibles) 
                VALUES (:titre, :description, :date, :lieu, :places)";
        $stmt = $dsb->prepare($sql);

        // liaison des parameters avec les variables
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':lieu', $lieu);
        $stmt->bindParam(':places', $places, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "Événement ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout de l'événement.";
        }
    } catch (PDOException $e) {
        // Display error message if query fails
        echo "Erreur : " . $e->getMessage();
    }
}
try {
    $result = $dsb->query("SELECT * FROM Evenement");
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un événement</title>
    <link rel="stylesheet" href="assets/css/style3.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="bodyy">
<canvas id="cnv"></canvas>
    <nav>
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
    <section>
        <!-- Marquee Section -->
        <marquee behaviour="scroll" direction="left" scrollamount="20" loop="1000">
            <img src="assets/images/sanat1.png" alt="Left scrolling image">
        </marquee>
        <div class="container">
            <div class="cap">
                <img src="assets/images/santacap.png" alt="Santa cap">
            </div>
            <div class="header">
                <h2>Nouvel événement</h2>
            </div>
            <form method="POST" action="">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre" placeholder="Nom de l'événement" required>
                
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Détails de l'événement" required></textarea>
                
                <label for="date">Date</label>
                <input type="datetime-local" id="date" name="date" required>
                
                <label for="lieu">Lieu</label>
                <input type="text" id="lieu" name="lieu" placeholder="Lieu de l'événement" required>
                
                <label for="places">Nombre de places</label>
                <input type="number" id="places" name="places" min="1" placeholder="Nombre total de places" required>
                
                <button type="submit">Ajouter l'Événement</button>
            </form>
        </div>

        <!-- Marquee Section -->

        <div id="status"></div>
    </section>
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
