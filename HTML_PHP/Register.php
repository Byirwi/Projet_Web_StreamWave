<?php
session_start();
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "Config.php"); // Inclusion de Config.php depuis le dossier PHP
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "queries.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); // Récupération et nettoyage du nom d'utilisateur
    $password = trim($_POST['password']); // Récupération et nettoyage du mot de passe

    // Vérifier si l'utilisateur existe déjà
    $queryCheck = "SELECT id FROM login_streamwave WHERE username = ?";
    if ($stmt = $conn->prepare($queryCheck)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = "Nom d'utilisateur déjà existant.";
        } else {
            // Insertion du nouvel utilisateur
            $insertQuery = "INSERT INTO login_streamwave (username, password) VALUES (?, ?)";
            if ($stmtInsert = $conn->prepare($insertQuery)) {
                $stmtInsert->bind_param("ss", $username, $password);
                if ($stmtInsert->execute()) {
                    $success = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
                } else {
                    $error = "Erreur lors de la création du compte.";
                }
                $stmtInsert->close();
            } else {
                $error = "Erreur interne lors de la préparation de la requête d'insertion.";
            }
        }
        $stmt->close();
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>
<body>
    <header>
        <!-- Début de la barre de navigation -->
        <nav>
            <div class="gauche">
                <a href="Garde.php">
                    <img src="../Ressources/Logo StreamWave.png" alt="" height="80">
                </a>
            </div>
            <div class="droite">
                <a href="Login.php">
                    <p>Connexion</p>
                </a>
            </div>
        </nav>
        <!-- Fin de la barre de navigation -->
    </header>
    <div class="form-container">
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
            <img src="../Ressources/background/Netflix_background.png" alt="">
        </div>
    </div>
    <footer>
        <!-- Pied de page -->
        <h5>Des questions ? Appelez le 06 46 24 86 76</h5>
        <div class="colonnes">
            <!-- Colonnes du pied de page -->
            <div class="colonne">
                <p>FAQ</p>
                <p>Relations Investisseurs</p>
                <p>Modes de lecture</p>
                <p>Mentions légales</p>
                <p>Programmes originaux Netflix</p>
            </div>
            <div class="colonne">
                <p>Centre d'aide</p>
                <p>Relations Investisseurs</p>
                <p>Modes de lecture</p>
                <p>Mentions légales</p>
                <p>Programmes originaux Netflix</p>
            </div>
            <div class="colonne">
                <p>FAQ</p>
                <p>Recrutement</p>
                <p>Conditions d'utilisation</p>
                <p>Nous contacter</p>
            </div>
            <div class="colonne">
                <p>Compte</p>
                <p>Utiliser des cartes cadeaux</p>
                <p>Confidentialité</p>
                <p>Test de vitesse</p>
            </div>
        </div>
        <p>StreamWave, France</p>
    </footer>
</body>
</html>