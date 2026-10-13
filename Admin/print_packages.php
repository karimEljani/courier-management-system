<?php
require('assets/plugin/pdf/fpdf.php');

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "royal_express_db");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer la zone à imprimer
$area = $_GET['area'] ?? '';
if (empty($area)) {
    die("Zone non spécifiée.");
}

// Récupérer les colis pour la zone
$query = "SELECT r.*, a.area_name FROM request r 
          JOIN area a ON r.end_location = a.area_id 
          WHERE a.area_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $area);
$stmt->execute();
$result = $stmt->get_result();

// Générer le PDF
$pdf = new FPDF();
$pdf->AddPage();

// Ajouter l'en-tête avec le nom de l'entreprise et la date sur la même ligne
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(95, 10, "Wassaley Delivery", 0, 0, 'L');  // Nom de l'entreprise aligné à gauche
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Date: " . date('d/m/Y'), 0, 1, 'R');  // Date actuelle alignée à droite
$pdf->Ln(10);  // Ajouter un espace avant le tableau

// Titre de la zone
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode("Colis pour la zone: $area"), 0, 1, 'C');
$pdf->Ln(10);  // Ajouter un espace avant le tableau

// Définir la police pour le tableau
$pdf->SetFont('Arial', '', 12);

// Entêtes du tableau
$pdf->Cell(10, 10, "ID ", 1, 0, 'C');
$pdf->Cell(50, 10, "Nom Destinataire", 1, 0, 'C'); // Nouvelle colonne pour le nom du destinataire

$pdf->Cell(60, 10, "Adresse", 1, 0, 'C');
$pdf->Cell(25, 10, utf8_decode("Téléphone"), 1, 0, 'C');
$pdf->Cell(25, 10, "Prix", 1, 0, 'C');
$pdf->Cell(10, 10, "N/P", 1, 0, 'C');
$pdf->Cell(15, 10, "Action", 1, 1, 'C');

// Remplir le tableau avec les données
while ($row = $result->fetch_assoc()) {
    $status = ($row['tracking_status'] == 4) ? utf8_decode('Livré') : utf8_decode('Non livré');
    $action = ($row['tracking_status'] == 4) ? '' : '';

    $pdf->Cell(10, 10, "#{$row['request_id']}", 1, 0, 'C');
    $pdf->Cell(50, 10, $row['res_name'], 1, 0, 'C'); // Affichage du nom du destinataire

    $pdf->Cell(60, 10, $row['red_address'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['res_phone'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['total_fee'], 1, 0, 'C');
    $pdf->Cell(10, 10, $row['nbre_paquets'], 1, 0, 'C');

    $pdf->Cell(15, 10, $action, 1, 1, 'C');
}

// Positionner le footer en bas de la page
$pdf->SetY(-31); // 30mm à partir du bas de la page
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, utf8_decode("Livreur: ............................ | Matricule du véhicule: ................... | Signature: ........."), 0, 1, 'C'); // Exemple de données

$pdf->Output();

$conn->close();
?>
