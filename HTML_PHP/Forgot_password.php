<?php
session_start();
ini_set('display_errors', 1); // Activation de l'affichage des erreurs
error_reporting(E_ALL); // Rapport de toutes les erreurs PHP
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "Config.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "queries.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username     = trim($_POST['username']);    // Récupération et nettoyage du nom d'utilisateur
    $new_password = trim($_POST['new_password']); // Récupération et nettoyage du nouveau mot de passe

    // Vérification de l'existence de l'utilisateur dans la base de données
    $query = "SELECT id FROM login_streamwave WHERE username = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            // Mise à jour du mot de passe dans la base de données
            $updateQuery = "UPDATE login_streamwave SET password = ? WHERE username = ?";
            if ($stmtUpdate = $conn->prepare($updateQuery)) {
                $stmtUpdate->bind_param("ss", $new_password, $username);
                if ($stmtUpdate->execute()) {
                    $success = "Mot de passe mis à jour avec succès. Vous pouvez désormais vous connecter.";
                } else {
                    $error = "Erreur lors de la mise à jour du mot de passe.";
                }
                $stmtUpdate->close(); // Fermeture de la requête préparée
            } else {
                $error = "Erreur interne lors de la préparation de la requête de mise à jour.";
            }
        } else {
            $error = "Nom d'utilisateur introuvable.";
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
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="../CSS/styles.css">
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
                <a href="Login.php"><p>Connexion</p></a>
            </div>
        </nav>
        <!-- Fin de la barre de navigation -->
    </header>
    <div class="content">
        <div class="form-container">
            <!-- Ajout de la classe "forgot" pour ajuster la carte -->
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
                <img src="../Public/background/Netflix_background.png" alt="">
            </div>
        </div>
    </div>
</body>
</html>
