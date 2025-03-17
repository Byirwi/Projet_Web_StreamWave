<?php
session_start();
include('config.php'); // updated config inclusion

// Ensure $conn is initialized using DB credential variables defined in config.php
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['username']; // renamed variable for user input
    $userPassword = $_POST['password']; // renamed variable for user input

    // Requête pour vérifier le nom d'utilisateur dans login_streamwave
    $query = "SELECT * FROM login_streamwave WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userName); // use the renamed variable
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Vérification du mot de passe (vérification simple)
        if ($userPassword == $user['password']) { // use the renamed variable
            $_SESSION['user_id'] = $user['id'];
            header("Location: Accueil.php"); // Redirection modifiée vers Accueil.php
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
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
                    <img src="../Ressources/Logo StreamWave.png" alt="" height="80">
                </a>
            </div>
            <div class="droite">
                <a href="Login.php">Connexion</a>
            </div>
        </nav>
        <!-- Fin de la barre de navigation -->
    </header>
    <div class="test2">          <!-- Section formulaire -->
        <div class="login-container">
            <div class="login-box">
                <h1>Connexion</h1>
                <?php
                if (isset($error)) {
                    echo "<p style='color:red;'>$error</p>";
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
                    <a href="Register.php">Créer un compte</a>  <!-- Lien mis à jour pour register -->
                </div>
            </div>
        </div>
        <!-- Fin Section formulaire -->
        <!-- background img -->
        <div class="background_img">
            <img src="../Ressources/background/Netflix_background.png" alt="">
        </div>
        <!-- fin background img -->  
    </div> 
</body>
</html>