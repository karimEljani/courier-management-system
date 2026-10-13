<!DOCTYPE html>
<html lang="en">
<?php include 'pages/head.php'; ?>
<?php include 'auth.php'; ?>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="200">

    <!-- <div class="site-wrap"> -->

     <!-- <div class="site-wrap"> -->

     <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <header class="site-navbar py-3 js-site-navbar site-navbar-target" role="banner" id="site-navbar">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-11 col-xl-2 site-logo">
                <h1 class="mb-0"><a href="index.php" class="text-white h5 mb-0">WassaleyDelivery</a></h1>
            </div>

            <div class="col-12 col-md-10 d-none d-xl-block">
                <nav class="site-navigation position-relative text-right" role="navigation">
                    <ul class="site-menu js-clone-nav mx-auto d-flex justify-content-end">
                        <li><a href="index.php#section-home" class="nav-link active"><i class="fas fa-home"></i> Accueil</a></li>
                        <li><a href="index.php#section-about" class="nav-link "><i class="fas fa-info-circle"></i> À propos</a></li>
                        <li><a href="index.php#section-gallery" class="nav-link"><i class="fas fa-images"></i> Galerie</a></li>
                        <li><a href="index.php#section-contact" class="nav-link"><i class="fas fa-envelope"></i> Contact</a></li>
                        <?php if (!isset($_SESSION['customer'])) : ?>
                            <li><a href="request_account.php" class="nav-link"><i class="fa-solid fa-user"></i> Être Client</a></li>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['customer'])) :?>
                            <!-- Affichage du nom du client dans le menu déroulant -->
                            <li class="nav-item dropdown">
                                <?php 
                                    $getall = getAllcustomerById($_SESSION['customer']);
                                    $row=mysqli_fetch_assoc($getall);
                                    $customer_id = $row['customer_id']; 
                                ?>
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user"></i> <?php echo $row['name']; ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="profile.php"><i class="fas fa-user-circle"></i> Profil</a>
                                  <a class="dropdown-item" href="request.php"><i class="fas fa-file-alt"></i> Demande</a>
                                  <a class="dropdown-item" href="tracking.php"><i class="fas fa-shipping-fast"></i> Suivi</a>
                                  <a class="dropdown-item" href="customer_dashboard.php"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
                                  <a class="dropdown-item" href="admin/logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                              </div>

                            </li>
                        <?php else :?>
                            <li><a href="admin/login.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

            <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;">
                <a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu h3"></span></a>
            </div>

        </div>
    </div>
</header>

<!-- Scripts Bootstrap et jQuery pour le menu déroulant -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    // S'assurer que les événements sont bien réinitialisés après chaque clic
    $(document).ready(function () {
        // Initialisation du menu dropdown
        $('.dropdown-toggle').dropdown();
        
        // Gestion dynamique des clics
        $('.dropdown-toggle').click(function (e) {
            // Éviter le rechargement ou la fermeture du menu
            var $el = $(this).next('.dropdown-menu');
            var isVisible = $el.is(':visible');
            $('.dropdown-menu').slideUp('400'); // Ferme tous les autres menus ouverts

            if (!isVisible) {
                $el.stop(true, true).slideDown('400'); // Ouvre le menu sur le clic
            }
        });

        // Fermer le menu si l'utilisateur clique en dehors du menu déroulant
        $(document).click(function (e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').slideUp('400'); // Ferme le menu si on clique ailleurs
            }
        });
    });
</script>
<style>
    .dropdown-menu .dropdown-item:hover {
        background-color: #f16821;
        color: white;
    }
