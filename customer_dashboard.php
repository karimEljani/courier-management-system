<?php include 'pages/head.php'; ?>
<?php include 'auth.php'; ?>

<?php
// Vérifier si le client est connecté
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer'];

// Connexion à la base de données et récupération des statistiques
$total_orders_query = "SELECT COUNT(*) AS total_orders FROM request WHERE customer_id = '$customer_id' AND is_deleted = 0";
$total_orders_result = mysqli_query($con, $total_orders_query);
$total_orders = mysqli_fetch_assoc($total_orders_result)['total_orders'] ?? 0;

$status_count_query = "
    SELECT tracking_status, COUNT(*) AS count 
    FROM request 
    WHERE customer_id = '$customer_id' AND is_deleted = 0 
    GROUP BY tracking_status";
$status_count_result = mysqli_query($con, $status_count_query);

$status_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
while ($row = mysqli_fetch_assoc($status_count_result)) {
    $status_counts[$row['tracking_status']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Client</title>
    <!-- Styles Bootstrap, Chart.js et Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .site-navbar {
            background-color: #000000;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .site-menu a.nav-link {
            color: white;
            transition: color 0.3s ease;
        }
        .site-menu a.nav-link:hover {
            color: #f1c40f;
        }
        .card-header {
            background-color: #000000;
            color: white;
            
        }
        .btn-darkblue {
            background-color: #000000;
            color: white;
        }
        
        table th, table td {
            text-align: center;
        }
        /* Style pour la mise en page côte à côte */
        .stat-section {
            display: flex;
            justify-content: space-between;
        }
        .stat-section .card {
            width: 48%;
        }
    </style>
</head>
<body style="background-color: #f4f7fa;">
<?php include 'pages/navbar.php'; ?> <!-- Inclure un menu de navigation si nécessaire -->

<!-- Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container mt-5">
    <h1 class="text-center">Bienvenue dans votre Dashboard</h1>
    <p class="text-center">Voici un aperçu de vos statistiques et activités récentes.</p>

    <!-- Statistiques principales -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    <i class="fa-solid fa-box"></i> Total des Demandes
                </div>
                <div class="card-body">
                    <h3><?php echo $total_orders; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    <i class="fa-solid fa-truck"></i> Commandes Expédiées
                </div>
                <div class="card-body">
                    <h3><?php echo $status_counts[3]; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    <i class="fa-solid fa-check"></i> Commandes Livrées
                </div>
                <div class="card-body">
                    <h3><?php echo $status_counts[4]; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Commandes récentes et Répartition des statuts côte à côte -->
    <div class="stat-section mt-5">
        <div class="card" style="width: 48%;">
            <div class="card-header">
                <i class="fa-solid fa-chart-pie"></i> Répartition des Statuts
            </div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <div class="card" style="width: 48%;">
            <div class="card-header">
                <i class="fa-solid fa-box"></i> Commandes Récentes
            </div>
            <div class="card-body">
                <?php
                $recent_orders_query = "SELECT * FROM request WHERE customer_id = '$customer_id' AND is_deleted = 0 ORDER BY date_updated DESC LIMIT 5";
                $recent_orders_result = mysqli_query($con, $recent_orders_query);

                if (mysqli_num_rows($recent_orders_result) > 0) { ?>
                    <table class="table table-bordered"  >
                    
                        <thead class="thead-dark" >
                            <tr>
                                <th style="background-color: #000000;">ID</th>
                                <th style="background-color: #000000;">Statut</th>
                                <th style="background-color: #000000;">Date</th>
                                <th style="background-color: #000000;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($recent_orders_result)) { ?>
                                <tr>
                                    <td>#<?php echo $row['request_id']; ?></td>
                                    <td>
                                        <?php
                                        switch ($row['tracking_status']) {
                                            case 1: echo 'En attente'; break;
                                            case 2: echo 'Préparation'; break;
                                            case 3: echo 'Expédié'; break;
                                            case 4: echo 'Livré'; break;
                                            case 5: echo 'Annulé'; break;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row['date_updated']; ?></td>
                                    <td>
                                        <a href="Admin/getbill.php?customer_id=<?php echo $customer_id; ?>&request_id=<?php echo $row['request_id']; ?>" class="btn btn-darkblue btn-sm">
                                            Voir <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p class="text-center">Aucune commande récente trouvée.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Scripts pour le graphique -->
<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['En attente', 'Préparation', 'Expédié', 'Livré', 'Annulé'],
            datasets: [{
                data: [
                    <?php echo $status_counts[1]; ?>,
                    <?php echo $status_counts[2]; ?>,
                    <?php echo $status_counts[3]; ?>,
                    <?php echo $status_counts[4]; ?>,
                    <?php echo $status_counts[5]; ?>
                ],
                backgroundColor: ['#FFC107', '#17A2B8', '#007BFF', '#28A745', '#DC3545'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
<?php include 'pages/footer.php'; ?>

<!-- Scripts Bootstrap et jQuery pour le menu déroulant -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
