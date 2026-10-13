<?php
include '../server/inc/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderPhone = $_POST['sender_phone'];

    $query = "DELETE FROM request WHERE sender_phone = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $senderPhone);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
