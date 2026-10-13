<?php
// Inclure la connexion à la base de données
include '../server/inc/connection.php';

// Vérifier si la requête est une requête POST et qu'il y a une action et un ticket_id
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['ticket_id'])) {
        $ticketId = intval($_POST['ticket_id']); // Assurer une valeur entière
        $action = $_POST['action'];

        // Vérification de l'action
        if ($action === 'resolve') {
            $query = "UPDATE tickets SET status = 'Résolu' WHERE ticket_id = ?";
        } elseif ($action === 'delete') {
            $query = "DELETE FROM tickets WHERE ticket_id = ?";
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Action non valide']);
            exit();
        }

        // Exécuter la requête
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $ticketId);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur SQL']);
        }
        exit(); // Terminer après la requête AJAX
    }
}
?>
