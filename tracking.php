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



    <div class="site-blocks-cover overlay" style=" height: 100px; background-image: url(<?php echo $subheader_src; ?>);" data-aos="fade" data-stellar-background-ratio="0.5" id="section-home">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">

                <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">


                    <h1 class="text-white font-weight-light text-uppercase font-weight-bold" data-aos="fade-up">Suivi
                    </h1>

                </div>
            </div>
        </div>
    </div>



    <div class="site-section bg-light" id="section-contact">
    <div class="site-section bg-light" id="section-contact">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center border-primary">
                <h2 class="font-weight-light text-primary">Suivi de colis</h2>
            </div>
        </div>
        <div class="row">
    <div class="col-md-12 mb-5">
        <?php
        // Obtenir toutes les commandes en fonction du client connecté
        $getall = getAllTrackingByCUS($_SESSION['customer']);
        while ($row = mysqli_fetch_assoc($getall)) {
            $request_id = $row['request_id'];
        ?>
            <article class="card mt-5 shadow" style="border: none; animation: fadeInUp 0.8s;">
                <header class="card-header text-white" style="background-color: #2c3e50; border-radius: 5px;">
                    <i class="fas fa-box"></i> Ordres / Suivi
                </header>
                <div class="card-body">
                    <h6>Suivi ID: #<?php echo $row['request_id']; ?></h6>
                    <article class="card">
                        <div class="card-body row">
                            <div class="col">
                                <strong><i class="fas fa-map-marker-alt"></i> Adresse de livraison:</strong>
                                <br><?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="col">
                                <strong><i class="fas fa-phone-alt"></i>Téléphone Récepteur :</strong>
                                <br><?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="col">
                                <strong><i class="fas fa-info-circle"></i> Statut actuel:</strong>
                                <br>
                                <?php
                                switch ($row['tracking_status']) {
                                    case 1:
                                        echo 'Commande en attente';
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
                                        echo 'Statut inconnu';
                                }
                                ?>
                            </div>
                            <div class="col">
                                <strong><i class="fas fa-calendar-alt"></i> Date demandée:</strong>
                                <br><?php echo htmlspecialchars($row['date_updated'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>
                        <div class="card-body row">
                            <div class="col">
                                <strong><i class="fas fa-box"></i> Nbr de paquets | Prix:</strong>
                                <br><?php echo htmlspecialchars($row['nbre_paquets'], ENT_QUOTES, 'UTF-8'); echo '  /' ?>
                                <?php echo htmlspecialchars($row['total_fee'], ENT_QUOTES, 'UTF-8'); echo' DT'?>
                            </div>
                            <div class="col">
                                <strong><i class="fas fa-phone-alt"></i> Téléphone Expéditeur :</strong>
                                <br><?php echo htmlspecialchars($row['sender_phone'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="col">
                                <strong><i class="fas fa-location-arrow"></i> Lieu d'envoi:</strong>
                                <br>
                                <?php
                                $getLocation = getAllAreabyID($row['send_location']);
                                if ($row2 = mysqli_fetch_assoc($getLocation)) {
                                    echo htmlspecialchars($row2['area_name'], ENT_QUOTES, 'UTF-8');
                                }
                                ?>
                            </div>
                            <div class="col">
                                <strong><i class="fas fa-map-pin"></i> Destination:</strong>
                                <br>
                                <?php
                                $getLocation = getAllAreabyID($row['end_location']);
                                if ($row2 = mysqli_fetch_assoc($getLocation)) {
                                    echo htmlspecialchars($row2['area_name'], ENT_QUOTES, 'UTF-8');
                                }
                                ?>
                            </div>
                        </div>
                    </article>
                    <?php if ($row['tracking_status'] != 5) { ?>
                        <div class="track mt-4">
                            <div class="step <?php echo ($row['tracking_status'] >= 1) ? 'active' : ''; ?>">
                                <span class="icon"> <i class="fas fa-clock"></i> </span>
                                <span class="text">Commande en attente</span>
                            </div>
                            <div class="step <?php echo ($row['tracking_status'] >= 2) ? 'active' : ''; ?>">
                                <span class="icon"> <i class="fas fa-box-open"></i> </span>
                                <span class="text">Préparation</span>
                            </div>
                            <div class="step <?php echo ($row['tracking_status'] >= 3) ? 'active' : ''; ?>">
                                <span class="icon"> <i class="fas fa-truck"></i> </span>
                                <span class="text">Expédié</span>
                            </div>
                            <div class="step <?php echo ($row['tracking_status'] == 4) ? 'active' : ''; ?>">
                                <span class="icon"> <i class="fas fa-check-circle"></i> </span>
                                <span class="text">Livré</span>
                            </div>
                        </div>
                    <?php } ?>
                    <hr>
                    <div class="row">
                        <?php if ($row['tracking_status'] == 1) { ?>
                            <div class="col-md-3">
                                <label for="tracking_status" class="form-label">Annuler la commande</label>
                                <select onchange='cancelRequest(this, "<?php echo $request_id; ?>")' 
                id="tracking_status<?php echo $request_id; ?>" class='form-control'>
                                    <option value="1">Veuillez sélectionner</option>
                                    <option value="5" <?php echo ($row['tracking_status'] == 5) ? 'selected' : ''; ?>>Annulé</option>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                        <!-- button imprimer
                            <div class="row mt-3">
                                <a href="admin/getbill.php?customer_id=<?php echo $_SESSION['customer']; ?>&request_id=<?php echo $row['request_id']; ?>" class="btn btn-primary shadow-sm">
                                    <i class="fas fa-file-pdf"></i> Imprimer
                                </a>
                            </div>
                        -->
                    <div class="row mt-3">
                    <?php if ($row['tracking_status'] == 1) { ?>

    <a href="#" class="btn btn-primary shadow-sm" onclick="openModifyModal('<?php echo $request_id; ?>')">
        <i class="fas fa-file-update"></i> Modifier la Commande
    </a><?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function openModifyModal(requestId) {
    // Récupérer les données actuelles de la commande
    $.ajax({
        url: 'get_request_details.php',
        method: 'POST',
        data: { request_id: requestId },
        dataType: 'json',
        success: function (row) {
            // Récupérer les zones pour les listes déroulantes
            $.ajax({
                url: 'get_all_areas.php',
                method: 'GET',
                dataType: 'json',
                success: function (areas) {
                    // Construire les options pour les listes déroulantes
                    let sendLocationOptions = '';
                    let endLocationOptions = '';

                    areas.forEach(area => {
                        sendLocationOptions += `<option value="${area.area_id}" ${area.area_id == row.send_location_id ? 'selected' : ''}>${area.area_name}</option>`;
                        endLocationOptions += `<option value="${area.area_id}" ${area.area_id == row.end_location_id ? 'selected' : ''}>${area.area_name}</option>`;
                    });

                    // Ouvrir le formulaire SweetAlert avec une disposition côte à côte
                    Swal.fire({
                        title: 'Modifier la commande',
                        width: '90vw', // Largeur à 90% de l'écran
                        heightAuto: false, // Désactiver la hauteur automatique
                        customClass: {
                            popup: 'fullscreen-modal' // Classe CSS personnalisée
                        },
                        html: `
                            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                <div style="width: 48%;">
                                    <label for="new_address">Adresse de livraison</label>
                                    <input id="new_address" class="swal2-input" value="${row.red_address}" />
                                </div>
                                <div style="width: 48%;">
                                    <label for="new_phone">Téléphone récepteur</label>
                                    <input id="new_phone" class="swal2-input" value="${row.res_phone}" />
                                </div>
                                <div style="width: 48%;">
                                    <label for="new_packages">Nbr de paquets</label>
                                    <input id="new_packages" class="swal2-input" value="${row.nbre_paquets}" />
                                </div>
                                <div style="width: 48%;">
                                    <label for="new_price">Prix</label>
                                    <input id="new_price" class="swal2-input" value="${row.total_fee}" />
                                </div>
                                <div style="width: 48%;">
                                    <label for="new_sender_phone">Téléphone expéditeur</label>
                                    <input id="new_sender_phone" class="swal2-input" value="${row.sender_phone}" />
                                </div>
                                <div style="width: 48%;">
                                    <label for="new_send_location">Lieu d'envoi</label>
                                    <select id="new_send_location" class="swal2-input">
                                        ${sendLocationOptions}
                                    </select>
                                </div>
                                <div style="width: 48%;">
                                    <label for="new_end_location">Destination</label>
                                    <select id="new_end_location" class="swal2-input">
                                        ${endLocationOptions}
                                    </select>
                                </div>
                            </div>
                        `,
                        confirmButtonText: 'Mettre à jour',
                        showCancelButton: true,
                        preConfirm: () => {
                            // Validation des champs obligatoires
                            const newAddress = document.getElementById('new_address').value;
                            const newPhone = document.getElementById('new_phone').value;
                            const newPackages = document.getElementById('new_packages').value;
                            const newPrice = document.getElementById('new_price').value;
                            const newSenderPhone = document.getElementById('new_sender_phone').value;
                            const newSendLocation = document.getElementById('new_send_location').value;
                            const newEndLocation = document.getElementById('new_end_location').value;

                            if (!newAddress || !newPhone || !newPackages || !newPrice) {
                                Swal.showValidationMessage('Veuillez remplir tous les champs requis.');
                            } else {
                                return {
                                    requestId,
                                    newAddress,
                                    newPhone,
                                    newPackages,
                                    newPrice,
                                    newSenderPhone,
                                    newSendLocation,
                                    newEndLocation
                                };
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Envoi des modifications au serveur via AJAX
                            const data = result.value;
                            $.ajax({
                                url: 'update_request.php',
                                method: 'POST',
                                data: {
                                    request_id: data.requestId,
                                    new_address: data.newAddress,
                                    new_phone: data.newPhone,
                                    new_packages: data.newPackages,
                                    new_price: data.newPrice,
                                    new_sender_phone: data.newSenderPhone,
                                    new_send_location: data.newSendLocation,
                                    new_end_location: data.newEndLocation
                                },
                                success: function (response) {
                                    if (response === 'success') {
                                        Swal.fire('Mise à jour réussie!', '', 'success');
                                        location.reload();
                                    } else {
                                        Swal.fire('Erreur', 'Erreur lors de la mise à jour.', 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Erreur', 'Une erreur est survenue. Veuillez réessayer.', 'error');
                                }
                            });
                        }
                    });
                },
                error: function () {
                    Swal.fire('Erreur', 'Impossible de charger les zones.', 'error');
                }
            });
        },
        error: function () {
            Swal.fire('Erreur', 'Impossible de récupérer les informations.', 'error');
        }
    });
}

</script>

                    
                </div>

            </article>
        <?php } ?>
    </div>
</div>

    </div>
</div>

<script>
    function cancelRequest(element, requestId) {
        const value = element.value;
        if (value == "5") {
            // Effectuer une requête AJAX pour mettre à jour le statut
            $.ajax({
                url: 'update_status.php', // Ce fichier doit gérer la mise à jour
                method: 'POST',
                data: {
                    request_id: requestId,
                    tracking_status: value
                },
                success: function(response) {
                    if (response === 'success') {
                        alert('Commande annulée avec succès.');
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'annulation de la commande.');
                    }
                },
                error: function() {
                    alert('Une erreur est survenue. Veuillez réessayer.');
                }
            });
        }
    }
</script>

</div>




    <?php include 'pages/footer.php'; ?>
    <!-- </div> -->

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

    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

       


        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.10rem
        }

        .card-header:first-child {
            border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1)
        }

        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 60px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #2c3e50
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #2c3e50;
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }

        .itemside {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%
        }

        .itemside .aside {
            position: relative;
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .img-sm {
            width: 80px;
            height: 80px;
            padding: 7px
        }

        ul.row,
        ul.row-sm {
            list-style: none;
            padding: 0
        }

        .itemside .info {
            padding-left: 15px;
            padding-right: 7px
        }

        .itemside .title {
            display: block;
            margin-bottom: 5px;
            color: #212529
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem
        }

        .btn-warning {
            color: #ffffff;
            background-color: #2c3e50;
            border-color: #2c3e50;
            border-radius: 1px
        }

        .btn-warning:hover {
            color: #ffffff;
            background-color: #ff2b00;
            border-color: #ff2b00;
            border-radius: 1px
        }
    </style>
</body>

</html>