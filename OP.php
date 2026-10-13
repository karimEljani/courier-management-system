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

// Récupération des colis livrés (Ordres de paiement) pour le client connecté
$query = "
    SELECT 
        r.request_id,
        r.red_address,
        r.res_name,
        r.total_fee,
        r.type,
        r.nbre_paquets,
        r.libelle,
        p.status AS payment_status
    FROM request r
    LEFT JOIN payments p ON r.request_id = p.request_id
    WHERE r.tracking_status = 4 -- Livrés
    AND r.customer_id = ?
    ORDER BY r.date_updated DESC
";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordre du Paiement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
<?php include 'pages/navbar.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Ordre du Paiement</h1>
    <p class="text-center">Liste de vos colis livrés et leur statut de paiement.</p>

    <!-- Tableau des colis -->
    <?php if ($result && $result->num_rows > 0): ?>
        <table id="datatable2" class="table table-bordered table-hover">
            <thead class="bg-info text-white">
            <tr>
                <th>ID Colis</th>
                <th>Addresse</th>
                <th>Destinataire</th>
                <th>Montant (DT)</th>
                <th>Type de Colis</th>
                <th>Nombre du paquets</th>
                <th>Statut Paiement</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo htmlspecialchars($row['request_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['red_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['res_name']); ?></td>
                    <td><?php echo number_format($row['total_fee'], 2); ?> DT</td>
                    <td><?php echo htmlspecialchars($row['type']); ?></td>
                    <td><?php echo htmlspecialchars($row['nbre_paquets']); ?></td>

                    <td>
                        <?php
                        if ($row['payment_status'] === 'Paid') {
                            echo '<span class="badge bg-success">Payé</span>';
                        } else {
                            echo '<span class="badge bg-warning">Non Payé</span>';
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Aucun colis trouvé pour vos ordres de paiement.</p>
    <?php endif; ?>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
    });
</script>

<?php include 'pages/footer.php'; ?>
</body>

</html>
