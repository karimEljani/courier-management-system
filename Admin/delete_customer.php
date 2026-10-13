<?php
include '../server/inc/connection.php'; // Inclure la connexion à la base de données

// Vérifier si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['customer_id'])) {
        $customerId = intval($_POST['customer_id']); // Sécuriser l'ID client

        // Exécuter la requête pour supprimer le client
        $query = "DELETE FROM customer WHERE customer_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $customerId);

        // Retourner une réponse JSON
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']); // Succès
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur SQL']); // Erreur
        }
        exit(); // Arrêter l'exécution
    }
}

// Répondre en cas de données manquantes ou méthode non valide
echo json_encode(['status' => 'error', 'message' => 'Requête non valide']);
exit();
?>
