<?php
// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "";
$db = "royal_express_db";
$con = new mysqli($host, $user, $password, $db);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Vérifier si les paramètres sont envoyés
if (isset($_POST['requestId']) && isset($_POST['status'])) {
    $requestId = $_POST['requestId'];
    $status = $_POST['status'];

    // Valider le statut (doit être 'accepted' ou 'rejected')
    if ($status !== 'accepted' && $status !== 'rejected') {
        echo "Erreur : statut invalide.";
        exit;
    }

    // Mettre à jour le statut de la demande dans la base de données
    $query = "UPDATE customer SET status = ? WHERE customer_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('si', $status, $requestId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
} else {
    echo 'Données manquantes.';
}

$con->close();
?>
