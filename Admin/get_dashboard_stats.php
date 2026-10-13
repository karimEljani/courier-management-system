<?php
include '../server/inc/connection.php'; 

function dataCountWhere($table, $condition) {
    global $con;
    $query = "SELECT COUNT(*) AS count FROM $table WHERE $condition";
    $result = $con->query($query);
    $row = $result->fetch_assoc();
    return $row['count'] ?? 0;
}

function getTotalFrais($interval) {
    global $con;
    $query = "SELECT SUM(total_fee) AS total_frais FROM request WHERE tracking_status = 4 AND date_updated >= DATE_SUB(NOW(), INTERVAL $interval)";
    $result = $con->query($query);
    $row = $result->fetch_assoc();
    return $row['total_frais'] ?? 0.0;
}

$data = [
    'totalClients' => dataCountWhere('customer', '1=1'),
    'totalRequests' => dataCountWhere('request', '1=1'),
    'weeklyFrais' => getTotalFrais('7 DAY'),
    'monthlyFrais' => getTotalFrais('1 MONTH'),
    'yearlyFrais' => getTotalFrais('1 YEAR'),
];

header('Content-Type: application/json');
echo json_encode($data);
?>
