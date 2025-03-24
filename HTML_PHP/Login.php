<?php
session_start();

// Inclusion des fichiers nécessaires (Config.php crée déjà $conn)
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "Config.php");

// Vérification que la connexion est déjà établie
if (!isset($conn)) {
    die("Erreur interne : la connexion à la base n'est pas définie.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // La fonction trim permet de supprimer les espaces en début et fin de chaîne
    $userName     = trim($_POST['username']); // Récupération du nom d'utilisateur
    $userPassword = trim($_POST['password']);   // Récupération du mot de passe
  
    // Requête préparée pour vérifier si l'utilisateur existe
    $query = "SELECT id, password FROM login_streamwave WHERE username = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1 && $row = $result->fetch_assoc()) {
            if ($userPassword == $row['password']) { // Comparaison directe des mots de passe
                $_SESSION['user_id'] = $row['id'];
                header("Location: Accueil.php"); // Redirection vers la page d'accueil
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
        $stmt->close();
    } else {
        $error = "Erreur interne lors de la préparation de la requête.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StreamWave</title>
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
                <a href="Login.php">Connexion</a>
            </div>
        </nav>
        <!-- Fin de la barre de navigation -->
    </header>
    <div class="form-container">
        <div class="login-container">
            <div class="login-box">
                <h1>Connexion</h1>
                <?php
                if (isset($error)) {
                    echo "<p style='color:red;'>$error</p>"; // Affichage du message d'erreur
                }
                ?>
                <form action="login.php" method="post" id="login-form" class="form_style">
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
                        <button type="submit">S'identifier</button>
                    </div>
                </form>
                <div class="login-help">
                    <a href="Forgot_password.php">Mot de passe oublié ?</a>
                    <a href="Register.php">Créer un compte</a>
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