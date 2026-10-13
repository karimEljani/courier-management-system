<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "royal_express_db";

    $con = new mysqli($host, $user, $password, $db);

    if ($con->connect_error) {
        die('Erreur de connexion : ' . $con->connect_error);
    }

    $request_id = $_POST['request_id'];
    $tracking_status = $_POST['tracking_status'];

    $sql = "UPDATE request SET tracking_status = ? WHERE request_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $tracking_status, $request_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $con->close();
}
?>
