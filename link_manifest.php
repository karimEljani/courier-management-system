<?php
include 'server/inc/connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = $_POST['request_id'];

    // Vérifier si le colis est déjà lié à un manifeste
    $checkQuery = "SELECT manifest_id FROM request WHERE request_id = ? AND manifest_id IS NULL";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Créer un manifeste s'il n'existe pas pour le client
        $createManifestQuery = "INSERT INTO manifest (customer_id) SELECT customer_id FROM request WHERE request_id = ?";
        $stmtCreateManifest = $con->prepare($createManifestQuery);
        $stmtCreateManifest->bind_param("i", $requestId);
        $stmtCreateManifest->execute();

        // Récupérer le dernier ID de manifeste
        $manifestId = $con->insert_id;

        // Associer le colis au manifeste
        $updateQuery = "UPDATE request SET manifest_id = ? WHERE request_id = ?";
        $stmtUpdate = $con->prepare($updateQuery);
        $stmtUpdate->bind_param("ii", $manifestId, $requestId);
        $stmtUpdate->execute();

        echo "Le colis a été lié au manifeste #{$manifestId}.";
    } else {
        echo "Le colis est déjà lié à un manifeste ou n'existe pas.";
    }

    header("Location: manifesto.php");
    exit();
}
