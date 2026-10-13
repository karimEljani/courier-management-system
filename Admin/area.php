<!DOCTYPE html>
<html lang="fr">

<?php include 'pages/head.php'; ?>
<?php include 'admin.php'; ?>
<?php include 'checkAdmin.php'; ?>
<?php include 'header.php'; ?>

<body style="background-color: #f4f7fa;">
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
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

            <div class="page-heading">
                <h3>Zones</h3>
            </div>

            <div class="row">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des zones</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AreaModal">Ajouter une nouvelle zone</button>
                </div>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nom de la zone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getall = getAllArea();
                                    while ($row = mysqli_fetch_assoc($getall)) {
                                        $area_id = $row['area_id']; ?>
                                        <tr>
                                            <td><?php echo $row['area_name']; ?></td>
                                            <td>
                                                <button type="button" onclick="permenantdeleteData(<?php echo $row['area_id']; ?>, 'area', 'area_id')" class="btn btn-darkblue">
                                                    <i class="fa-solid fa-trash"></i> Supprimer
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>

            <?php include 'pages/footer.php'; ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="AreaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="exampleModalLabel">Ajouter une zone</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" id="basicform" data-parsley-validate="" enctype="multipart/form-data">
                    <div class="modal-body bg-white">
                        <div class="col-md-12">
                            <label for="area_name" class="form-label">Nom de la zone</label>
                            <input type="text" class="form-control" name="area_name" id="area_name" placeholder="Nom de la zone" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" onclick="addArea(this.form)" name="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
