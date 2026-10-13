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
                                $customer_id = $row['customer_id']; ?>
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
                        <?php endif;?>
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



<!-- Scripts Bootstrap et jQuery pour le menu déroulant -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-dark " style="background-color: #f16821;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Colis Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="colisDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-box"></i> Colis
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="colisDropdown">
                        <li><a class="dropdown-item" href="package_sent.php"><i class="fas fa-paper-plane"></i> Envoi</a></li>
                        <li><a class="dropdown-item" href="manifesto.php"><i class="fas fa-clipboard-list"></i> Mes Manifest</a></li>
                        <li><a class="dropdown-item" href="courier_manag.php"><i class="fas fa-box-open"></i> Gestion des Colis</a></li>
                        <li><a class="dropdown-item" href="cutomer_cus.php"><i class="fas fa-users"></i> Client</a></li>
                    </ul>
                </li>

                <!-- Finance Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="financeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-wallet"></i> Finance
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="financeDropdown">
                        <li><a class="dropdown-item" href="OP.php"><i class="fas fa-exchange-alt"></i> Mes OP</a></li>
                        <li><a class="dropdown-item" href="bills.php"><i class="fas fa-file-invoice"></i> Mes Factures</a></li>
                    </ul>
                </li>

                <!-- Tickets -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="tickets.php">
                        <i class="fas fa-ticket-alt"></i> Tickets
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</body>
</html>