<!DOCTYPE html>
<html lang="fr">

<?php include 'pages/head.php'; ?>
<?php include 'admin.php'; ?>
<?php include 'header.php'; ?>
<style>
/* Style du Toggle Switch */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    border-radius: 50%;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
}

input:checked + .slider {
    background-color: #4CAF50;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.fa-envelope {
    font-size: 20px;
    cursor: default;
    transition: 0.3s;
}

.fa-envelope.sent {
    color: green;
}

.fa-envelope.not-sent {
    color: red;
}
.fa-envelope {
    font-size: 20px;
    margin-right: 5px;
    cursor: default;
}

.text-success {
    color: #28a745 !important; /* Vert */
}

.text-danger {
    color: #dc3545 !important; /* Rouge */
}

</style>
<body style="background-color: #f4f7fa;">

    <div id="app">
        <!-- Sidebar -->
        <!-- Sidebar -->
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
            </div>
        </div>

        <!-- Main content -->
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3 class=" text-dark">Demandes de création de compte</h3>
            </div>

            <div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="card-title text-white">Tableau des demandes</h4>
                    <!-- Formulaire de recherche -->
                    <div class="d-flex justify-content-end align-items-center">
                        <input type="date" id="searchDate" class="form-control me-2" placeholder="Rechercher par date" />
                        <input type="text" id="searchQuery" class="form-control me-2" placeholder="Rechercher par nom, email, ou téléphone" />
                        <button class="btn btn-warning" onclick="filterTable()">Rechercher</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="requestsTable">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Télé</th>
                                <th>Date de demande</th>
                                <th>Statut actuel</th>
                                <th>Actions</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Connexion à la base de données
                            $host = "localhost";
                            $user = "root";
                            $password = "";
                            $db = "royal_express_db";
                            $con = new mysqli($host, $user, $password, $db);

                            if ($con->connect_error) {
                                die("Erreur de connexion : " . $con->connect_error);
                            }

                            $sql = "SELECT customer_id, name, email, phone, request_date, status, email_sent FROM customer ORDER BY request_date DESC";
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr data-name='{$row['name']}' data-email='{$row['email']}' data-phone='{$row['phone']}' data-date='{$row['request_date']}'>";
                                    echo "<td>" . $row['customer_id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>" . $row['request_date'] . "</td>";

                                    $status = ucfirst($row['status']);
                                    $badgeClass = match ($row['status']) {
                                        'accepted' => 'badge bg-success',
                                        'rejected' => 'badge bg-danger',
                                        'pending' => 'badge bg-warning text-dark',
                                        default => 'badge bg-secondary',
                                    };

                                    echo "<td><span class='$badgeClass'>$status</span></td>";

                                    // Boutons d'action
                                    echo "<td>
                                            <label class='switch'>
                                                <input type='checkbox' class='toggleSwitch' data-id='" . $row['customer_id'] . "' " . ($row['status'] === 'accepted' ? "checked" : "") . ">
                                                <span class='slider'></span>
                                            </label>
                                            <button class='btn btn-outline-primary btn-sm sendEmailBtn' data-id='" . $row['customer_id'] . "'>Envoyer Email</button>
                                        </td>";

                                    // Icône dynamique pour email envoyé
                                    $emailIconClass = $row['email_sent'] ? 'fa-envelope text-success' : 'fa-envelope text-danger';
                                    echo "<td>
                                            <i class='fa $emailIconClass sendEmailIcon' data-id='" . $row['customer_id'] . "'></i>
                                        </td>";

                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>Aucune demande trouvée.</td></tr>";
                            }

                            $con->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
        </div>
    </div>

    <script>
    // Utiliser le toggle pour afficher/masquer le bouton "Envoyer Email"
    $(document).ready(function() {
        // Lors du changement d'état du toggle
        $('.toggleSwitch').on('change', function() {
            var customerId = $(this).data('id');
            var status = $(this).prop('checked') ? 'accepted' : 'rejected';
    
            // Mettre à jour le statut dans la base de données
            updateRequestStatus(customerId, status);
        });
    
        // Fonction pour mettre à jour le statut dans la base de données
        function updateRequestStatus(requestId, status) {
            $.ajax({
                url: 'update_request_status.php', // Le fichier PHP pour mettre à jour le statut et envoyer l'email
                method: 'POST',
                data: { requestId: requestId, status: status },
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire({
                            title: status === 'accepted' ? 'Demande acceptée' : 'Demande refusée',
                            icon: status === 'accepted' ? 'success' : 'error',
                            confirmButtonText: 'Ok'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Erreur', 'Erreur lors de la mise à jour.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Erreur', 'Erreur de communication avec le serveur.', 'error');
                }
            });
        }
    
        // Fonction pour envoyer l'email
        $(document).on('click', '.sendEmailBtn', function() {
            var customerId = $(this).data('id');
            
            // Logic pour envoyer l'email (ou appeler une autre fonction AJAX si nécessaire)
            alert("Envoi de l'email à l'utilisateur avec l'ID " + customerId);
        });
    });
    


    function sendEmail(requestId) {
        $.ajax({
            url: 'send_email.php', // Le fichier PHP pour envoyer l'e-mail
            method: 'POST',
            data: { requestId: requestId },
            success: function(response) {
                if (response === 'success') {
                    Swal.fire('Succès', 'L\'e-mail a été envoyé.', 'success');
                } else {
                    Swal.fire('Erreur', 'Erreur lors de l\'envoi de l\'e-mail.', 'error');
                }
            },
            error: function() {
                Swal.fire('Erreur', 'Erreur de communication avec le serveur.', 'error');
            }
        });
    }

    document.querySelectorAll('.acceptBtn').forEach(button => {
        button.addEventListener('click', () => {
            const requestId = button.getAttribute('data-id');
            updateRequestStatus(requestId, 'accepted');
        });
    });

    document.querySelectorAll('.rejectBtn').forEach(button => {
        button.addEventListener('click', () => {
            const requestId = button.getAttribute('data-id');
            updateRequestStatus(requestId, 'rejected');
        });
    });

    document.querySelectorAll('.sendEmailBtn').forEach(button => {
        button.addEventListener('click', () => {
            const requestId = button.getAttribute('data-id');
            sendEmail(requestId);
        });
    });
</script>
<script>
    // Envoi d'email et mise à jour de l'état
    $(document).on('click', '.sendEmailIcon', function() {
        var customerId = $(this).data('id');
        var icon = $(this);

        $.ajax({
            url: 'send_email.php',
            method: 'POST',
            data: { requestId: customerId },
            success: function(response) {
                if (response === 'success') {
                    icon.removeClass('not-sent').addClass('sent');
                    Swal.fire('Succès', 'L\'e-mail a été envoyé.', 'success');
                } else {
                    Swal.fire('Erreur', 'Erreur lors de l\'envoi de l\'e-mail.', 'error');
                }
            },
            error: function() {
                Swal.fire('Erreur', 'Erreur de communication avec le serveur.', 'error');
            }
        });
    });
    </script>
    <script>
    function filterTable() {
        const searchDate = document.getElementById('searchDate').value.toLowerCase();
        const searchQuery = document.getElementById('searchQuery').value.toLowerCase();
        const rows = document.querySelectorAll('#requestsTable tbody tr');

        rows.forEach(row => {
            const name = row.getAttribute('data-name').toLowerCase();
            const email = row.getAttribute('data-email').toLowerCase();
            const phone = row.getAttribute('data-phone').toLowerCase();
            const date = row.getAttribute('data-date').toLowerCase();

            const matchesQuery = name.includes(searchQuery) || email.includes(searchQuery) || phone.includes(searchQuery);
            const matchesDate = searchDate === '' || date.includes(searchDate);

            if (matchesQuery && matchesDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>


</body>

</html>
