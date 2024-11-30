<?php
session_start();
require 'connexion-compte.php'; // Inclut la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $user_name = htmlspecialchars(trim($_POST['user_name']));
    $user_email = htmlspecialchars(trim($_POST['user_email']));
    $user_tel = htmlspecialchars(trim($_POST['user_tel']));
    $ancien_mdp = trim($_POST['ancien_mdp']);
    $nouveau_mdp = trim($_POST['nouveau_mdp']);
    $confirmation_mdp = trim($_POST['confirmation_mdp']);
    $user_id = $_SESSION['user_id'];

    // Vérifier si le mot de passe est confirmé
    if ($nouveau_mdp !== $confirmation_mdp) {
        die("Les nouveaux mots de passe ne correspondent pas.");
    }

    // Vérification de l'ancien mot de passe
    $stmt = $pdo->prepare("SELECT mot_de_passe FROM Utilisateur WHERE id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result || !password_verify($ancien_mdp, $result['mot_de_passe'])) {
        die("L'ancien mot de passe est incorrect.");
    }

    // Mise à jour des informations
    $hashed_mdp = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
    $update_stmt = $pdo->prepare("UPDATE Utilisateur SET nom = ?, email = ?, telephone = ?, mot_de_passe = ? WHERE id = ?");
    $success = $update_stmt->execute([$user_name, $user_email, $user_tel, $hashed_mdp, $user_id]);

    if ($success) {
        header("Location: index.php");
        exit;
    } else {
        die("Échec de la mise à jour des informations.");
    }
}
?>
