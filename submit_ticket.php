<?php
include 'pages/head.php';

include 'server/inc/connection.php'; // Connexion à la base de données
include 'auth.php'; // Vérifie l'authentification

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $requestId = $_POST['request_id'] ?? null;
    $customerId = $_SESSION['customer'];
    $name = $_POST['name'] ?? '';
    $date = $_POST['date'] ?? date('Y-m-d');
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';

    // Vérification des champs obligatoires
    if (empty($requestId) || empty($description) || empty($category)) {
        echo "Veuillez remplir tous les champs obligatoires.";
        exit();
    }

    // Insertion dans la base de données
    $query = "
        INSERT INTO tickets (request_id, customer_id, name, date, description, category)
        VALUES (?, ?, ?, ?, ?, ?)
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iissss", $requestId, $customerId, $name, $date, $description, $category);

    if ($stmt->execute()) {
        echo "Ticket soumis avec succès.";
    } else {
        echo "Erreur lors de la soumission du ticket : " . $stmt->error;
    }
}
?>
