<?php
require('assets/plugin/pdf/fpdf.php');
include('../server/api.php');

// Vérification des paramètres
$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;

if ($customer_id <= 0 || $request_id <= 0) {
    die('Erreur : Client ou ID de commande non valide.');
}

class PDF extends FPDF
{
    private $colors = [
        'header_bg' => [0, 102, 204],    // Bleu foncé pour l'en-tête
        'header_text' => [255, 255, 255], // Texte blanc pour l'en-tête
        'line_color' => [200, 200, 200],  // Gris pour les lignes
        'footer_bg' => [50, 50, 50],      // Gris foncé pour le footer
        'footer_text' => [255, 255, 255], // Texte blanc dans le footer
        'section_bg' => [245, 245, 245],  // Gris clair pour les sections
        'highlight' => [0, 102, 204],     // Bleu pour mettre en valeur certains éléments
        'text' => [33, 33, 33],           // Texte principal
    ];

    public function Header()
    {
        $logoWidth = 30; // Largeur du logo
        $headerHeight = 25; // Hauteur de l'en-tête

        // Couleur de fond
        $this->SetFillColor(...$this->colors['header_bg']);
        $this->Rect(0, 0, 210, $headerHeight, 'F'); // Fond bleu pour l'en-tête

        // Logo
        $this->Image('assets/images/logo/logo1.jpg', 10, 5, $logoWidth); // Logo : X=10, Y=5, Largeur=30

        // Titre centré
        $this->SetTextColor(...$this->colors['header_text']);
        $this->SetFont('Arial', 'B', 16);
        $this->SetXY(0, 5); // Centrer le texte
        $this->Cell(0, 10, utf8_decode('Wassaley Delivery'), 0, 1, 'C'); // Titre principal
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, utf8_decode('Reçu de Livraison'), 0, 1, 'C'); // Sous-titre
        $this->Ln(2);

        // Informations supplémentaires à droite
        $this->SetFont('Arial', '', 10);
        $this->SetXY(150, 5); // Position X=150, Y=5 (à droite)
        $this->MultiCell(50, 5, utf8_decode(
            "Numéro Fiscale : " . $this->nic . "\nDate : " . date('d/m/Y') . "\nContact : +216 51 284 062"
        ), 0, 'R');
    }

    public function addFooter()
    {
        // Ajouter un footer au bon endroit
        $this->Ln(10);
        $this->SetFillColor(...$this->colors['footer_bg']);
        $this->SetTextColor(...$this->colors['footer_text']);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Page ' . $this->PageNo() . ' | www.wassaleydelivery.com | Tel: +216 51 284 062'), 0, 1, 'C', true);
    }

    public function addSectionHeader($title)
    {
        $this->SetFillColor(...$this->colors['section_bg']);
        $this->SetTextColor(...$this->colors['highlight']);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, utf8_decode($title), 0, 1, 'L', true);
        $this->Ln(4);
    }

    public function addRow($label1, $value1, $label2 = '', $value2 = '')
    {
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(...$this->colors['text']);
        $this->Cell(50, 8, utf8_decode($label1 . ':'), 0, 0, 'L');
        $this->Cell(50, 8, utf8_decode($value1), 0, 0, 'L');
        if ($label2) {
            $this->Cell(40, 8, utf8_decode($label2 . ':'), 0, 0, 'L');
            $this->Cell(40, 8, utf8_decode($value2), 0, 1, 'L');
        } else {
            $this->Ln(8);
        }
    }

    public function addSummary($amount, $paymentDetails, $notes)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(...$this->colors['highlight']);
        $this->Cell(60, 10, utf8_decode($amount . " DT"), 1, 0, 'C', true);
        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 10, utf8_decode($paymentDetails), 1, 0, 'C', true);
        $this->Cell(60, 10, utf8_decode($notes), 1, 1, 'C', true);
    }

    public function addQR($qrPath)
    {
        $this->Image($qrPath, 180, 30, 25, 25); // Ajoute l'image QR code
    }
}

// Récupérer le nom et le NIC du client
$queryCustomer = "SELECT name, nic FROM customer WHERE customer_id = '$customer_id'";
$resultCustomer = mysqli_query($con, $queryCustomer);

if ($resultCustomer && ($rowCustomer = mysqli_fetch_assoc($resultCustomer))) {
    $customerName = $rowCustomer['name'];
    $customerNIC = $rowCustomer['nic']; // Récupérer le NIC du client
} else {
    die('Erreur : Client inconnu.');
}

// Charger les données de la commande
$query = "SELECT r.*, sl.area_name AS send_location_name, el.area_name AS end_location_name
          FROM request r
          LEFT JOIN area sl ON r.send_location = sl.area_id
          LEFT JOIN area el ON r.end_location = el.area_id
          WHERE r.customer_id = '$customer_id' AND r.request_id = '$request_id'";
$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $receiptID = 'REC' . str_pad($row['request_id'], 5, '0', STR_PAD_LEFT);

    // Générer le QR code
    $qrData = utf8_encode("RECU #: $receiptID\n\n" .
        "NOM EXPEDITEUR: $customerName\n" .
        "TEL EXPEDITEUR: {$row['sender_phone']}\n" .
        "ADRESSE EXPEDITEUR: {$row['send_location_name']}\n\n" .
        "Date: {$row['date_updated']}\n" .
        "Nbre de paquets: {$row['nbre_paquets']}\n\n" .
        "Montant Total: {$row['total_fee']} DT\n\n" .
        "Wassaley Delivery | Created by full stack developer karim ELJANI"
    );

    $qrPath = 'assets/images/qrcode_temp.png';
    file_put_contents($qrPath, file_get_contents('https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($qrData) . '&size=150x150'));

    // Créer le PDF
    $pdf = new PDF();
    $pdf->nic = $customerNIC; // Passer le NIC au PDF pour l'affichage dans l'en-tête
    $pdf->AddPage();

    // Ajouter l'identifiant du reçu
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 20, utf8_decode('Reçu #: ' . $receiptID), 0, 1, 'L');
    $pdf->Ln(5);

    // Section Expéditeur et Destinataire
    $pdf->addSectionHeader('Informations Expéditeur & Destinataire');
    $pdf->addRow('Nom Expéditeur', $customerName, 'Nom Destinataire', $row['res_name']);
    $pdf->addRow('Tél Expéditeur', $row['sender_phone'], 'Tél Destinataire', $row['res_phone']);
    $pdf->addRow('Adresse Expéditeur', $row['send_location_name'], 'Adresse Destinataire', $row['red_address']);
    $pdf->addRow('Ville Expéditeur', '-', 'Ville Destinataire', $row['end_location_name']);

    // Section Informations colis
    $pdf->addSectionHeader('Informations du colis');
    $pdf->addRow('Type de colis', 'Livraison à domicile', 'Référence', $row['request_id']);
    $pdf->addRow('Colis validé le', $row['date_updated'], 'Nbre de paquets', $row['nbre_paquets']);
    $pdf->addRow('Libellé', $row['libelle'], 'Observations', $row['observations']);

    // Section financière
    $pdf->Ln(10);
    $pdf->addSummary(number_format($row['total_fee'], 3), 'Paiement en espèces uniquement', 'Merci pour votre confiance');

    // Ajouter le footer à la fin
    $pdf->addFooter();

    // Ajouter le QR code
    $pdf->addQR($qrPath);

    // Générer le PDF
    $pdf->Output();

    // Supprimer le QR code temporaire
    unlink($qrPath);
} else {
    die('Erreur : Aucune donnée trouvée pour cette commande.');
}
?>