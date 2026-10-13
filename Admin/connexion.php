<?php
session_start();
include '../server/inc/connection.php'; // Inclure la connexion à la base de données

// Initialisation des variables
$email = $password = "";
$emailErr = $passwordErr = "";
$error = "";

// Vérification de la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validation des champs email et mot de passe
    if (empty($email)) {
        $emailErr = "L'email est requis.";
    }
    if (empty($password)) {
        $passwordErr = "Le mot de passe est requis.";
    }

    // Si aucune erreur dans la validation
    if (empty($emailErr) && empty($passwordErr)) {
        // Préparation de la requête SQL avec mysqli pour éviter l'injection SQL
        $sql = "SELECT * FROM customer WHERE email = ?";
        $stmt = mysqli_prepare($con, $sql); // Utilisation de la connexion $con avec mysqli
        mysqli_stmt_bind_param($stmt, "s", $email); // Lier l'email comme paramètre
        mysqli_stmt_execute($stmt); // Exécuter la requête

        $result = mysqli_stmt_get_result($stmt); // Récupérer le résultat de la requête
        $user = mysqli_fetch_assoc($result); // Récupérer les données de l'utilisateur

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) { 
            // Vérification du statut de la demande
            if ($user['status'] == 'accepted') {
                // L'utilisateur a été accepté, démarrer la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['fullName'] = $user['fullName'];
                $_SESSION['company'] = $user['company'];

                // Redirection vers le tableau de bord ou la page principale
                header("Location: ../index.php");
                exit; // S'assurer que le script s'arrête après la redirection
            } elseif ($user['status'] == 'pending') {
                $error = "Votre demande est en attente d'approbation.";
            } elseif ($user['status'] == 'rejected') {
                $error = "Votre demande a été rejetée.";
            }
        } else {
            // Si les identifiants sont incorrects
            $error = "Identifiants invalides.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <div class="login-container">
        <h2>Se connecter</h2>

        <!-- Affichage des erreurs -->
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

        <form method="POST" action="">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>
            <span class="error"><?= $emailErr ?></span>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            <span class="error"><?= $passwordErr ?></span>

            <button type="submit">Se connecter</button>
        </form>

        <p>Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
    </div>
</body>
</html>
