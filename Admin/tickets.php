<?php
include 'pages/head.php';
include 'admin.php';
include 'checkAdmin.php';
include 'header.php';

// Récupérer tous les tickets
$query = "SELECT 
            t.ticket_id,
            t.request_id,
            t.name,
            t.date,
            t.description,
            t.category,
            t.status,
            r.tracking_status
          FROM tickets t
          JOIN request r ON t.request_id = r.request_id
          ORDER BY t.date DESC";

$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tickets</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-dt@1.12.1/css/jquery.dataTables.min.css"> <!-- DataTables CSS -->
</head>

<body style="background-color: #f4f7fa;">
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
                <h3>Gestion des Tickets</h3>
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des Tickets</li>
                        </ol>
                    </nav>
                </div>
                
            </div>
            <div class="page-content">    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestion des Tickets</h1>

        <!-- Tableau des tickets -->
        <?php if ($result && $result->num_rows > 0): ?>
            <table id="datatable2" class="table table-bordered table-hover">
                <thead class="bg-info text-white">
                    <tr>
                        <th>ID Ticket</th>
                        <th>ID Colis</th>
                        <th>Nom Client</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Catégorie</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr id="ticket-<?php echo $row['ticket_id']; ?>">
                            <td><?php echo $row['ticket_id']; ?></td>
                            <td><?php echo $row['request_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td id="status-<?php echo $row['ticket_id']; ?>">
                                <span class="badge <?php echo $row['status'] === 'Ouvert' ? 'bg-warning' : 'bg-success'; ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td>
                                <!-- Bouton Résoudre -->
                                <button class="btn btn-success btn-sm resolve-ticket" data-id="<?php echo $row['ticket_id']; ?>">
                                    <i class="fas fa-check"></i> 
                                </button>

                                <!-- Bouton Supprimer -->
                                <button class="btn btn-danger btn-sm delete-ticket" data-id="<?php echo $row['ticket_id']; ?>">
                                    <i class="fas fa-trash-alt"></i> 
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Aucun ticket disponible.</p>
        <?php endif; ?>
    </div>

    <?php include 'pages/footer.php'; ?>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net@1.12.1/js/jquery.dataTables.min.js"></script> <!-- DataTables JS -->

    <script>
         // Initialiser DataTable pour pagination et recherche
        $(document).ready(function() {
            $('#datatable2').DataTable({
                "paging": true, // Active la pagination
                "searching": true, // Active la recherche
                "ordering": true, // Active le tri des colonnes
                "info": true, // Affiche des informations de pagination
                "lengthChange": true, // Permet de changer le nombre d'éléments par page
            });
        });
        // Résoudre un ticket sans rechargement
        $(document).on('click', '.resolve-ticket', function () {
            const ticketId = $(this).data('id'); // ID du ticket

            Swal.fire({
                title: 'Marquer comme résolu?',
                text: 'Voulez-vous vraiment résoudre ce ticket?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) { // Exécuter seulement après confirmation
                    $.post('action_ticket.php', { action: 'resolve', ticket_id: ticketId }, function (response) {
                        const res = JSON.parse(response.trim());
                        if (res.status === 'success') {
                            // Mettre à jour le statut dans le tableau
                            $('#status-' + ticketId).html('<span class="badge bg-success">Résolu</span>');
                            Swal.fire('Succès!', 'Ticket résolu.', 'success');
                        } else {
                            Swal.fire('Erreur', res.message || 'Impossible de résoudre.', 'error');
                        }
                    });
                }
            });
        });

        // Supprimer un ticket sans rechargement
        $(document).on('click', '.delete-ticket', function () {
            const ticketId = $(this).data('id');

            Swal.fire({
                title: 'Supprimer ce ticket?',
                text: 'Cette action est irréversible!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) { // Exécuter seulement après confirmation
                    $.post('action_ticket.php', { action: 'delete', ticket_id: ticketId }, function (response) {
                        const res = JSON.parse(response.trim());
                        if (res.status === 'success') {
                            // Supprimer le ticket dans l'interface
                            $('#ticket-' + ticketId).remove();
                            Swal.fire('Supprimé!', 'Le ticket a été supprimé.', 'success');
                        } else {
                            Swal.fire('Erreur', res.message || 'Impossible de supprimer.', 'error');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