</style>
    <div class="site-blocks-cover overlay" style=" height: 100px; background-image: url(<?php echo $subheader_src; ?>);"
        data-aos="fade" data-stellar-background-ratio="0.5" id="section-home">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">

                <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">


                    <h1 class="text-white font-weight-light text-uppercase font-weight-bold" data-aos="fade-up">Profil
                    </h1>

                </div>
            </div>
        </div>
    </div>

    <div class="site-section bg-light" id="section-contact">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-7 text-center border-primary">
                    <h2 class="font-weight-light text-primary">Modifier le profil - Changer le mot de passe</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-5">
                    <?php 
                    $getall = getAllcustomerById($_SESSION['customer']);
                    $row = mysqli_fetch_assoc($getall);
                    $customer_id = $row['customer_id']; ?>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="d-flex flex-column justify-content-center bg-primary h-100 p-5">
                                <div class="d-inline-flex border border-secondary p-2 mb-4">
                                    <h1 class="font-weight-normal text-secondary m-0 mr-3"></h1>
                                    <div class="d-flex flex-column">
                                        <h4 class="text-info">Nom et prénom</h4>
                                        <p class="m-0 text-white"><?php echo $row['name']; ?></p>
                                    </div>
                                </div>
                                <div class="d-inline-flex border border-secondary p-2 mb-4">
                                    <h1 class="font-weight-normal text-secondary m-0 mr-3"></h1>
                                    <div class="d-flex flex-column">
                                        <h4 class="text-info">E-mail</h4>
                                        <p class="m-0 text-white"><?php echo $row['email']; ?></p>
                                    </div>
                                </div>
                                <div class="d-inline-flex border border-secondary p-2 mb-4">
                                    <h1 class="font-weight-normal text-secondary m-0 mr-3"></h1>
                                    <div class="d-flex flex-column">
                                        <h4 class="text-info">Numéro de téléphone</h4>
                                        <p class="m-0 text-white"><?php echo $row['phone']; ?></p>
                                    </div>
                                </div>
                                <div class="d-inline-flex border border-secondary p-2 mb-4">
                                    <h1 class="font-weight-normal text-secondary m-0 mr-3"></h1>
                                    <div class="d-flex flex-column">
                                        <h4 class="text-info">Addresse</h4>
                                        <p class="m-0 text-white"><?php echo $row['address']; ?></p>
                                    </div>
                                </div>
                                <div class="d-inline-flex border border-secondary p-2 mb-4">
                                    <h1 class="font-weight-normal text-secondary m-0 mr-3"></h1>
                                    <div class="d-flex flex-column">
                                        <h4 class="text-info">NIC</h4>
                                        <p class="m-0 text-white"><?php echo $row['nic']; ?></p>
                                    </div>
                                </div>
                                <div class="d-inline-flex border border-secondary p-2 mb-4">
                                    <h1 class="font-weight-normal text-secondary m-0 mr-3"></h1>
                                    <div class="d-flex flex-column">
                                        <h4 class="text-info">Genre</h4>
                                        <p class="m-0 text-white">
                                            <?php if ($row['gender']=="1") echo "Male"; else echo "Female"; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7 mb-5 my-lg-5 py-5 pl-lg-5">
                            <div class="contact-form">
                                <form method="POST" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                                    <div class="col-md-12 mt-2">
                                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                                        <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Mot de passe actuel" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Nouveau mot de passe" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="confirm_new_password" class="form-label">Confirmer le nouveau mot de passe</label>
                                        <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Confirmer le nouveau mot de passe" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <input type="hidden" class="form-control" name="customer_id" value="<?php echo $_SESSION['customer']; ?>" id="customer_id">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button type="submit" name="update_password" class="btn btn-primary">Enregistrer les modifications</button>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <a href="profile.php" class="btn btn-info" data-bs-dismiss="modal">Retour au profil</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php
                    if (isset($_POST['update_password'])) {
                        $current_password = $_POST['current_password'];
                        $new_password = $_POST['new_password'];
                        $confirm_new_password = $_POST['confirm_new_password'];

                        if ($new_password === $confirm_new_password) {
                            // Vérifier le mot de passe actuel
                            if (password_verify($current_password, $row['password'])) {
                                // Chiffrer le nouveau mot de passe
                                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                                // Mettre à jour le mot de passe dans la base de données
                                $update_password_query = "UPDATE customer SET password = '$hashed_password' WHERE customer_id = '$customer_id'";
                                if (mysqli_query($con, $update_password_query)) {
                                    echo '<div class="alert alert-success">Mot de passe mis à jour avec succès!</div>';
                                } else {
                                    echo '<div class="alert alert-danger">Erreur lors de la mise à jour du mot de passe.</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger">Le mot de passe actuel est incorrect.</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger">Les nouveaux mots de passe ne correspondent pas.</div>';
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <?php include 'pages/footer.php'; ?>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/aos.js"></script>

    <script src="js/main.js"></script>

</body>

</html>
