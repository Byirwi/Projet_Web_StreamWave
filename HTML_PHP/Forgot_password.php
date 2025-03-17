<?php
session_start();
include('Test/config.php'); // Inclusion du fichier de configuration

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
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <h2>Mot de passe oublié</h2>
    <form action="forgot_password.php" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="new_password">Nouveau mot de passe :</label>
        <input type="password" id="new_password" name="new_password" required>
        <br>
        <button type="submit">Changer le mot de passe</button>
    </form>
    <?php
    if (isset($error)) { echo "<p style='color:red;'>$error</p>"; }
    if (isset($success)) { echo "<p style='color:green;'>$success</p>"; }
    ?>
</body>
</html>
