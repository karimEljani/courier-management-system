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
            </div>
        </div>

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <header class="py-4 bg-dark text-white">
                <h1 class="text-center text-white">Clients</h1>
                <p class="text-center text-white">Listes des Clients</p>

            </header>

            

            
            <div class="page-content">
                <section class="row"><hr>
                
                    <div class="col-12 col-lg-12">
                        <div class="table-responsive">
                            <table id="datatablesSimple" class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>E-mail</th>
                                        <th>Téléphone</th>
                                        <th>Adresse</th>
                                        <th>Genre</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                            
                            // Appeler la fonction qui récupère uniquement les clients acceptés
                            $getall = getAllcustomersAccepted(); 
                            while ($row = mysqli_fetch_assoc($getall)) {
                                $customer_id = $row['customer_id'];
                            ?>
                            <tr>
                                <td><?php echo $row['customer_id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['gender'] == "1" ? "Homme" : "Femme"; ?></td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="showDetails(<?php echo $customer_id; ?>)">
                                        <i class="bi bi-eye"></i> 
                                    </button>
                                    <button type="button" class="btn btn-danger delete-customer" data-id="<?php echo $customer_id; ?>">
                                    <i class="bi bi-trash"></i> 
                                </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <?php include 'pages/footer.php'; ?>

            </div>
        </div>

        <!-- Modal pour afficher les détails -->
        <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel">Détails du client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="detailsContent">
                        <!-- Détails chargés ici via AJAX -->
                        <p>Chargement des données...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour gérer la suppression -->
<script>
    $(document).on('click', '.delete-customer', function () {
    const customerId = $(this).data('id'); // Récupérer l'ID client

    Swal.fire({
        title: 'Supprimer ce client?',
        text: "Cette action est irréversible!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) { // Si l'utilisateur confirme
            $.ajax({
                url: 'delete_customer.php', // Appeler la page externe
                method: 'POST',
                data: {
                    action: 'delete',
                    customer_id: customerId // Passer l'ID client
                },
                success: function (response) {
                    const res = JSON.parse(response.trim()); // Convertir JSON
                    if (res.status === 'success') {
                        $('#customer-' + customerId).remove(); // Supprimer la ligne du tableau
                        Swal.fire('Supprimé!', 'Le client a été supprimé.', 'success');
                    } else {
                        Swal.fire('Erreur', res.message || 'Impossible de supprimer.', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Erreur', 'Erreur de connexion au serveur.', 'error');
                }
            });
        }
    });
});

</script>
    <script>
        function showDetails(customer_id) {
            const detailsContent = document.getElementById('detailsContent');
            detailsContent.innerHTML = '<p>Chargement des données...</p>';

            // Charger les détails via AJAX
            fetch(`get_customer_details.php?customer_id=${customer_id}`)
                .then(response => response.text())
                .then(data => {
                    detailsContent.innerHTML = data;
                    const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    detailsContent.innerHTML = '<p>Impossible de charger les détails.</p>';
                });
        }
    </script>
</body>

</html>
