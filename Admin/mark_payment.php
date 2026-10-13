<?php
// Connexion à la base de données
include '../server/inc/connection.php';

// Vérifier si la requête est une demande POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si les données nécessaires sont présentes
    if (isset($_POST['sender_phone']) && isset($_POST['payment_status'])) {
        $senderPhone = $_POST['sender_phone'];
        $paymentStatus = $_POST['payment_status'];

        // Si le statut de paiement est 'Paid'
        if ($paymentStatus == 'Paid') {
            // Vérifier si le paiement n'a pas déjà été enregistré
            $query = "
                INSERT INTO payments (request_id, sender_phone, total_fee, status, payment_date)
                SELECT request_id, sender_phone, total_fee, 'Paid', NOW()
                FROM request
                WHERE sender_phone = ? AND tracking_status = 4 AND NOT EXISTS (
                    SELECT 1 FROM payments WHERE request_id = request.request_id AND sender_phone = request.sender_phone
                )
            ";
        } else {
            // Si le statut est 'Unpaid', supprimer l'enregistrement du paiement
            $query = "
                DELETE FROM payments
                WHERE sender_phone = ? AND request_id IN (
                    SELECT request_id FROM request WHERE sender_phone = ? AND tracking_status = 4
                )
            ";
        }

        // Préparer et exécuter la requête
        if ($stmt = $con->prepare($query)) {
            // Pour l'INSERT, vous devez lier un paramètre pour 'sender_phone'
            if ($paymentStatus == 'Paid') {
                $stmt->bind_param("s", $senderPhone); // Lier le téléphone de l'expéditeur
            } else {
                $stmt->bind_param("ss", $senderPhone, $senderPhone); // Lier deux paramètres pour 'sender_phone' dans le DELETE
            }

            if ($stmt->execute()) {
                echo 'success'; // Réponse de succès
            } else {
                // Afficher l'erreur détaillée si l'exécution échoue
                echo 'Error executing query: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            // Afficher l'erreur si la préparation de la requête échoue
            echo 'Error preparing query: ' . $con->error;
        }
    } else {
        echo 'Missing required parameters (sender_phone or payment_status).';
    }
} else {
    echo 'Invalid request method. Please use POST.';
}
?>
