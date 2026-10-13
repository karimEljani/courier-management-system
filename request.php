<!DOCTYPE html>
<html lang="en">
<?php include 'pages/head.php'; ?>
<?php include 'auth.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inclure Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Inclure Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <style>
        

        h4 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #343a40;
            position: relative;
        }

        h4::after {
            content: "";
            display: block;
            width: 50px;
            height: 4px;
            background-color: #0d6efd;
            margin-top: 5px;
            border-radius: 3px;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .form-section {
            background: #ffffff;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-icon {
            color: #0d6efd;
            margin-right: 0.5rem;
        }
    </style>
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


                    <h1 class="text-white font-weight-light text-uppercase font-weight-bold" data-aos="fade-up">DEMANDE
                    </h1>

                </div>
            </div>
        </div>
    </div>



    
    <div class="container py-5">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 text-center">
            <h2 class="text-primary animate__animated animate__fadeInDown">
                <i class="fas fa-paper-plane"></i> Faire une Demande
            </h2>
            <p class="text-muted">Remplissez les champs ci-dessous pour envoyer votre demande.</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form action="#" method="post" class="form-section animate__animated animate__zoomIn">

                <!-- Détails d'envoi -->
                <div class="accordion mb-3" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDetailsEnvoi">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#detailsEnvoi" aria-expanded="true" aria-controls="detailsEnvoi">
                                <i class="fas fa-info-circle form-icon"></i> Détails d'envoi
                            </button>
                        </h2>
                        <div id="detailsEnvoi" class="accordion-collapse collapse show" aria-labelledby="headingDetailsEnvoi" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <?php
                                        $customer_id = $_SESSION['customer'];
                                        $query = "SELECT phone FROM customer WHERE customer_id = '$customer_id'";
                                        $result = mysqli_query($con, $query);
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            $sender_phone = $row['phone'];
                                        } else {
                                            $sender_phone = "Numéro non trouvé";
                                        }
                                        ?>
                                        <label for="sender_phone" class="text-black"><i class="fas fa-phone form-icon"></i> Numéro de téléphone</label>
                                        <input type="text" name="sender_phone" id="sender_phone" class="form-control" value="<?php echo $sender_phone; ?>" readonly>
                                        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="send_location" class="text-black"><i class="fas fa-map-marker-alt form-icon"></i> Emplacement d'envoi</label>
                                        <select id="send_location" name="send_location" class="form-control" onchange="updatePrice()" required>
                                            <option value="">Veuillez sélectionner</option>
                                            <?php $getall = getAllArea();
                                            while ($row = mysqli_fetch_assoc($getall)) { ?>
                                                <option value="<?php echo $row['area_id']; ?>"><?php echo $row['area_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_location" class="text-black"><i class="fas fa-location-arrow form-icon"></i> Lieu de prise en charge</label>
                                        <select id="end_location" name="end_location" class="form-control" onchange="updatePrice()" required>
                                            <option value="">Veuillez sélectionner</option>
                                            <?php $getall = getAllArea();
                                            while ($row = mysqli_fetch_assoc($getall)) { ?>
                                                <option value="<?php echo $row['area_id']; ?>"><?php echo $row['area_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="total_fee" class="text-black"><i class="fas fa-dollar-sign form-icon"></i> Prix total</label>
                                        <input type="number" name="total_fee" id="total_fee" class="form-control" placeholder="Ex : 50" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations colis -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingColis">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#informationsColis" aria-expanded="false" aria-controls="informationsColis">
                                <i class="fas fa-box form-icon"></i> Informations colis
                            </button>
                        </h2>
                        <div id="informationsColis" class="accordion-collapse collapse" aria-labelledby="headingColis" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="text-black"><i class="fas fa-truck form-icon"></i> Type de colis</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="Livraison à domicile">Livraison à domicile</option>
                                            <option value="Point relais">Echange</option>
                                            <option value="Colis urgent">Récupération</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nbre_paquets" class="text-black"><i class="fas fa-boxes form-icon"></i> Nombre de paquets</label>
                                        <input type="number" name="nbre_paquets" id="nbre_paquets" class="form-control" value="1">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="libelle" class="text-black"><i class="fas fa-info form-icon"></i> Libellé</label>
                                        <select name="libelle" id="libelle" class="form-control">
                                            <option value="Fragile">Fragile</option>
                                            <option value="Non fragile">Non fragile</option>
                                            <option value="Liquide">Liquide</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="observations" class="text-black"><i class="fas fa-sticky-note form-icon"></i> Observations</label>
                                        <textarea name="observations" id="observations" class="form-control" rows="3" placeholder="Ajouter des commentaires"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Détails du récepteur -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingRecepteur">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#detailsRecepteur" aria-expanded="false" aria-controls="detailsRecepteur">
                                <i class="fas fa-user form-icon"></i> Détails du récepteur
                            </button>
                        </h2>
                        <div id="detailsRecepteur" class="accordion-collapse collapse" aria-labelledby="headingRecepteur" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="res_name" class="text-black"><i class="fas fa-user-circle form-icon"></i> Nom du destinataire</label>
                                        <input type="text" name="res_name" id="res_name" class="form-control" placeholder="Ex : Nom et Prénom">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="res_phone" class="text-black"><i class="fas fa-phone-alt form-icon"></i> Téléphone</label>
                                        <input type="text" name="res_phone" id="res_phone" class="form-control" placeholder="Ex : +216 ** *** ***">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="red_address" class="text-black"><i class="fas fa-map form-icon"></i> Adresse</label>
                                        <textarea name="red_address" id="red_address" class="form-control" rows="3" placeholder="Adresse complète"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton d'envoi -->
                <div class="text-center">
                    <button type="button" onclick="addRequest(this.form)" class="btn btn-primary px-5 py-2">
                        <i class="fas fa-paper-plane"></i> Envoyer la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


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
    <script>
    addRequest = (form) => {
        var formData = new FormData(form);

        // Vérification des champs obligatoires avec IziToast
        if (formData.get("sender_phone").trim() === "") {
            iziToast.error({
                title: "Erreur",
                message: "Veuillez entrer votre numéro de téléphone.",
            });
            return;
        }

        if (formData.get("total_fee").trim() === "") {
            iziToast.error({
                title: "Erreur",
                message: "Veuillez entrer les emplacements pour obtenir le prix.",
            });
            return;
        }

        if (formData.get("res_phone").trim() === "") {
            iziToast.error({
                title: "Erreur",
                message: "Veuillez entrer le numéro de téléphone du destinataire.",
            });
            return;
        }

        if (formData.get("red_address").trim() === "") {
            iziToast.error({
                title: "Erreur",
                message: "Veuillez entrer l'adresse du destinataire.",
            });
            return;
        }

        // Envoi de la requête AJAX
        $.ajax({
            method: "POST",
            url: "server/api.php?function_code=addRequest",
            data: formData,
            success: function (data) {
                console.log(data);
                iziToast.success({
                    title: "Succès",
                    message: "Votre demande a été soumise avec succès.",
                    onClosing: function () {
                        window.location.href = "tracking.php";
                    },
                });
            },
            cache: false,
            contentType: false,
            processData: false,
            error: function (error) {
                console.log(`Erreur : ${error}`);
                iziToast.error({
                    title: "Erreur",
                    message: "Une erreur est survenue. Veuillez réessayer.",
                });
            },
        });
    };
</script>

</body>

</html>

