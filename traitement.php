<?php
session_start();
// Configuration de la base de données
$db = 'event';
$host = 'localhost';
$user = 'dsi24';
$password = 'dsi2425';

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification du formulaire soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['ok'])) { // Gestion de l'inscription
            $nom = trim($_POST['nom']);
            $email = trim($_POST['email']);
            $mot_de_passe = trim($_POST['mot_de_passe']);
            $confirm_mot_de_passe = trim($_POST['confirm_mot_de_passe']);
            $tel = trim($_POST['telephone']);
        
            // Validation de base
            if (empty($nom) || empty($email) || empty($mot_de_passe) || empty($confirm_mot_de_passe) || empty($tel)) {
                die("Tous les champs sont obligatoires.");
            }
        
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("Email invalide.");
            }
        
            if ($mot_de_passe !== $confirm_mot_de_passe) {
                die("Les mots de passe ne correspondent pas.");
            }
        
            if (!preg_match('/^\d{8}$/', $tel)) {
                die("Numéro de téléphone invalide. Il doit contenir 8 chiffres.");
            }
        
            // Hachage du mot de passe
            $hashed_password = password_hash($mot_de_passe, PASSWORD_BCRYPT);
        
            // Insertion dans la base de données (ajout de isadmin à 0 par défaut)
            $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, email, mot_de_passe, telephone, isadmin) VALUES (?, ?, ?, ?, 0)");
            $stmt->execute([$nom, $email, $hashed_password, $tel]);
            header("Location: inscription.php");
            exit;
        } elseif (isset($_POST['connexion'])) { // Gestion de la connexion
            $email = trim($_POST['email']);
            $mot_de_passe = trim($_POST['mot_de_passe']);

            if (empty($email) || empty($mot_de_passe)) {
                die("Tous les champs sont obligatoires.");
            }

            // Vérification des identifiants
            $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                // Stockage dans la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nom'];
                $_SESSION['isadmin'] = $user['isadmin'];  // Ajout de isadmin dans la session

                // Redirection vers la page index après la connexion
                header("Location: index.php");
                exit;  // S'assurer que le script s'arrête après la redirection
            } else {
                die("Email ou mot de passe incorrect.");
            }
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . htmlspecialchars($e->getMessage());
}
?>
