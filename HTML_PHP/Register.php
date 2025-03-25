<?php
session_start();
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "Config.php"); // Inclusion du fichier de configuration depuis le dossier PHP

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); // Récupération et nettoyage du nom d'utilisateur
    $password = trim($_POST['password']); // Récupération et nettoyage du mot de passe

    // Vérification de l'existence de l'utilisateur dans la base de données
    $queryCheck = "SELECT id FROM login_streamwave WHERE username = ?";
    if ($stmt = $conn->prepare($queryCheck)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = "Nom d'utilisateur déjà existant.";
        } else {
            // Insertion d'un nouvel utilisateur dans la base de données
            $insertQuery = "INSERT INTO login_streamwave (username, password) VALUES (?, ?)";
            if ($stmtInsert = $conn->prepare($insertQuery)) {
                $stmtInsert->bind_param("ss", $username, $password);
                if ($stmtInsert->execute()) {
                    $success = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
                } else {
                    $error = "Erreur lors de la création du compte.";
                }
                $stmtInsert->close(); // Fermeture de la requête préparée
            } else {
                $error = "Erreur interne lors de la préparation de la requête d'insertion.";
            }
        }
        $stmt->close(); // Fermeture de la requête préparée
    } else {
        $error = "Erreur interne lors de la préparation de la requête de vérification.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/nav.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>
<body>
    <header>
        <!-- Début de la barre de navigation -->
        <nav>
            <div class="gauche">
                <a href="Garde.php">
                    <img src="../Public/Logo StreamWave.png" alt="" height="80">
                </a>
            </div>
            <div class="droite">
                <a href="Login.php">Connexion</a>
            </div>
        </nav>
        <!-- Fin de la barre de navigation -->in de la barre de navigation -->
    </header>
    <div class="form-container">s="form-container">
        <div class="login-container">
            <div class="login-box">
                <h1>Créer un compte</h1>
                <?php 
                if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } 
                if(isset($success)) { echo "<p style='color:green;'>$success</p>"; } 
                ?>
                <form action="Register.php" method="post" id="register-form" class="form_style">
                    <div class="mail_password_box">
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="login-button">
                        <button type="submit">Créer un compte</button>
                    </div>
                </form>
                <div class="login-help">
                    <a href="Login.php">Page de connexion</a>
                </div>
            </div>
        </div>
        <!-- Image de fond -->
        <div class="background_img">
            <img src="../Public/background/Netflix_background.png" alt="">
        </div>
    </div>
</body>
</html>