<?php 
include 'pages/head.php'; 
include 'auth.php'; 
include 'server/inc/connection.php'; 

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['customer'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion
    exit();
}

// Récupérer l'identifiant de l'utilisateur connecté
$customerId = $_SESSION['customer'];

// Requête pour récupérer tous les colis livrés pour ce client
$query = "
    SELECT r.request_id, 
           r.date_updated AS date_livraison, 
           r.total_fee, 
           r.tracking_status, 
           r.manifest_id
    FROM request r
    WHERE r.customer_id = ? 
      AND r.tracking_status = 4 -- Colis livré
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
    <title>Colis Livrés</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
<?php include 'pages/navbar.php'; ?> 

<div class="container mt-5">
    <h1 class="text-center">Mes Manifest</h1>

    <!-- Tableau des colis livrés -->
    <?php if ($result->num_rows > 0): ?>
        <table id="datatable2" class="table table-bordered table-hover">
            <thead class="bg-info text-white">
            <tr>
                <th>ID Colis</th>
                <th>Date de Livraison</th>
                <th>Montant Total (DT)</th>
                <th>Manifeste</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo htmlspecialchars($row['request_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['date_livraison']); ?></td>
                    <td><?php echo number_format($row['total_fee'], 2); ?> DT</td>
                    <td>
                        <?php 
                        if (!empty($row['manifest_id'])) {
                            echo "Manifeste #{$row['manifest_id']}";
                        } else {
                            echo '<span class="badge bg-warning">Non lié</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php if (empty($row['manifest_id'])): ?>
                            <!-- Bouton pour lier le colis à un manifeste -->
                            <form method="POST" action="link_manifest.php" class="d-inline">
                                <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                                <button type="submit" class="btn btn-success btn-sm">Lier à un manifeste</button>
                            </form>
                        <?php else: ?>
                            <a href="manifest_details.php?manifest_id=<?php echo $row['manifest_id']; ?>" class="btn btn-info btn-sm">
                                Voir Manifeste
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Aucun colis livré trouvé.</p>
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
