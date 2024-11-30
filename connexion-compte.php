<?php
// Database configuration
$db = 'event';
$host = 'localhost';
$user = 'dsi24';
$password = 'dsi2425';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connexion réussie : pas besoin d'afficher un message ici
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
?>
