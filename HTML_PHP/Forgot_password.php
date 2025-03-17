<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('../Test/config.php'); // Inclusion du fichier de configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];

    // Vérifier si l'utilisateur existe
    $query = "SELECT * FROM login_streamwave WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        // Mise à jour du mot de passe
        $updateQuery = "UPDATE login_streamwave SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ss", $new_password, $username);
        if ($stmt->execute()) {
            $success = "Mot de passe mis à jour avec succès. Vous pouvez désormais vous connecter.";
        } else {
            $error = "Erreur lors de la mise à jour du mot de passe.";
        }
    } else {
        $error = "Nom d'utilisateur introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <style>
        body {
            background-image: url('../images/background.jpg'); // update path as needed
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body>
    <header>
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
    </header>
    <div class="content">
        <div class="test2">
            <div class="login-container">
                <div class="login-box">
                    <h1>Mot de passe oublié</h1>
                    <?php
                    if (isset($error)) { echo "<p style='color:red;'>$error</p>"; }
                    if (isset($success)) { echo "<p style='color:green;'>$success</p>"; }
                    ?>
                    <form action="forgot_password.php" method="post" id="forgot-password-form" class="form_style">
                        <div class="mail_password_box">
                            <div class="form-group">
                                <label for="username">Nom d'utilisateur :</label>
                                <input type="text" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Nouveau mot de passe :</label>
                                <input type="password" id="new_password" name="new_password" required>
                            </div>
                        </div>
                        <div class="login-button">
                            <button type="submit">Changer le mot de passe</button>
                        </div>
                    </form>
                    <div class="login-help">
                        <a href="Login.php">Page de connexion</a>
                    </div>
                </div>
            </div>
            <div class="background_img">
                <img src="../Ressources/background/Netflix_background.png" alt="">
            </div>
        </div>
    </div>
    <footer>
        <h5>Des questions ? Appelez le 06 46 24 86 76</h5>
        <div class="colonnes">
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
