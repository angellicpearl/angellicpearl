<?php
session_start();
// Vérifier si les informations sont présentes dans la session, sinon rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: inscription.php");
    exit;
}

// Vérifier si le formulaire a été soumis et traiter la mise à jour des informations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que les données sont correctement filtrées
    $_SESSION['user_name'] = htmlspecialchars($_POST['user_name']);
    $_SESSION['user_email'] = htmlspecialchars($_POST['user_email']);
    $_SESSION['user_tel'] = htmlspecialchars($_POST['user_tel']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/css/compte.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia&effect=neon|outline|emboss|shadow-multiple">
</head>
<body>
<canvas id="cnv"></canvas>
<nav>
    <img src="assets/images/santa.jpeg">
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li class="dropdown">
                <a href="#">Événements à venir ▼</a>
                <ul class="dropdown-menu">
                    <li><a href="liste-event.php">Liste des événements </a></li>
                    <?php if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1): ?>
            <li><a href="event.php">Ajouter un événement</a></li>
        <?php endif; ?>             </ul>
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
<div class="compte-container">
        <form method="POST" action="modification.php">
        <div class="compte-info">
            <label for="user_name"><strong>Nom :</strong></label>
            <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>

            <label for="user_email"><strong>Email :</strong></label>
            <input type="email" id="user_email" name="user_email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" required>

            <label for="user_tel"><strong>Numéro de téléphone :</strong></label>
            <input type="text" id="user_tel" name="user_tel" value="<?php echo htmlspecialchars($_SESSION['user_tel']); ?>" required>

            <!-- Champs pour les mots de passe -->
            <label for="ancien_mdp"><strong>Ancien mot de passe :</strong></label>
            <input type="password" id="ancien_mdp" name="ancien_mdp" required>

            <label for="nouveau_mdp"><strong>Nouveau mot de passe :</strong></label>
            <input type="password" id="nouveau_mdp" name="nouveau_mdp" required>

            <label for="confirmation_mdp"><strong>Confirmation de mot de passe :</strong></label>
            <input type="password" id="confirmation_mdp" name="confirmation_mdp" required>
        </div>

    <button type="submit">Sauvegarder les modifications</button>
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
<script src="assets/js/snow.js"></script>
</body>
</html>