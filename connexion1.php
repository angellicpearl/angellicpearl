<?php
session_start();

// Configuration de la base de données
$db = 'event';
$host = 'localhost';
$user = 'dsi24';
$password = 'dsi2425';

// Activer l'affichage des erreurs PHP (débogage)
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification du formulaire soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connexion'])) {
        $email = trim($_POST['email']);
        $mot_de_passe = trim($_POST['mot_de_passe']);

        // Vérification que les champs ne sont pas vides
        if (empty($email) || empty($mot_de_passe)) {
            die("Tous les champs sont obligatoires.");
        }

        // Vérification des identifiants
        $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si un utilisateur est trouvé et que le mot de passe est correct
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Stockage des informations de session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];

            // Débogage (enlève cette ligne après avoir vérifié)
            // echo "Connexion réussie. Bienvenue, " . htmlspecialchars($user['nom']) . "!";

            // Redirection après la connexion réussie
            header("Location: index.php");
            exit; // Assure-toi d'utiliser `exit` après une redirection pour arrêter l'exécution
        } else {
            die("Email ou mot de passe incorrect.");
        }
    }
} catch (PDOException $e) {
    // Afficher l'erreur de connexion
    echo "Erreur de connexion : " . htmlspecialchars($e->getMessage());
}
?>
