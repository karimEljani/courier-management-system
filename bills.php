<?php
include 'server/inc/connection.php'; // Connexion à la base de données
include 'pages/head.php'; // Entête HTML
include 'auth.php'; // Protection des pages réservées

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'identifiant du client connecté
$customerId = $_SESSION['customer'];

// Définir le tarif unitaire et le taux de TVA
$tarifUnitaire = 7.00; // Tarif par paquet en DT
$tva = 1.3; // TVA en DT

// Récupération des informations générales des factures
$query = "
    SELECT 
        DATE(r.date_updated) AS invoice_date, 
        SUM(r.nbre_paquets) AS total_paquets, -- Total des paquets
        SUM(r.nbre_paquets * ?) AS tarif_total, -- Tarif total (tarif unitaire * nbre_paquets)
        SUM(r.nbre_paquets * ?) AS montant_tva, -- Montant TVA (taux TVA * nbre_paquets)
        SUM(r.nbre_paquets * ?) + SUM(r.nbre_paquets * ?) AS total_ttc, -- Total TTC
        GROUP_CONCAT(CONCAT('#', r.request_id, ': ', r.total_fee, ' DT')) AS colis_details
    FROM request r
    WHERE r.customer_id = ? 
    AND r.tracking_status = 4 -- Seuls les colis livrés
    GROUP BY DATE(r.date_updated)
    ORDER BY r.date_updated DESC
";
$stmt = $con->prepare($query);
$stmt->bind_param("ddddi", $tarifUnitaire, $tva, $tarifUnitaire, $tva, $customerId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factures</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
<?php include 'pages/navbar.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Factures</h1>
    <p class="text-center">Détails des factures pour vos colis livrés.</p>

    <!-- Tableau des factures -->
    <?php if ($result && $result->num_rows > 0): ?>
        <table id="datatable2" class="table table-bordered table-hover">
            <thead class="bg-info text-white">
            <tr>
                <th>Date</th>
                <th>Nombre de Paquets</th>
                <th>Tarif Unitaire (DT)</th>
                <th>Tarif Total (DT)</th>
                <th>Montant TVA (DT)</th>
                <th>Total TTC (DT)</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['invoice_date']); ?></td>
        <td><?php echo htmlspecialchars($row['total_paquets']); ?></td> <!-- Nombre total de paquets -->
        <td><?php echo number_format($tarifUnitaire, 2); ?> DT</td>
        <td><?php echo number_format($row['tarif_total'], 2); ?> DT</td>
        <td><?php echo number_format($row['montant_tva'], 2); ?> DT</td>
        <td><?php echo number_format($row['total_ttc'], 2); ?> DT</td>
        <td>
            <!-- Nouveau bouton pour afficher les détails -->
            <button class="btn btn-info btn-sm show-details" 
                    data-date="<?php echo $row['invoice_date']; ?>" 
                    data-details="<?php echo htmlspecialchars($row['colis_details']); ?>" 
                    data-total="<?php echo $row['total_ttc']; ?> "
                    data-paquets="<?php echo $row['total_paquets']; ?> "
                    style="position: relative;">
                <span class="icon">
                    <i class="fas fa-eye"></i> <!-- Icône pour afficher les détails -->
                </span>
            </button>

            <!-- Nouveau bouton pour imprimer -->
            <button class="btn btn-success print-receipt" 
                    data-date="<?php echo $row['invoice_date']; ?>" 
                    data-total="<?php echo $row['total_ttc']; ?>" 
                    data-details="<?php echo htmlspecialchars($row['colis_details']); ?> "
                    data-paquets="<?php echo $row['total_paquets']; ?> "
                    style="position: relative;">
                <span class="icon">
                    <i class="fas fa-print"></i> <!-- Icône pour imprimer -->
                </span>
            </button>
        </td>
    </tr>
<?php endwhile; ?>
</tbody>

        </table>
    <?php else: ?>
        <p class="text-center">Aucune facture disponible.</p>
    <?php endif; ?>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#datatable2').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/fr-FR.json"
            },
            paging: true,
            searching: true,
            ordering: true,
        });

        // Afficher les détails dans SweetAlert avec un tableau
        $('.show-details').on('click', function () {
            const invoiceDate = $(this).data('date');
            const colisDetails = $(this).data('details');
            const totalTTC = $(this).data('total');
            const totalPaquets = $(this).data('paquets');

            // Construire les détails
            let detailsTable = `<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Colis ID</th>
                        <th>Frais Total (DT)</th>
                    </tr>
                </thead>
                <tbody>`;

            const colisArray = colisDetails.split(","); // Diviser les détails des colis
            colisArray.forEach(detail => {
                const [id, fee] = detail.split(": "); // Récupérer ID et tarif
                detailsTable += `<tr>
                    <td>${id}</td>
                    <td>${fee}</td>
                </tr>`;
            });

            detailsTable += `</tbody></table>`;

            // Afficher SweetAlert avec les détails
            Swal.fire({
                title: `Détails de la facture (${invoiceDate})`,
                html: `
                    <p><strong>Nombre de Paquets :</strong> ${totalPaquets}</p>
                    <p><strong>Total TTC :</strong> ${totalTTC} DT</p>
                    ${detailsTable}
                `,
                icon: 'info',
                width: '70%',
                confirmButtonText: 'Fermer',
            });
        });
    });
</script>

<?php include 'pages/footer.php'; ?>
</body>

</html>
