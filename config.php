<?php

require 'connexion.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
	$pdo = new PDO($dsn, $user, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	if ($pdo) {
		
	}
} catch (PDOException $e) {
	echo "$e getMessage()";
}
