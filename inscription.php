<?php
session_start(); // Démarrer la session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- link css -->
    <link rel="stylesheet" href="assets/css/in.css">
    <!-- link icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" integrity="sha512-ZnR2wlLbSbr8/c9AgLg3jQPAattCUImNsae6NHYnS9KrIwRdcY9DxFotXhNAKIKbAXlRnujIqUWoXXwqyFOeIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
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
        <?php endif; ?>         </ul>
        </li>
        <li><a href="#contact">Mon compte</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li>Bonjour, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Invité'); ?></li>
            <li><a href="déconnexion.php">Se déconnecter</a></li>
        <?php else: ?>
            <li><a href="inscription.php">connexion</a></li>
        <?php endif; ?>
    </ul>
</nav>

<section>
    <div class="container">
        <div class="box">
            <!-- Formulaire de connexion -->
            <div class="form sign_in">
                <h3>Connexion</h3>
                <form method="POST" action="traitement.php" id="form_input">
                    <div class="type">
                        <input type="email" placeholder="Email" name="email" id="email" required>
                    </div>
                    <div class="type">
                        <input type="password" placeholder="Mot de passe" name="mot_de_passe" id="mot_de_passe" required>
                    </div>
                    <button class="btn bkg" type="submit" name="connexion">Se connecter</button>
                </form>
            </div>
            <!-- Formulaire d'inscription -->
            <div class="form sign_up">
                <h3>S'inscrire</h3>
                <form method="POST" action="traitement.php" id="form_input">
                    <div class="type">
                        <input type="text" name="nom" placeholder="Nom" id="nom" required>                    
                    </div>
                    <div class="type">
                        <input type="email" name="email" placeholder="Email" id="email" required>                    
                    </div>
                    <div class="type">
                        <input type="password" name="mot_de_passe" placeholder="Mot de passe" id="motdepasse" required>
                    </div>
                    <div class="type">
                        <input type="password" name="confirm_mot_de_passe" placeholder="Confirmer Mot de passe" id="confmotdepasse" required>
                    </div>
                    <div class="type">
                        <input type="tel" name="telephone" placeholder="Numéro de téléphone" id="telephone" required pattern="^\d{8}$" maxlength="8">
                    </div>
                    <button class="btn bkg" type="submit" name="ok">S'inscrire</button>
                </form>
            </div>
        </div>
                <div class="overlay">
            <div class="page page_signIn">
                <h3>Welcome Back!</h3>
                <p>To keep with us please login with your personal info</p>

                <button class="btn btnSign-in">Sign Up <i class="bi bi-arrow-right"></i></button>
            </div>

            <div class="page page_signUp">
                <h3>Hello Friend!</h3>
                <p>Enter your personal details and start journey with us</p>

                <button class="btn btnSign-up">
                    <i class="bi bi-arrow-left"></i> Sign In</button>
            </div>
        </div>
    </div>
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
<script>
document.getElementById('inscriptionForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const nom = document.getElementById('nom').value.trim();
    const email = document.getElementById('email').value.trim();
    const motdepasse = document.getElementById('motdepasse').value.trim();
    const confmotdepasse = document.getElementById('confmotdepasse').value.trim();
    const tel = document.getElementById('tel').value.trim();
    const telRegex = /^\d{8}$/;  // Accept 8 digits

    const telError = document.getElementById('telError');
    telError.textContent = '';  // Reset error message

    const errorMessages = document.querySelectorAll('.error');
    errorMessages.forEach(function(error) {
        error.textContent = ''; // Reset other error messages
    });

    let isValid = true;

    if (nom === '') {
        showError('nom', 'Le nom est requis.');
        isValid = false;
    }

    if (email === '') {
        showError('email', 'L\'email est requis.');
        isValid = false;
    } else {
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailRegex.test(email)) {
            showError('email', 'Veuillez entrer un email valide.');
            isValid = false;
        }
    }

    if (motdepasse === '') {
        showError('motdepasse', 'Le mot de passe est requis.');
        isValid = false;
    } else if (motdepasse.length < 6) {
        showError('motdepasse', 'Le mot de passe doit contenir au moins 6 caractères.');
        isValid = false;
    }

    if (confmotdepasse === '') {
        showError('confmotdepasse', 'Veuillez confirmer votre mot de passe.');
        isValid = false;
    } else if (motdepasse !== confmotdepasse) {
        showError('confmotdepasse', 'Les mots de passe ne correspondent pas.');
        isValid = false;
    }

    if (!telRegex.test(tel)) {
        telError.textContent = 'Veuillez entrer un numéro de téléphone valide avec 8 chiffres.';
        isValid = false;
    }

    if (isValid) {
        alert('Formulaire validé avec succès!');
    }
});

function showError(fieldId, message) {
    const errorElement = document.getElementById(fieldId).nextElementSibling;
    errorElement.textContent = message;
    errorElement.style.color = 'red';
}
</script>
<script src="assets/js/main.js"></script>
<script src="assets/js/snow.js"></script>
</body>
</html>
