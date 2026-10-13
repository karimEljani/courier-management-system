<?php
include 'pages/head.php';
include 'auth.php';
include 'server/inc/connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'identifiant du client connecté
$customerId = $_SESSION['customer'];

// Requête principale pour récupérer les colis du client
$query = "
    SELECT r.request_id, r.date_updated, r.total_fee, r.tracking_status, r.final_status, r.res_name, r.type, m.manifest_date
    FROM request r
    LEFT JOIN manifest m ON r.manifest_id = m.manifest_id
    WHERE r.customer_id = ?
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
    <title>Gestion des Colis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
<?php include 'pages/navbar.php'; ?> <!-- Inclure un menu de navigation si nécessaire -->
<div class="container mt-5">
    <h1 class="text-center">Gestion des Colis</h1>
    <p class="text-center">Voici la liste de vos colis.</p>

    <!-- Tableau des colis -->
    <?php if ($result->num_rows > 0): ?>
        <table id="datatable2" class="table table-bordered table-hover">
            <thead class="bg-info text-white">
            <tr>
                <th>Date du Manifeste</th>
                <th>Destinateur</th>
                <th>Type d'envoi</th>
                <th>Total (DT)</th>
                <th>Dernière Modification</th>
                <th>Statut Actuel</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['manifest_date'] ?? 'Non défini'); ?></td>
                    <td><?php echo htmlspecialchars($row['res_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['type'] ?? 'Inconnu'); ?></td>
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
        <p class="text-center">Aucun colis trouvé.</p>
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
            paging: true,       // Activer la pagination
            searching: true,    // Activer la recherche
            ordering: true,     // Activer le tri
        });
    });
</script>
<?php include 'pages/footer.php'; ?>
</body>
</html>
