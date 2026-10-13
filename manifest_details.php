<?php
include 'pages/head.php';
include 'auth.php';
include 'server/inc/connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si un ID de manifeste est fourni
if (!isset($_GET['manifest_id'])) {
    echo "Aucun manifeste sélectionné.";
    exit();
}

$manifestId = (int)$_GET['manifest_id'];

// Requête pour récupérer les détails du manifeste
$queryManifest = "
    SELECT m.manifest_id, m.manifest_date, c.name AS customer_name
    FROM manifest m
    INNER JOIN customer c ON m.customer_id = c.customer_id
    WHERE m.manifest_id = ?
";
$stmt = $con->prepare($queryManifest);
$stmt->bind_param("i", $manifestId);
$stmt->execute();
$resultManifest = $stmt->get_result();
$manifestDetails = $resultManifest->fetch_assoc();

// Si le manifeste n'existe pas
if (!$manifestDetails) {
    echo "Manifeste introuvable.";
    exit();
}

// Requête pour récupérer les colis associés au manifeste
$queryColis = "
    SELECT r.request_id, r.res_name, r.red_address, r.total_fee, r.date_updated, r.tracking_status
    FROM request r
    WHERE r.manifest_id = ?
";
$stmtColis = $con->prepare($queryColis);
$stmtColis->bind_param("i", $manifestId);
$stmtColis->execute();
$resultColis = $stmtColis->get_result();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Manifeste</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
<?php include 'pages/navbar.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Détails du Manifeste #<?php echo htmlspecialchars($manifestDetails['manifest_id']); ?></h1>

    <!-- Informations sur le manifeste -->
    <div class="card mt-4">
        <div class="card-body">
            <p><strong>Date du Manifeste :</strong> <?php echo htmlspecialchars($manifestDetails['manifest_date']); ?></p>
            <p><strong>Nom du Client :</strong> <?php echo htmlspecialchars($manifestDetails['customer_name']); ?></p>
        </div>
    </div>

    <!-- Liste des colis associés -->
    <h2 class="mt-5">Colis Associés</h2>
    <?php if ($resultColis->num_rows > 0): ?>
        <table id="datatable2" class="table table-bordered table-hover">
            <thead class="bg-info text-white">
            <tr>
                <th>ID Colis</th>
                <th>Nom Destinataire</th>
                <th>Adresse de Livraison</th>
                <th>Total (DT)</th>
                <th>Date de Livraison</th>
                <th>Statut</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $resultColis->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo htmlspecialchars($row['request_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['res_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['red_address']); ?></td>
                    <td><?php echo number_format($row['total_fee'], 2); ?> DT</td>
                    <td><?php echo htmlspecialchars($row['date_updated']); ?></td>
                    <td>
                        <?php
                        switch ($row['tracking_status']) {
                            case 1:
                                echo 'En attente';
                                break;
                            case 2:
                                echo 'Préparation';
                                break;
                            case 3:
                                echo 'Expédié';
                                break;
                            case 4:
                                echo 'Livré';
                                break;
                            case 5:
                                echo 'Annulé';
                                break;
                            default:
                                echo 'Inconnu';
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Aucun colis associé à ce manifeste.</p>
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
