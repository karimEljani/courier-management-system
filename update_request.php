<?php
include 'server/inc/connection.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données POST
    $request_id = $_POST['request_id'] ?? null;
    $new_address = $_POST['new_address'] ?? null;
    $new_phone = $_POST['new_phone'] ?? null;
    $new_packages = $_POST['new_packages'] ?? null;
    $new_price = $_POST['new_price'] ?? null;
    $new_sender_phone = $_POST['new_sender_phone'] ?? null;
    $new_send_location = $_POST['new_send_location'] ?? null;
    $new_end_location = $_POST['new_end_location'] ?? null;

    // Vérifier les champs obligatoires
    if (!$request_id || !$new_address || !$new_phone || !$new_packages || !$new_price || !$new_sender_phone || !$new_send_location || !$new_end_location) {
        echo 'missing_fields';
        exit;
    }

    // Préparer la requête SQL
    $query = "UPDATE request 
              SET red_address = ?, 
                  res_phone = ?, 
                  nbre_paquets = ?, 
                  total_fee = ?, 
                  sender_phone = ?, 
                  send_location = ?, 
                  end_location = ? 
              WHERE request_id = ?";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssidsiii", $new_address, $new_phone, $new_packages, $new_price, $new_sender_phone, $new_send_location, $new_end_location, $request_id);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo 'success'; // Réponse pour AJAX
    } else {
        echo 'error'; // Réponse en cas d'échec
    }
    $stmt->close();
} else {
    echo 'invalid_request'; // Mauvaise méthode HTTP
}
?>
