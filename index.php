<!DOCTYPE html>
<html lang="en">
<?php include 'pages/head.php'; ?>
 <!-- Ajout du CSS de Leaflet -->
 <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

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



  <div class="site-blocks-cover overlay" style="background-image: url(<?php echo $header_src; ?>);" data-aos="fade" data-stellar-background-ratio="0.5" id="section-home">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center">

        <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">


          <h1 class="text-white font-weight-light text-uppercase font-weight-bold" data-aos="fade-up"><?php echo $res['header_title']; ?></h1>
          <p class="mb-5" data-aos="fade-up" data-aos-delay="100"><?php echo $res['header_desc']; ?></p>
          <p data-aos="fade-up" data-aos-delay="200"><a href="request.php" class="btn btn-primary py-3 px-5 text-white">Commander maintenant</a></p>

        </div>
      </div>
    </div>
  </div>

  <div class="site-section" id="section-about">
    <div class="container">
      <div class="row mb-5">

        <div class="col-md-5 ml-auto mb-5 order-md-2" data-aos="fade-up" data-aos-delay="100">
          <img src="<?php echo $about_src; ?>" alt="Image" class="img-fluid rounded">
        </div>
        <div class="col-md-6 order-md-1" data-aos="fade-up">
          <div class="text-left pb-1 border-primary mb-4">
            <h2 class="text-primary"><?php echo $res['about_title']; ?></h2>
          </div>
          <p><?php echo $res['about_desc']; ?></p>
        </div>

      </div>
    </div>
  </div>


  <div class="site-section block-13" id="section-gallery">

    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-7 text-center border-primary">
          <h2 class="mb-0 text-primary">Galerie</h2>
        </div>
      </div>
    </div>

    <div class="owl-carousel nonloop-block-13">
      <?php
      $getall = getAllgalleryImages();
      while ($row = mysqli_fetch_assoc($getall)) {
        $img = $row['gallery_image'];
        $img_src = "server/uploads/gallery/" . $img; ?>
        <div>
          <a href="#" class="unit-1 text-center">
            <img src="<?php echo $img_src; ?>" alt="Image" class="img-fluid">
            <div class="unit-1-text">
            </div>
          </a>
        </div>
      <?php } ?>

    </div>
  </div>


  <div class="site-blocks-cover overlay inner-page-cover" style="background-image: url(<?php echo $background_image_src; ?>); background-attachment: fixed;">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center">


      </div>
    </div>
  </div>


  <div class="site-section bg-light" id="section-contact">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-7 text-center border-primary">
          <h2 class="font-weight-light text-primary">Contactez-nous</h2>
          <h5>Pour créer un compte avec nous, envoyez-nous simplement un message.</h5>
        </div>
      </div>
      <div class="row">
        <div class="col-md-7 mb-5">



          <form action="#" class="p-5 bg-white" method="post">


            <div class="row form-group">
              <div class="col-md-12 mb-3 mb-md-0">
                <label class="text-black" for="fname">Nom et prénom</label>
                <input type="text" name="name" id="name" class="form-control">
              </div>
            </div>

            <div class="row form-group">

              <div class="col-md-12">
                <label class="text-black" for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control">
              </div>
            </div>

            <div class="row form-group">

              <div class="col-md-12">
                <label class="text-black" for="subject">Sujet</label>
                <input type="subject" name="subject" id="subject" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-12">
                <label class="text-black" for="message">Message</label>
                <textarea name="message" name="message" id="message" cols="30" rows="4" class="form-control"></textarea>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-12">
                <button type="button" onclick="addContactMessage(this.form)" class="btn btn-primary py-2 px-4 text-white">
                  <i class="fas fa-paper-plane"></i> Envoyer un message
                </button>
              </div>
            </div>



          </form>
        </div>
        <div class="col-md-5">

          <div class="p-4 mb-3 bg-white">
            <p class="mb-0 font-weight-bold"><i class="fas fa-map-marker-alt"></i> Adresse</p>
            <p class="mb-4"><?php echo $res['company_address']; ?></p>

            <p class="mb-0 font-weight-bold"><i class="fas fa-phone-alt"></i> Téléphone</p>
            <p class="mb-4"><a href="#"><?php echo $res['company_phone']; ?></a></p>

            <p class="mb-0 font-weight-bold"><i class="fas fa-envelope"></i> Adresse email</p>
            <p class="mb-0"><a href="#"><?php echo $res['company_email']; ?></a></p>
          </div>

          <!-- Conteneur pour la carte Leaflet -->
          <div id="map" style="height: 300px;"></div>

        </div>

      </div>
    </div>
  </div>

  <?php include 'pages/footer.php'; ?>
  <!-- </div> -->
   
 <!-- Ajout du JS de Leaflet -->
 <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  
  <script>
    // Initialisation de la carte avec la position de l'entreprise
    var map = L.map('map').setView([33.506566, 11.107567], 13); // Remplacez par vos coordonnées (latitude, longitude)

    // Ajout des tuiles de la carte 33.50814688010393, 11.092885766042487
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Ajout d'un marqueur à l'emplacement de l'entreprise
    L.marker([33.506566, 11.107567]).addTo(map) // Remplacez par vos coordonnées
      .bindPopup("WassaleyDelivery")
      .openPopup();
  </script>

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