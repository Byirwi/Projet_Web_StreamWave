<?php
session_start();
include('config.php'); // Fichier de configuration pour la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification si le nom d'utilisateur existe déjà
    $query = "SELECT * FROM login_streamwave WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insertion du nouvel utilisateur
        $insertQuery = "INSERT INTO login_streamwave (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ss", $username, $password); // Ajout du type pour le mot de passe
        if ($stmt->execute()) {
            $success = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
        } else {
            $error = "Erreur lors de la création du compte.";
        }
    } else {
        $error = "Nom d'utilisateur déjà pris.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
</head>
<body>
    <h2>Créer un compte</h2>
    <form method="post" action="register.php">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Créer un compte</button>
    </form>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <?php if (isset($success)) { echo "<p>$success</p>"; } ?>
</body>
</html>
