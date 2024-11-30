<?php
require 'connexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $dsb->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: liste-event.php');
    exit;
} else {
    die("ID invalide !");
}
?>
