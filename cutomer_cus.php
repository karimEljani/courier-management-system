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

// Requête pour récupérer les destinataires associés au client connecté avec le nombre de colis livrés
$query = "
    SELECT DISTINCT 
        r.res_name, 
        r.res_phone, 
        r.red_address, 
        COUNT(CASE WHEN r.tracking_status = 4 THEN r.request_id END) AS colis_livres
    FROM request r
    WHERE r.customer_id = ?
    AND r.is_deleted = 0
    GROUP BY r.res_name, r.res_phone, r.red_address
    ORDER BY colis_livres DESC
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
    <title>Mes Destinataires</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

<body>
<?php include 'pages/navbar.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Mes Destinataires</h1>
    <p class="text-center">Voici la liste des destinataires associés à vos envois.</p>

    <!-- Tableau des destinataires -->
    <?php if ($result->num_rows > 0): ?>
        <table id="datatable2" class="table table-bordered table-hover">
            <thead class="bg-info text-white">
            <tr>
                <th>Nom Destinataire</th>
                <th>Téléphone</th>
                <th>Adresse</th>
                <th>Colis Livrés</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['res_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['res_phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['red_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['colis_livres']); ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Aucun destinataire trouvé.</p>
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
