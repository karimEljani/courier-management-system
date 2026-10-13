<?php 
include 'pages/head.php'; 
include 'auth.php'; 
include 'server/inc/connection.php'; 

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['customer'])) {
    header("Location: login.php"); // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Récupérer l'identifiant du client connecté
$customerId = $_SESSION['customer'];
$searchQuery = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 10;
$offset = ($page - 1) * $itemsPerPage;

// Requête pour récupérer les colis envoyés
$query = "
    SELECT SQL_CALC_FOUND_ROWS r.request_id, r.sender_phone, r.res_name, r.res_phone, r.red_address, r.total_fee, r.date_updated, r.tracking_status
    FROM request r
    WHERE r.customer_id = ?
";

// Ajouter une recherche si nécessaire
if (!empty($searchQuery)) {
    $query .= " AND (r.request_id LIKE ? OR r.res_name LIKE ? OR r.red_address LIKE ? OR r.sender_phone LIKE ?)";
}

$query .= " ORDER BY r.date_updated DESC LIMIT ? OFFSET ?";
$stmt = $con->prepare($query);

if (!empty($searchQuery)) {
    $likeSearch = "%$searchQuery%";
    $stmt->bind_param("isssii", $customerId, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $itemsPerPage, $offset);
} else {
    $stmt->bind_param("iii", $customerId, $itemsPerPage, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

// Obtenir le nombre total de lignes
$totalItemsQuery = "SELECT FOUND_ROWS() as total";
$totalItemsResult = $con->query($totalItemsQuery);
$totalItems = $totalItemsResult->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colis Envoyés</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
<?php include 'pages/navbar.php'; ?> <!-- Inclure un menu de navigation si nécessaire -->

<div class="container mt-5">
    <h1 class="text-center">Colis Envoyés</h1>

    

    <!-- Tableau des colis -->
    <?php if ($result->num_rows > 0): ?>
        <table id="datatable2" class="table table-bordered table-hover">
            <thead class="bg-info text-white">
            <tr>
                <th>ID Colis</th>
                <th>Téléphone Destinataire</th>
                <th>Nom Destinataire</th>
                <th>Adresse Livraison</th>
                <th>Total (DT)</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $row['request_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['res_phone']); ?></td>
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

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo $searchQuery; ?>">Précédent</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $searchQuery; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo $searchQuery; ?>">Suivant</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
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
                url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/fr-FR.json" // Traduction française
            },
            paging: true,       // Pagination activée
            searching: true,    // Recherche activée
            ordering: true,     // Tri activé
        });
    });
</script>

<?php include 'pages/footer.php'; ?>

</body>
</html>
