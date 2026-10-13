<?php
include 'server/inc/connection.php';

$request_id = $_POST['request_id'];

$query = "SELECT * FROM request WHERE request_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($data);
?>
