<!DOCTYPE html>
<html lang="en">
<?php include 'pages/head.php'; ?>
<?php include 'admin.php'; ?>
<?php include 'header.php'; ?>


<body style="background-color: #f4f7fa;">
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active" >
                <div class="sidebar-header" style="width: 200px; height: 100px; ">
                    <div class="d-flex justify-content-between align-items-center mt-0 px-3 py-2">
                        <a href="index.php" class="d-flex align-items-center text-decoration-none">
                            <!-- Logo avec style intégré -->
                            <img src="assets/images/logo/logo2.png" alt="Logo WassaleyDelivery" class="sidebar-logo me-2" style="width: 200px; height: 100px; ">
                        </a>
                    </div>

                </div>

                <div class="sidebar-menu" style="background-color: #f4f7fa;">
                    <ul class="menu">
                    <li class="sidebar-item active ">
                            <a href="index.php" class='sidebar-link bg-dark'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Tableau de bord</span>
                            </a>
                        </li>
                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin') : ?>

                        <li class="sidebar-item ">
                            <a href="customer.php" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Client</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin') : ?>

                        <li class="sidebar-item">
                            <a href="customer_request.php" class="sidebar-link">
                                <i class="bi bi-person-plus-fill"></i> <!-- Icône pour l'ajout de comptes -->
                                <span>Demandes de compte</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin') : ?>

                        <li class="sidebar-item">
                            <a href="price.php" class='sidebar-link'>
                                <i class="bi bi-table"></i>
                                <span>Tableau des prix</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <li class="sidebar-item">
                            <a href="courier.php" class='sidebar-link'>
                                <i class="bi bi-truck"></i>
                                <span>colis</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="organization _courier.php" class='sidebar-link'>
                                <i class="bi bi-box"></i> <!-- Icône pour l'organisation des colis -->
                                <span>Organisation des Colis</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="message.php" class='sidebar-link'>
                                <i class="bi bi-chat"></i>
                                <span>Message</span>
                            </a>
                        </li>
                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin') : ?>
                            <li class="sidebar-item">
                                <a href="tickets.php" class='sidebar-link'>
                                    <i class="bi bi-columns"></i>
                                    <span>Tickets</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="sidebar-item">
                            <a href="employee.php" class='sidebar-link'>
                                <i class="bi bi-person-fill"></i>
                                <span>Employé </span>
                            </a>
                        </li>
                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin') : ?>
                            <li class="sidebar-item">
                                <a href="area.php" class='sidebar-link'>
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>Zone</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="gallery.php" class='sidebar-link'>
                                    <i class="bi bi-images"></i>
                                    <span>Galerie</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="sidebar-item">
                            <a href="settings.php" class='sidebar-link'>
                                <i class="bi bi-gear-fill"></i>
                                <span>Paramètres</span>
                            </a>
                        </li>
                        

                        <li class="sidebar-item">
                            <a href="logout.php" class='sidebar-link text-danger'>
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Se déconnecter</span>
                            </a>
                        </li>                    
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-content">
                <section class="row">
                    <!-- Section des statistiques principales -->
                    <div class="col-12 mb-4">
                        <div class="row g-4">
                            <!-- Cartes des statistiques comme avant (succursales, clients, employés, demandes de colis) -->
                        </div>
                    </div>

                    <!-- Nouveaux tableaux de statistiques et graphiques -->
                    <div class="col-12">
                    <section class="row">
                    <!-- Statistiques principales -->
                    <div class="col-12 mb-4">
                        <div class="row g-4">
                            <!-- Total Clients -->
                            <div class="col-lg-3">
                                <div class="card shadow">
                                    <div class="card-body text-center">
                                        <h5>Total Clients</h5>
                                        <h3 id="totalClients">
                                            <?php echo dataCountWhere('customer', '1=1'); ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Demandes -->
                            <div class="col-lg-3">
                                <div class="card shadow">
                                    <div class="card-body text-center">
                                        <h5>Total Demandes</h5>
                                        <h3 id="totalRequests">
                                            <?php echo dataCountWhere('request', '1=1'); ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Frais Totaux (Calcul dynamique) -->
                            <div class="col-lg-3">
                                <div class="card shadow">
                                    <div class="card-body text-center">
                                        <h5>Frais Totaux (Semaine)</h5>
                                        <h3 id="weeklyFrais">
                                            <?php
                                            $con = new mysqli("localhost", "root", "", "royal_express_db");
                                            $query = "SELECT SUM(nbre_paquets) AS total_paquets FROM request WHERE tracking_status = 4 AND date_updated >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
                                            $result = $con->query($query);
                                            $data = $result->fetch_assoc();
                                            $gainTotal = $data['total_paquets'] * 8;
                                            echo number_format($gainTotal, 2) . ' DT';
                                            ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card shadow">
                                    <div class="card-body text-center">
                                        <h5>Frais Totaux (Mois)</h5>
                                        <h3 id="monthlyFrais">
                                            <?php
                                            $query = "SELECT SUM(nbre_paquets) AS total_paquets FROM request WHERE tracking_status = 4 AND date_updated >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
                                            $result = $con->query($query);
                                            $data = $result->fetch_assoc();
                                            $gainTotal = $data['total_paquets'] * 8;
                                            echo number_format($gainTotal, 2) . ' DT';
                                            ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card shadow">
                                    <div class="card-body text-center">
                                        <h5>Frais Totaux (Année)</h5>
                                        <h3 id="yearlyFrais">
                                            <?php
                                            $query = "SELECT SUM(nbre_paquets) AS total_paquets FROM request WHERE tracking_status = 4 AND date_updated >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
                                            $result = $con->query($query);
                                            $data = $result->fetch_assoc();
                                            $gainTotal = $data['total_paquets'] * 8;
                                            echo number_format($gainTotal, 2) . ' DT';
                                            ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                        <div class="row g-4">
                            <!-- Tableau des statistiques par catégorie -->
                            <div class="col-12 col-lg-6">
                                <div class="card border-0 shadow rounded-lg">
                                    <div class="card-header">
                                        <h4 class="card-title">Statistiques des Commandes</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Statut</th>
                                                    <th>Nombre de Commandes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Commandes en attente</td>
                                                    <td><?php echo dataCountWhere('request', ' tracking_status = 1 '); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Commandes acceptées</td>
                                                    <td><?php echo dataCountWhere('request', ' tracking_status = 2 '); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Commandes annulées</td>
                                                    <td><?php echo dataCountWhere('request', ' tracking_status = 5 '); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Commandes expédiée</td>
                                                    <td><?php echo dataCountWhere('request', ' tracking_status = 3 '); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Commandes livrés</td>
                                                    <td><?php echo dataCountWhere('request', ' tracking_status = 4 '); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Graphique en barres pour les commandes par statut -->
                            <div class="col-12 col-lg-6">
                                <div class="card border-0 shadow rounded-lg">
                                    <div class="card-header">
                                        <h4 class="card-title">Graphique des Statuts des Commandes</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="bar-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Graphique de flux pour les nouvelles commandes -->
                        <div class="row g-4 mt-4">
                            <div class="col-12">
                                <div class="card border-0 shadow rounded-lg">
                                    <div class="card-header">
                                        <h4 class="card-title">Graphique de Flux des Commandes</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="flow-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                
            </div>
            
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        // Configuration du graphique en barres
        var optionsBar = {
            series: [{
                data: [
                    <?php echo dataCountWhere('request', ' tracking_status = 1 '); ?>,
                    <?php echo dataCountWhere('request', ' tracking_status = 2 '); ?>,
                    <?php echo dataCountWhere('request', ' tracking_status = 5 '); ?>,
                    <?php echo dataCountWhere('request', ' tracking_status = 3 '); ?>
                ]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['En attente', 'Accepté', 'Annulé', 'Terminé']
            }
        };
        var barChart = new ApexCharts(document.querySelector("#bar-chart"), optionsBar);
        barChart.render();

        // Configuration du graphique de flux
        var optionsFlow = {
            series: [{
                name: 'Commandes',
                data: [
                    <?php echo dataCountWhere('request', ' tracking_status = 1 '); ?>,
                    <?php echo dataCountWhere('request', ' tracking_status = 2 '); ?>,
                    <?php echo dataCountWhere('request', ' tracking_status = 5 '); ?>,
                    <?php echo dataCountWhere('request', ' tracking_status = 3 '); ?>
                ]
            }],
            chart: {
                height: 350,
                type: 'line'
            },
            xaxis: {
                categories: ['En attente', 'Accepté', 'Annulé', 'Terminé']
            }
        };
        var flowChart = new ApexCharts(document.querySelector("#flow-chart"), optionsFlow);
        flowChart.render();
    </script>
</body>

</html>
