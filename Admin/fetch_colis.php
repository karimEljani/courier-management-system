<?php
include '../server/inc/connection.php';

if (isset($_GET['sender_phone'])) {
    $senderPhone = $_GET['sender_phone'];

    $query = "
        SELECT r.request_id, r.total_fee, r.nbre_paquets, IFNULL(p.status, 'Unpaid') AS payment_status
        FROM request r
        LEFT JOIN payments p ON r.request_id = p.request_id
        WHERE r.sender_phone = ? AND r.tracking_status = 4
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $senderPhone);
    $stmt->execute();
    $result = $stmt->get_result();

    $colis = [];
    while ($row = $result->fetch_assoc()) {
        $colis[] = [
            'request_id' => $row['request_id'],
            'total_fee' => $row['total_fee'],
            'payment_status' => $row['payment_status'],
            'nbre_paquets' => $row['nbre_paquets']
        ];
    }

    echo json_encode([
        'success' => true,
        'colis' => $colis
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Paramètre téléphone manquant.'
    ]);
}
?>
