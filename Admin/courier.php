<!DOCTYPE html>
<html lang="en">

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
                <h3 class="text-dark">Demande de Colis</h3>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des colis</li>
                        </ol>
                    </nav>
                </div>
                
                
            </div>
            <div class="page-content">
                <!-- Champ de recherche -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une commande par ID, adresse ou téléphone..." onkeyup="filterOrders()">
                    </div>
                    <div class="col-md-4">
                        <input type="date" id="searchDate" class="form-control" placeholder="Rechercher par date" onchange="filterOrders()">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" onclick="filterOrders()">Rechercher</button>
                    </div>
                </div>

    <div id="ordersContainer">
        <?php
        // Connexion à la base de données
        $conn = new mysqli("localhost", "root", "", "royal_express_db");

        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

        // Récupérer toutes les commandes
        $getall = getAllTracking();

        while ($row = mysqli_fetch_assoc($getall)) {
            $request_id = $row['request_id'];
        ?>
            <article class="card mt-5 order-card" style="border: 2px solid #2c3e50;"
                     data-id="<?php echo htmlspecialchars($row['request_id'], ENT_QUOTES, 'UTF-8'); ?>"
                     data-address="<?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?>"
                     data-phone="<?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?>"
                     data-date="<?php echo htmlspecialchars($row['date_updated'], ENT_QUOTES, 'UTF-8'); ?>">
                <header class="card-header text-white" style="background-color: #2c3e50; border-radius: 0px;">
                    Commandes / Suivi
                </header>
                <div class="card-body mt-3">
                    <h6>Suivi ID: #<?php echo $row['request_id']; ?></h6>
                    <article class="card">
                        <div class="card-body row">
                            <div class="col">
                                <strong><i class="fa-solid fa-money-bill"></i> Prix Total:</strong>
                                <br><?php echo htmlspecialchars($row['total_fee'], ENT_QUOTES, 'UTF-8'); ?> <?php echo "DT"?>
                            </div>
                            <div class="col">
                                <strong><i class="fa-solid fa-mobile-screen-button"></i> Télé du Récepteur:</strong>
                                <br><?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="col">
                                <strong><i class="fa-solid fa-circle-info"></i> Statut actuel:</strong>
                                <br>
                                <?php
                                switch ($row['tracking_status']) {
                                    case 1: echo 'Commande en attente'; break;
                                    case 2: echo 'Préparer la commande'; break;
                                    case 3: echo 'Commande expédiée'; break;
                                    case 4: echo 'Livré'; break;
                                    case 5: echo 'Annulé'; break;
                                    default: echo 'Statut inconnu';
                                }
                                ?>
                            </div>
                            <div class="col">
                                <strong><i class="fa-solid fa-calendar-days"></i> Date demandée:</strong>
                                <br><?php echo htmlspecialchars($row['date_updated'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>
                        <div class="card-body row">
                            <div class="col">
                                <strong><i class="fa-solid fa-boxes-stacked"></i> Nombre de paquets:</strong>
                                <br><?php echo htmlspecialchars($row['nbre_paquets'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="col">
                                <strong><i class="fa-solid fa-phone"></i> Télé de l'expéditeur:</strong>
                                <br><?php echo htmlspecialchars($row['sender_phone'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="col">
                                <strong><i class="fa-solid fa-location-arrow"></i> Emplacement de l'envoi:</strong>
                                <br>
                                <?php
                                $getLocation = getAllAreabyID($row['send_location']);
                                if ($row2 = mysqli_fetch_assoc($getLocation)) {
                                    echo htmlspecialchars($row2['area_name'], ENT_QUOTES, 'UTF-8');
                                }
                                ?>
                            </div>
                            <div class="col">
                                <strong><i class="fa-solid fa-map-pin"></i> Emplacement final:</strong>
                                <br>
                                <?php
                                $getLocation = getAllAreabyID($row['end_location']);
                                if ($row2 = mysqli_fetch_assoc($getLocation)) {
                                    echo htmlspecialchars($row2['area_name'], ENT_QUOTES, 'UTF-8');
                                }
                                ?>
                                <br><?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?>

                            </div>
                            <?php if ($row['tracking_status'] != 5) { ?>
                                <div class="track">
                                    <div class="step <?php if (in_array($row['tracking_status'], [1, 2, 3, 4])) echo 'active'; ?>">
                                        <span class="icon"><i class="fa-solid fa-check"></i></span>
                                        <span class="text">Commande confirmée</span>
                                    </div>
                                    <div class="step <?php if (in_array($row['tracking_status'], [2, 3, 4])) echo 'active'; ?>">
                                        <span class="icon"><i class="fa-solid fa-box-open"></i></span>
                                        <span class="text">Préparer la commande</span>
                                    </div>
                                    <div class="step <?php if (in_array($row['tracking_status'], [3, 4])) echo 'active'; ?>">
                                        <span class="icon"><i class="fa-solid fa-truck"></i></span>
                                        <span class="text">Commande expédiée</span>
                                    </div>
                                    <div class="step <?php if ($row['tracking_status'] == 4) echo 'active'; ?>">
                                        <span class="icon"><i class="fa-solid fa-box"></i></span>
                                        <span class="text">Livré</span>
                                    </div>
                                </div>
                            <?php } ?>

                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="tracking_status" class="form-label">Statut de la commande</label>
                                    <select onchange='updateData(this, "<?php echo $request_id; ?>", "tracking_status", "request", "request_id")' id="tracking_status_<?php echo $request_id; ?>" class='form-control'>
                                        <option value="1" <?php if ($row['tracking_status'] == "1") echo "selected"; ?>>Commande en attente</option>
                                        <option value="2" <?php if ($row['tracking_status'] == "2") echo "selected"; ?>>Préparer la commande</option>
                                        <option value="3" <?php if ($row['tracking_status'] == "3") echo "selected"; ?>>Commande expédiée</option>
                                        <option value="4" <?php if ($row['tracking_status'] == "4") echo "selected"; ?>>Livré</option>
                                        <option value="5" <?php if ($row['tracking_status'] == "5") echo "selected"; ?>>Annulé</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" onclick="permenantdeleteData(<?php echo $row['request_id']; ?>, 'request', 'request_id')" class="btn btn-darkblue">
                                        <h6><label for="delete_order" class="form-label">Supprimer la commande: <i class="fa-solid fa-trash"></i></label></h6>

                                    </button>
                                </div>

                                <div class="col mt-3">
                                <a href="getbill.php?customer_id=<?php echo $row['customer_id']; ?>&request_id=<?php echo $request_id; ?>" 
                                class="btn btn-darkblue">
                                    <h6>Imprimer <i class="fa-solid fa-file-pdf"></i></h6> 
                                </a>
                                </div>
                            </div>
                            <!--
                             <div class="row mt-3">
                                <a href="getbill.php?customer_id=<?php echo $_SESSION['customer']; ?>&request_id=<?php echo $request_id; ?>" class="btn btn-darkblue">
                                    Imprimer <i class="fa-solid fa-file-pdf"></i>
                                </a>
                            </div>
                            -->
                            

                        </div>
                    </article>
                </div>
            </article>
        <?php } ?>
    </div>
</div>

<script>
    // Fonction de filtrage des commandes
    function filterOrders() {
        const searchInput = document.getElementById("searchInput").value.toLowerCase();
        const searchDate = document.getElementById('searchDate').value;
        const orderCards = document.getElementsByClassName("order-card");

        for (let card of orderCards) {
            const id = card.getAttribute('data-id').toLowerCase();
            const address = card.getAttribute('data-address').toLowerCase();
            const phone = card.getAttribute('data-phone').toLowerCase();
            const orderDate = card.getAttribute('data-date');

            const matchesSearch = id.includes(searchInput) || address.includes(searchInput) || phone.includes(searchInput);
            const matchesDate = (!searchDate || orderDate.startsWith(searchDate));

            if (matchesSearch && matchesDate) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        }
    }
</script>



                        <?php include 'pages/footer.php'; ?>
        </div>
    </div>


    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script src="assets/js/main.js"></script>
</body>
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



</html>