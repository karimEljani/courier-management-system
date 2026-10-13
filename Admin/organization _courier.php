
<!DOCTYPE html>
<html lang="fr">

<?php include 'pages/head.php'; ?>
<?php include 'admin.php'; ?>

<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            <!-- En-tête -->
            <header class="py-4 bg-dark text-white">
                <h1 class="text-center">Organisation des Colis</h1>
                <p class="text-center">Suivez l'état de chaque commande facilement</p>
            </header>

            <!-- Barre de recherche -->
            <div class="container mt-3 mb-4">
                <input type="text" id="searchBar" class="form-control" placeholder="Rechercher par ID, Adresse ou Téléphone">
            </div>

            <!-- Navigation par onglets -->
            <ul class="nav nav-tabs mt-4 container" id="deliveryTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="in-progress-tab" data-bs-toggle="tab" data-bs-target="#in-progress" type="button" role="tab" aria-controls="in-progress" aria-selected="true">
                        <i class="bi bi-truck"></i> En cours de livraison
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivered" type="button" role="tab" aria-controls="delivered" aria-selected="false">
                        <i class="bi bi-check-circle"></i> Livré
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="not-delivered-tab" data-bs-toggle="tab" data-bs-target="#not-delivered" type="button" role="tab" aria-controls="not-delivered" aria-selected="false">
                        <i class="bi bi-hourglass-split"></i> Non livré
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled" aria-selected="false">
                        <i class="bi bi-x-circle"></i> Annulé
                    </button>
                </li>
            </ul>

            <!-- Contenu des onglets -->
            <div class="tab-content mt-4 container">
                <!-- En cours de livraison -->
                <div class="tab-pane fade show active" id="in-progress" role="tabpanel" aria-labelledby="in-progress-tab">
                <div class="row" id="inProgressContainer">
                    <?php
                    $getAll = getAllTracking();
                    while ($row = mysqli_fetch_assoc($getAll)) {
                        if ($row['tracking_status'] == 2 || $row['tracking_status'] == 3) {
                    ?>
                        <div class="col-md-6 col-lg-4 delivery-card" data-id="<?php echo $row['request_id']; ?>" data-address="<?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?>" data-phone="<?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="card mb-4 border-warning shadow">
                                <div class="card-header bg-warning text-white">
                                    <strong>ID Commande: #<?php echo $row['request_id']; ?></strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Adresse :</strong> <?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <!-- Boutons pour marquer la commande comme livrée ou non livrée -->
                                    <button class="btn btn-success mt-2" onclick="confirmUpdateOrderStatus(<?php echo $row['request_id']; ?>, 4)">L</button>
                                    <button class="btn btn-danger mt-2" onclick="confirmUpdateOrderStatus(<?php echo $row['request_id']; ?>, 5)">N</button>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

<script>
function confirmUpdateOrderStatus(requestId, status) {
    Swal.fire({
        title: 'Confirmer l\'action',
        text: 'Voulez-vous vraiment mettre à jour le statut de cette commande ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, mettre à jour',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            // Appeler la fonction pour mettre à jour le statut de la commande
            updateOrderStatus(requestId, status);
        }
    });
}

function updateOrderStatus(requestId, status) {
    fetch('', {
        method: 'POST',
        body: JSON.stringify({ request_id: requestId, tracking_status: status }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.text())
    .then(data => {
        // Afficher une notification SweetAlert en cas de succès
        Swal.fire({
            title: 'Succès',
            text: 'Statut mis à jour avec succès!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            location.reload(); // Recharger la page pour voir les changements
        });
    })
    .catch(error => {
        console.error('Erreur:', error);
        // Afficher une notification SweetAlert en cas d'erreur
        Swal.fire({
            title: 'Erreur',
            text: 'Erreur lors de la mise à jour du statut.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}
</script>

<!-- Inclure la bibliothèque SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


                <?php
                // Traitement côté serveur pour mettre à jour le statut
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $data = json_decode(file_get_contents('php://input'), true);
                    if (isset($data['request_id']) && isset($data['tracking_status'])) {
                        $requestId = $data['request_id'];
                        $trackingStatus = $data['tracking_status'];

                        // Connexion à la base de données
                        $conn = new mysqli("localhost", "root", "", "royal_express_db");
                        if ($conn->connect_error) {
                            die("Connexion échouée: " . $conn->connect_error);
                        }

                        // Mise à jour du statut
                        $stmt = $conn->prepare("UPDATE request SET tracking_status = ? WHERE request_id = ?");
                        $stmt->bind_param("ii", $trackingStatus, $requestId);

                        if ($stmt->execute()) {
                            echo "Statut mis à jour";
                        } else {
                            echo "Erreur lors de la mise à jour: " . $stmt->error;
                        }

                        $stmt->close();
                        $conn->close();
                    } else {
                        echo "Données manquantes.";
                    }
                }
                ?>


                <!-- Livré -->
                <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                    <div class="row" id="deliveredContainer">
                        <?php
                        $getAll = getAllTracking();
                        while ($row = mysqli_fetch_assoc($getAll)) {
                            if ($row['tracking_status'] == 4) {
                        ?>
                                <div class="col-md-6 col-lg-4 delivery-card" data-id="<?php echo $row['request_id']; ?>" data-address="<?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?>" data-phone="<?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <div class="card mb-4 border-success shadow">
                                        <div class="card-header bg-success text-white">
                                            <strong>ID Commande: #<?php echo $row['request_id']; ?></strong>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Adresse :</strong> <?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Non livré -->
                <div class="tab-pane fade" id="not-delivered" role="tabpanel" aria-labelledby="not-delivered-tab">
                    <div class="row" id="notDeliveredContainer">
                        <?php
                        $getAll = getAllTracking();
                        while ($row = mysqli_fetch_assoc($getAll)) {
                            if ($row['tracking_status'] == 1) {
                        ?>
                                <div class="col-md-6 col-lg-4 delivery-card" data-id="<?php echo $row['request_id']; ?>" data-address="<?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?>" data-phone="<?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <div class="card mb-4 border-info shadow">
                                        <div class="card-header bg-info text-white">
                                            <strong>ID Commande: #<?php echo $row['request_id']; ?></strong>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Adresse :</strong> <?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            <p><strong>Emplacement final :</strong> 
                                                        <?php
                                                        $getLocation = getAllAreabyID($row['end_location']);
                                                        if ($row2 = mysqli_fetch_assoc($getLocation)) {
                                                            echo htmlspecialchars($row2['area_name'], ENT_QUOTES, 'UTF-8');
                                                        }
                                                        ?>
                                            </p>

                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Annulé -->
                <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                    <div class="row" id="cancelledContainer">
                        <?php
                        $getAll = getAllTracking();
                        while ($row = mysqli_fetch_assoc($getAll)) {
                            if ($row['tracking_status'] == 5) {
                        ?>
                                <div class="col-md-6 col-lg-4 delivery-card" data-id="<?php echo $row['request_id']; ?>" data-address="<?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?>" data-phone="<?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <div class="card mb-4 border-danger shadow">
                                        <div class="card-header bg-danger text-white">
                                            <strong>ID Commande: #<?php echo $row['request_id']; ?></strong>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Adresse :</strong> <?php echo htmlspecialchars($row['red_address'], ENT_QUOTES, 'UTF-8'); ?></p>
                                            <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($row['res_phone'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <h1 class="text-center">Organisation des Colis par Zone</h1>

                <!-- Barre de navigation des zones -->
                <ul class="nav nav-tabs" id="areaTabs" role="tablist">
                    <?php
                    // Connexion à la base de données
                    $conn = new mysqli("localhost", "root", "", "royal_express_db");
                    if ($conn->connect_error) {
                        die("Erreur de connexion : " . $conn->connect_error);
                    }

                    // Récupérer toutes les zones depuis la table `area`
                    $sqlAreas = "SELECT area_name FROM area";
                    $resultAreas = $conn->query($sqlAreas);

                    $isActive = true;
                    while ($areaRow = $resultAreas->fetch_assoc()) {
                        $areaName = htmlspecialchars($areaRow['area_name'], ENT_QUOTES, 'UTF-8');
                        $areaId = urlencode($areaName); // Utiliser urlencode pour gérer les espaces dans l'ID
                        $activeClass = $isActive ? 'active' : '';
                        $isActive = false;
                        echo "
                        <li class='nav-item' role='presentation'>
                            <button class='nav-link $activeClass' id='tab-$areaId' data-bs-toggle='tab' data-bs-target='#content-$areaId' type='button' role='tab' aria-controls='content-$areaId' aria-selected='" . ($activeClass ? 'true' : 'false') . "'>
                                $areaName
                            </button>
                        </li>";
                    }
                    ?>
                </ul>

                <!-- Contenu des onglets -->
                <div class="tab-content mt-4">
                    <?php
                    mysqli_data_seek($resultAreas, 0); // Réinitialiser le pointeur pour relire les zones
                    $isActive = true;
                    while ($areaRow = $resultAreas->fetch_assoc()) {
                        $areaName = htmlspecialchars($areaRow['area_name'], ENT_QUOTES, 'UTF-8');
                        $areaId = urlencode($areaName); // Utiliser urlencode pour gérer les espaces dans l'ID
                        $activeClass = $isActive ? 'show active' : '';
                        $isActive = false;
                        echo "<div class='tab-pane fade $activeClass' id='content-$areaId' role='tabpanel' aria-labelledby='tab-$areaId'>";

                        // Charger les colis pour cette zone
                        $getPackages = "SELECT r.*, a.area_name FROM request r 
                                        JOIN area a ON r.end_location = a.area_id 
                                        WHERE a.area_name = '$areaName'";
                        $packagesResult = mysqli_query($conn, $getPackages);

                        echo "
                        <div class='d-flex justify-content-end mb-3'>
                            <a href='print_packages.php?area=$areaName' class='btn btn-primary'>
                                Imprimer les colis ($areaName) <i class='fa fa-print'></i>
                            </a>
                        </div>";

                        echo "<div class='table-responsive'>
                                <table id='datatablesSimple' class='table table-bordered table-hover'>
                                    <thead class='bg-info text-white'>
                                        <tr>
                                            <th>ID_C</th>
                                            <th>Nom Destinataire</th>
                                            <th>Adresse</th>
                                            <th>Téléphone</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                        while ($package = mysqli_fetch_assoc($packagesResult)) {
                            echo "
                            <tr>
                                <td>#{$package['request_id']}</td>
                                <td>{$package['res_name']}</td>
                                <td>{$package['red_address']}</td>
                                <td>{$package['res_phone']}</td>
                                <td>";
                            switch ($package['tracking_status']) {
                                case 4:
                                    echo "<span class='badge bg-success'>Livré</span>";
                                    break;
                                case 1:
                                    echo "<span class='badge bg-danger'>Non livré</span>";
                                    break;
                                default:
                                    echo "<span class='badge bg-warning'>En cours</span>";
                                    break;
                            }
                            echo "</td>
                                <td class='text-center'>
                                    <button class='btn btn-success btn-sm' " . ($package['tracking_status'] == 4 ? 'disabled' : "onclick='updateStatus({$package['request_id']}, 4)'") . ">
                                        Livré <i class='fa fa-check-circle'></i>
                                    </button>
                                    <button class='btn btn-danger btn-sm' " . ($package['tracking_status'] == 1 ? 'disabled' : "onclick='updateStatus({$package['request_id']}, 1)'") . ">
                                        Non Livré <i class='fa fa-times-circle'></i>
                                    </button>
                                </td>
                            </tr>";
                        }
                        echo "</tbody>
                            </table>
                        </div>";

                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <script>
                function updateStatus(requestId, status) {
                    Swal.fire({
                        title: 'Mettre à jour le statut',
                        text: `Êtes-vous sûr de vouloir marquer cette commande comme ${status === 4 ? 'Livré' : 'Non Livré'} ?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Mise à jour du statut directement dans la base de données
                            fetch('', {
                                method: 'POST',
                                body: JSON.stringify({ request_id: requestId, tracking_status: status }),
                                headers: { 'Content-Type': 'application/json' }
                            }).then(response => response.text())
                            .then(data => {
                                Swal.fire({
                                    title: 'Succès',
                                    text: 'Statut mis à jour avec succès.',
                                    icon: 'success'
                                }).then(() => {
                                    // Recharger la page pour afficher la mise à jour
                                    location.reload();
                                });
                            }).catch(error => {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: 'Erreur lors de la mise à jour.',
                                    icon: 'error'
                                });
                            });
                        }
                    });
                }
                
            </script>







            <?php include 'pages/footer.php'; ?>


        </div>

        
    </div>

    

    <script>
        // Fonction de recherche
        const searchBar = document.getElementById('searchBar');
        searchBar.addEventListener('input', function() {
            const query = searchBar.value.toLowerCase();
            const cards = document.querySelectorAll('.delivery-card');

            cards.forEach(card => {
                const id = card.getAttribute('data-id').toLowerCase();
                const address = card.getAttribute('data-address').toLowerCase();
                const phone = card.getAttribute('data-phone').toLowerCase();

                if (id.includes(query) || address.includes(query) || phone.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>








<script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>
