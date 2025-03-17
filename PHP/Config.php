<?php
$servername = "localhost";
$username = "Streamwave_account";
$password = "IPFs7J@tqG_Q(*0i";
$dbname = "streamwave"; // Changer le nom de la base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Création de la base de données si elle n'existe pas
$dbQuery = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($dbQuery) === FALSE) {
    die("Erreur de création de la base de données : " . $conn->error);
}

// Sélection de la base de données
$conn->select_db($dbname);

// Création de la table login_streamwave si elle n'existe pas
$tableQuery = "CREATE TABLE IF NOT EXISTS login_streamwave (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
)";
if ($conn->query($tableQuery) === FALSE) {
    die("Erreur de création de la table : " . $conn->error);
}
?>
