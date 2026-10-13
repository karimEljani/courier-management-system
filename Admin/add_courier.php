<!DOCTYPE html>
<html lang="fr">

<?php include 'pages/head.php'; ?>
<?php include 'admin.php'; ?>
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
                <h3>Enregistrement du client</h3>
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Enregistrement du colis</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-6">
                        <div class="row">
                            <form action="" method="post" id="basicform" data-parsley-validate="">
                                <div class="form-group mt-2">
                                    <label for="inputName">Nom</label>
                                    <input id="inputName" type="text" name="name" data-parsley-trigger="change" required="" placeholder="Entrez le nom complet" autocomplete="off" class="form-control">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="inputEmail">Adresse e-mail</label>
                                    <input id="inputEmail" type="email" name="email" data-parsley-trigger="change" required="" placeholder="Entrez l'adresse e-mail" autocomplete="off" class="form-control">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="inputPhone">Numéro de téléphone</label>
                                    <input id="inputPhone" type="text" name="phone" data-parsley-trigger="change" required="" placeholder="Entrez le numéro de téléphone" autocomplete="off" class="form-control">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="inputNIC">Numéro d'identité (NIC)</label>
                                    <input id="inputNIC" type="text" name="nic" data-parsley-trigger="change" required="" placeholder="Entrez le numéro NIC" autocomplete="off" class="form-control">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="inputAddress">Adresse</label>
                                    <input id="inputAddress" type="text" name="address" data-parsley-trigger="change" required="" placeholder="Entrez l'adresse" autocomplete="off" class="form-control">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="inputGender">Genre</label>
                                    <select class="form-select" name="gender" id="gender" aria-label="Sélectionner le genre">
                                        <option value="1" selected>Homme</option>
                                        <option value="0">Femme</option>
                                    </select>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="inputPassword">Mot de passe</label>
                                    <input id="inputPassword" type="password" name="password" placeholder="Mot de passe" required="" class="form-control">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="inputRepeatPassword">Répéter le mot de passe</label>
                                    <input id="inputRepeatPassword" data-parsley-equalto="#inputPassword" type="password" required="" name="conf_password" placeholder="Répétez le mot de passe" class="form-control">
                                </div>

                                <button type="button" onclick="addCustomerAdmin(this.form)" name="submit" class="btn btn-primary">Enregistrer les modifications</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>

            <?php include 'pages/footer.php'; ?>
        </div>
    </div>

    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>
