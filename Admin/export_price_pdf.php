<?php
require('assets/plugin/pdf/fpdf.php');
$con = new mysqli("localhost", "root", "", "royal_express_db");
if ($con->connect_error) {
    die("Erreur de connexion : " . $con->connect_error);
}

$query = "SELECT request_id, nbre_paquets FROM request WHERE tracking_status = 4";
$result = $con->query($query);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Rapport des Gains', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'ID Commande', 1);
$pdf->Cell(50, 10, 'Nombre de Paquets', 1);
$pdf->Cell(50, 10, 'Gain (DT)', 1);
$pdf->Ln();

$gainParPaquet = 8;
while ($row = $result->fetch_assoc()) {
    $gain = $gainParPaquet * $row['nbre_paquets'];
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, '#' . $row['request_id'], 1);
    $pdf->Cell(50, 10, $row['nbre_paquets'], 1);
    $pdf->Cell(50, 10, $gain . ' DT', 1);
    $pdf->Ln();
}
$pdf->Output();
$con->close();
?>
