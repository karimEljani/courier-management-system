<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rapport_gains.xls");
$con = new mysqli("localhost", "root", "", "royal_express_db");
if ($con->connect_error) {
    die("Erreur de connexion : " . $con->connect_error);
}

$query = "SELECT request_id, nbre_paquets FROM request WHERE tracking_status = 4";
$result = $con->query($query);

echo "ID Commande\tNombre de Paquets\tGain (DT)\n";
$gainParPaquet = 8;
while ($row = $result->fetch_assoc()) {
    $gain = $gainParPaquet * $row['nbre_paquets'];
    echo "{$row['request_id']}\t{$row['nbre_paquets']}\t$gain\n";
}
$con->close();
?>
