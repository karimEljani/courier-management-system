<!DOCTYPE html>
<html lang="en">
<?php include 'pages/head.php'; ?>


<head>
    <!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.min.js"></script>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&family=Nunito:wght@300;600&display=swap");

    *,
    *::before,
    *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Nunito", sans-serif;
    }

    body {
      background: #162561;
      background-image: radial-gradient(
          circle at 20% 100%,
          rgba(184, 184, 184, 0.1) 0%,
          rgba(184, 184, 184, 0.1) 33%,
          rgba(96, 96, 96, 0.1) 33%,
          rgba(96, 96, 96, 0.1) 66%,
          rgba(7, 7, 7, 0.1) 66%,
          rgba(7, 7, 7, 0.1) 99%
        ),
        linear-gradient(40deg, #040a22, #162561, #202e64, #6f7aa6);
      background-repeat: no-repeat;
      background-size: cover;
    }

    section {
      position: relative;
      width: 100%;
      height: 100vh;
      
      background-size: cover;
      background-position: center;
    
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      overflow: hidden;
      transition: background-image 1s ease-in-out;
    }

    .content {
      max-width: 2400px;
    }

    .content h1 {
      font-family: "Comfortaa", sans-serif;
      font-size: clamp(2rem, 4vw, 3.5rem);
      font-weight: 700;
      line-height: 1.2;
      letter-spacing: 1px;
      margin-bottom: 36px;
      color: #fff;
    }

    .content p {
      font-size: clamp(0.9rem, 3vw, 1.25rem);
      font-weight: 300;
      line-height: 1.5;
      margin-bottom: 30px;
      color: #fff;
    }

    .content button {
      background: #eaeaea;
      color: #202134;
      font-size: clamp(0.9rem, 4vw, 1rem);
      font-weight: 600;
      border: 0;
      outline: 0;
      padding: 8px 14px;
      border-radius: 7px;
      transform: scale(1);
      transition: all 0.4s ease-in;
      cursor: pointer;
    }

    .content button:is(:hover, :focus) {
      transform: scale(0.98);
      background-color: #6f7aa6;
      color: #eaeaea;
    }

    .faq-section {
      padding: 40px 60px;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    .faq-section h2 {
      font-family: "Comfortaa", sans-serif;
      font-size: 2rem;
      color: #fff;
      margin-bottom: 20px;
      text-align: center;
    }

    .faq-item {
      margin-bottom: 20px;
      cursor: pointer;
    }

    .faq-item h3 {
      font-weight: 600;
      font-size: 1.2rem;
      color: #eaeaea;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .faq-item p {
      font-size: 1rem;
      font-weight: 300;
      color: #ddd;
      display: none;
      transition: max-height 0.3s ease;
    }

    .faq-item.active p {
      display: block;
    }

    .cc-aem-c-icon {
      transition: transform 0.3s ease;
      width: 1em;
      height: 1em;
      fill: #eaeaea;
    }

    .faq-item.active .cc-aem-c-icon {
      transform: rotate(180deg);
    }
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
            background-color: #2c3e50;
            color: white;
        }
        .btn-darkblue {
            background-color: #2c3e50;
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

<body>
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
  <section id="dynamic-background">
    <div class="content">
      <h1 style="background-color: rgba(0, 0, 0, 0.5);">WassaleyDelivery</h1>
      <p style="background-color: rgba(0, 0, 0, 0.5);">Inscrivez-vous et faites des économies sur les expéditions</p>
      <button id="openAccountButton">Ouvrir un compte</button>
    </div>
  </section>

  <!-- SVG Chevron Icon -->
  <svg style="display: none;">
    <symbol id="chevron" viewBox="0 0 24 24">
      <path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6z"/>
    </symbol>
  </svg>

  <!-- FAQ Section -->
  <div class="faq-section">
    <h2>Foire aux Questions</h2>
    <div class="faq-container">
      <div class="faq-item">
        <h3>
          Quels services offre un compte en ligne et que peut-on expédier ?
          <svg class="cc-aem-c-icon" aria-hidden="true" focusable="false" role="presentation">
            <use xlink:href="#chevron"></use>
          </svg>
        </h3>
        <p>Un compte en ligne vous permet d'envoyer divers types de colis, y compris des documents, des articles e-commerce, et plus.</p>
      </div>
      <div class="faq-item">
        <h3>
          Où puis-je expédier et dans quels délais ?
          <svg class="cc-aem-c-icon" aria-hidden="true" focusable="false" role="presentation">
            <use xlink:href="#chevron"></use>
          </svg>
        </h3>
        <p>Vous pouvez expédier entre les villes du sud de la Tunisie avec différents délais, allant jusqu'à un maximum de 2 jours.</p>
      </div>
      <div class="faq-item">
        <h3>
        Comment expédier en sude Tunisienne ? 
          <svg class="cc-aem-c-icon" aria-hidden="true" focusable="false" role="presentation">
            <use xlink:href="#chevron"></use>
          </svg>
        </h3>
        <p>Utilisez notre solution "Cliquez Envoyez" pour expédier rapidement vos colis vers des destinations en sude Tunisienne .</p>
      </div>
      <div class="faq-item">
        <h3>
          Combien coûte l’expédition ?
          <svg class="cc-aem-c-icon" aria-hidden="true" focusable="false" role="presentation">
            <use xlink:href="#chevron"></use>
          </svg>
        </h3>
        <p>7 DT pour chaque paquet + 1.3 DT TVA .</p>
      </div>
      <div class="faq-item">
        <h3>
          Comment payer ?
          <svg class="cc-aem-c-icon" aria-hidden="true" focusable="false" role="presentation">
            <use xlink:href="#chevron"></use>
          </svg>
        </h3>
        <p>Les paiements sont possibles en espèces  ou virement postale.</p>
      </div>
    </div>
  </div>

  <?php include 'pages/footer.php'; ?>

  <script>
  // Images for background
  const backgroundImages = [
    'server/uploads/gallery/380452847_2314231278780328_4117403224790658736_n.gif',
    'server/uploads/gallery/462559543_510134931986402_2888846354670257771_n.png',
    'server/uploads/gallery/462585687_944576117510438_2414557469094796537_n.png',
    'server/uploads/settings/462566935_1266011664750456_5407849167835611390_n.png',
    'server/uploads/settings/462540603_3935196313376000_5956420204934776642_n.png',
    'server/uploads/gallery/462546050_1672092293364226_8144402118782690420_n.png'
  ];

  let currentIndex = 0;

  function changeBackground() {
    const section = document.getElementById('dynamic-background');
    section.style.backgroundImage = `url('${backgroundImages[currentIndex]}')`;
    console.log(`Background changed to: ${backgroundImages[currentIndex]}`);
    currentIndex = (currentIndex + 1) % backgroundImages.length;
  }

  window.onload = () => {
    changeBackground(); // Affiche immédiatement la première image
    setInterval(changeBackground, 5000); // Change l'image toutes les 5 secondes
  };

  // Gérer les clics sur les FAQ
  document.querySelectorAll(".faq-item h3").forEach(item => {
    item.addEventListener("click", () => {
      item.parentElement.classList.toggle("active");
    });
  });
  </script>

  <style>
    body {
      font-family: Arial, sans-serif;
    }

    /* FAQ Section */
    .faq-section {
      padding: 40px;
      background-color: #f9f9f9;
    }

    .faq-section h2 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 20px;
      color : #f16821 ;
    }

    .faq-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .faq-item {
      width: 48%;
      margin-bottom: 20px;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .faq-item h3 {
      font-size: 1.1rem;
      font-weight: 600;
      color: #333;
      display: flex;
      justify-content: space-between;
      cursor: pointer;
    }

    .faq-item p {
      display: none;
      font-size: 1rem;
      color: #666;
      margin-top: 10px;
    }

    .faq-item.active p {
      display: block;
    }

    .faq-item .cc-aem-c-icon {
      width: 16px;
      height: 16px;
      transform: rotate(0deg);
      transition: transform 0.3s ease;
    }

    .faq-item.active .cc-aem-c-icon {
      transform: rotate(180deg);
    }

    /* Make the FAQ items responsive */
    @media (max-width: 768px) {
      .faq-item {
        width: 100%;
      }
    }
  </style>




<script>
  document.getElementById('openAccountButton').addEventListener('click', function() {
    // Afficher la SweetAlert avec le formulaire
    Swal.fire({
      title: 'Créer un compte',
      html: ` 
        <form id="createAccountForm" class="form-container">
          <div class="form-row">
            <div class="form-group">
              <label for="name">Nom et Prénom :</label>
              <input type="text" id="name" name="name" class="form-input" required>
            </div>
            <div class="form-group">
              <label for="nic">Numéro fiscale:</label>
              <input type="text" id="nic" name="nic" class="form-input" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="location">Lieu :</label>
              <input type="text" id="location" name="location" class="form-input" required>
            </div>
            <div class="form-group">
              <label for="address">Adresse :</label>
              <input type="text" id="address" name="address" class="form-input" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="email">Email :</label>
              <input type="email" id="email" name="email" class="form-input" required>
            </div>
            <div class="form-group">
              <label for="phone">Téléphone :</label>
              <input type="tel" id="phone" name="phone" class="form-input" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="phone2">Téléphone 2 :</label>
              <input type="tel" id="phone2" name="phone2" class="form-input">
            </div>
            <div class="form-group">
              <label for="password">Mot de passe :</label>
              <input type="password" id="password" name="password" class="form-input" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="confirmPassword">Confirmer le mot de passe :</label>
              <input type="password" id="confirmPassword" name="confirmPassword" class="form-input" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="gender">Genre :</label>
              <select id="gender" name="gender" class="form-input" required>
                <option value="1">Homme</option>
                <option value="2">Femme</option>
              </select>
            </div>
          </div>
        </form>
      `,
      showCancelButton: true,
      confirmButtonText: 'S\'inscrire',
      cancelButtonText: 'Annuler',
      preConfirm: () => {
        const name = document.getElementById('name').value;
        const nic = document.getElementById('nic').value;

        const location = document.getElementById('location').value;
        const address = document.getElementById('address').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const phone2 = document.getElementById('phone2').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const gender = document.getElementById('gender').value;


        // Validation des champs
        if (!name || !nic || !location || !address || !email || !phone || !password || !confirmPassword || !gender ) {
          Swal.showValidationMessage('Tous les champs obligatoires doivent être remplis.');
          return false;
        }

        if (password !== confirmPassword) {
          Swal.showValidationMessage('Les mots de passe ne correspondent pas.');
          return false;
        }

        return { name,nic, location, address, email, phone, phone2, password, gender };
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = result.value;

        // Requête AJAX pour envoyer les données au serveur
        $.ajax({
          url: 'create_account.php',
          method: 'POST',
          data: formData,
          success: function (response) {
            if (response === 'success') {
              Swal.fire({
                title: 'Compte créé !',
                text: 'Votre compte a été créé avec succès.',
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then(() => {
                // Redirection après confirmation du compte créé
                window.location.href = 'message_request.php';
              });
            } else {
              Swal.fire('Erreur', 'Une erreur est survenue. Veuillez réessayer.', 'error');
            }
          },
          error: function () {
            Swal.fire('Erreur', 'Erreur de communication avec le serveur.', 'error');
          }
        });
      }
    });

    // Styles pour le formulaire
    const style = document.createElement('style');
    style.innerHTML = `
      /* Conteneur principal */
      .form-container {
        font-family: 'Arial', sans-serif;
        width: 100%;
        max-width: 600px; 
        margin: 0 auto;
        padding: 15px; 
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      }

      /* Disposition des lignes (2 champs côte à côte) */
      .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px; 
      }

      /* Styles pour chaque champ du formulaire */
      .form-group {
        flex-basis: 48%;
        margin-bottom: 10px; 
      }

      .form-group label {
        font-size: 13px;
        font-weight: 600;
        display: block;
        margin-bottom: 4px; 
        color: #333;
      }

      .form-input {
        width: 100%;
        padding: 12px; 
        font-size: 14px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
      }

      .form-input:focus {
        border-color: #0069d9;
        outline: none;
        background-color: #fff;
      }

      /* Ajustement pour mobile (1 champ par ligne) */
      @media (max-width: 768px) {
        .form-row {
          flex-direction: column;
        }

        .form-group {
          flex-basis: 100%;
          margin-left: 0;
        }
      }

      .swal2-popup {
        border-radius: 15px;
        padding: 30px;
      }

      .swal2-confirm {
        background-color: #28a745;
        color: white;
      }

      .swal2-cancel {
        background-color: #dc3545;
        color: white;
      }

      .swal2-popup .swal2-button {
        border-radius: 6px;
        padding: 10px 20px;
        font-size: 16px;
      }
    `;
    document.head.appendChild(style);
  });
</script>





<style>
  .form-container {
    font-family: 'Arial', sans-serif;
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    font-size: 14px;
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
    color: #333;
  }

  .form-input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border-radius: 4px;
    border: 1px solid #ccc;
    background-color: #fff;
    transition: border-color 0.3s ease;
  }

  .form-input:focus {
    border-color: #0056b3;
    outline: none;
  }

  .form-group input[type="url"],
  .form-group input[type="email"],
  .form-group input[type="tel"],
  .form-group input[type="password"],
  .form-group input[type="text"] {
    height: 40px;
  }

  .form-group input::placeholder {
    color: #999;
  }

  .swal2-popup {
    border-radius: 10px;
  }
</style>





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
