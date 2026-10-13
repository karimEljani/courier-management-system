<!DOCTYPE html>
<html lang="fr">

<?php include 'pages/head.php'; ?>
<?php include 'admin.php'; ?>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
<body style="background-color: #f4f7fa;">
    <div id="app">
        <div id="sidebar" class="active" >
            <div class="sidebar-wrapper active">
                <div class="sidebar-header" style="width: 200px; height: 100px;">
                    <div class="d-flex justify-content-between align-items-center mt-0 px-3 py-2 ">
                        <a href="index.php" class="d-flex align-items-center text-decoration-none">
                            <img src="assets/images/logo/logo2.png" alt="Logo WassaleyDelivery" class="sidebar-logo me-2" style="width: 200px; height: 100px;">
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

            <!-- Rapport des Gains -->
            <div class="container mt-5">
                <h1 class=" text-dark">Rapport des Gains</h1>
                <p class=" text-muted">Détails des gains réalisés à partir des colis livrés.</p>

                <!-- Boutons d'exportation -->
                <div class="export-buttons d-flex justify-content-end mb-3">
                    <a href="export_price_pdf.php" class="btn btn-danger me-2">Exporter en PDF <i class="fa fa-file-pdf"></i></a>
                    <a href="export_price_excel.php" class="btn btn-success">Exporter en Excel <i class="fa fa-file-excel"></i></a>
                </div>

                <!-- Tableau -->
                <div class="table-responsive">
                    <table id="datatable1" class="table table-bordered table-hover">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>ID Commande</th>
                                <th>Nombre de Paquets</th>
                                <th>Gain (DT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Connexion à la base de données
                            $con = new mysqli("localhost", "root", "", "royal_express_db");
                            if ($con->connect_error) {
                                die("Erreur de connexion : " . $con->connect_error);
                            }

                            // Récupérer les colis livrés
                            $query = "SELECT request_id, nbre_paquets FROM request WHERE tracking_status = 4";
                            $result = $con->query($query);
                            if ($result) {
                                $gainParPaquet = 8;
                                $gainTotal = 0;

                                while ($row = $result->fetch_assoc()) {
                                    $nbrePaquets = $row['nbre_paquets'];
                                    $gainColis = $gainParPaquet * $nbrePaquets;
                                    $gainTotal += $gainColis;
                                    echo "
                                    <tr>
                                        <td>#{$row['request_id']}</td>
                                        <td>{$row['nbre_paquets']}</td>
                                        <td>{$gainColis} DT</td>
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Afficher le gain total -->
                <div class="text-end mt-3py-4 bg-success text-white" >
                    <h4 class="text-white"> Gain Total : <?php echo htmlspecialchars($gainTotal ?? 0); ?> DT <i class="fa-solid fa-coins"></i></h4>
                </div>

                <?php

                // Connexion à la base de données
                include '../server/inc/connection.php';

                // Variables pour la recherche par dates
                $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

                // Requête SQL avec recherche par dates
                $query = "
                    SELECT 
                        r.sender_phone, 
                        SUM(r.total_fee) AS total_due, 
                        COUNT(r.request_id) AS total_packages, 
                        c.name AS sender_name, 
                        MAX(CASE WHEN p.status = 'Paid' THEN 'Paid' ELSE 'Unpaid' END) AS status
                    FROM request r
                    LEFT JOIN customer c ON r.sender_phone = c.phone
                    LEFT JOIN payments p ON r.request_id = p.request_id
                    WHERE r.tracking_status = 4
                ";

                // Ajouter des conditions pour les dates si elles sont fournies
                if (!empty($startDate) && !empty($endDate)) {
                    $query .= " AND DATE(r.date_updated) BETWEEN ? AND ?";
                }

                $query .= " GROUP BY r.sender_phone";

                $stmt = $con->prepare($query);

                // Lier les paramètres si les dates sont fournies
                if (!empty($startDate) && !empty($endDate)) {
                    $stmt->bind_param("ss", $startDate, $endDate);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                ?>

                        </br><hr>
                        <h1 class="text-center">Gestion des Paiements pour les Expéditeurs</h1>

                        <!-- Formulaire de recherche par dates -->
                        <form method="GET" class="mt-4 mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="start_date" class="form-label">Date de début</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($startDate); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date" class="form-label">Date de fin</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($endDate); ?>">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Rechercher</button>
                                </div>
                            </div>
                        </form>

                        <div class="card mt-4">
    <div class="card-header bg-dark text-white">
        <h3>Expéditeurs et Totaux</h3>
    </div>
    <div class="card-body">
    <?php if ($result->num_rows > 0): ?>
    <table id="datatable2" class="table table-bordered table-hover">
        <thead class="bg-info text-white">
            <tr>
                <th>Nom Expéditeur</th>
                <th>Téléphone Expéditeur</th>
                <th>Total Colis Livrés</th>
                <th>Total Dû (DT)</th>
                <th>Action</th>
                <th>Statut Paiement</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php
                // Récupérer les colis associés à l'expéditeur
                $senderPhone = $row['sender_phone'];
                $queryColis = "
                    SELECT total_fee, nbre_paquets 
                    FROM request 
                    WHERE sender_phone = ? AND tracking_status = 4
                ";
                $stmtColis = $con->prepare($queryColis);
                $stmtColis->bind_param("s", $senderPhone);
                $stmtColis->execute();
                $resultColis = $stmtColis->get_result();

                // Calculer le total dû
                $totalDue = 0;
                while ($colis = $resultColis->fetch_assoc()) {
                    $totalDue += $colis['total_fee'] - (8.3 * $colis['nbre_paquets']);
                }
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['sender_name']); ?></td>
                <td><?php echo htmlspecialchars($row['sender_phone']); ?></td>
                <td><?php echo htmlspecialchars($row['total_packages']); ?></td>
                <td><?php echo number_format($totalDue, 2); ?> DT</td>
                <td style="text-align: center; padding: 10px;">

                    <!-- Bouton Détails -->
                    <button 
                        class="btn btn-info view-packages" 
                        data-phone="<?php echo $row['sender_phone']; ?>"
                        data-name="<?php echo htmlspecialchars($row['sender_name']); ?>">
                        <i class="fas fa-eye"></i>
                    </button>

                    <!-- Bouton Reçu -->
                    <button 
                        class="btn btn-success print-receipt" 
                        data-phone="<?php echo $row['sender_phone']; ?>" 
                        data-name="<?php echo htmlspecialchars($row['sender_name']); ?>" 
                        data-total="<?php echo number_format($totalDue, 2); ?>" 
                        data-packages="<?php echo htmlspecialchars($row['total_packages']); ?>">
                        <i class="fas fa-print"></i>
                    </button>

                    <!-- Bouton Supprimer (affiché si paiement est 'Payé') -->
                    <?php if ($row['status'] == 'Paid'): ?>
                        <button 
                            class="btn btn-danger delete-entry" 
                            data-phone="<?php echo $row['sender_phone']; ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    <?php endif; ?>

                </td>

                <!-- Statut Paiement -->
                <td>
                    <?php if ($row['status'] == 'Paid'): ?>
                        <span class="badge bg-success">Payé</span>
                        <button 
                            class="btn btn-danger btn-sm toggle-payment" 
                            data-phone="<?php echo $row['sender_phone']; ?>" 
                            data-status="Unpaid">
                                Non Payé
                        </button>
                    <?php else: ?>
                        <span class="badge bg-warning">Non Payé</span>
                        <button 
                            class="btn btn-primary btn-sm toggle-payment" 
                            data-phone="<?php echo $row['sender_phone']; ?>" 
                            data-status="Paid">
                                Payé
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center">Aucun colis livré pour le moment.</p>
<?php endif; ?>

    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Mettre à jour le statut de paiement
    $(document).on('click', '.toggle-payment', function () {
        const senderPhone = $(this).data('phone');
        const newStatus = $(this).data('status');

        $.ajax({
            url: 'mark_payment.php',
            method: 'POST',
            data: {
                sender_phone: senderPhone,
                payment_status: newStatus
            },
            success: function (response) {
                if (response === 'success') {
                    alert('Statut de paiement mis à jour.');
                    location.reload();
                } else {
                    alert('Erreur lors de la mise à jour du statut de paiement : ' + response);
                }
            },
            error: function () {
                alert('Une erreur est survenue. Veuillez réessayer.');
            }
        });
    });

    // Supprimer une entrée
    $(document).on('click', '.delete-entry', function () {
        const senderPhone = $(this).data('phone');

        Swal.fire({
            title: "Êtes-vous sûr ?",
            text: "Cette action est irréversible !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Oui, supprimer !",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_entry.php', // Fichier PHP pour suppression
                    method: 'POST',
                    data: {
                        sender_phone: senderPhone
                    },
                    success: function (response) {
                        if (response === 'success') {
                            Swal.fire("Supprimé !", "L'entrée a été supprimée avec succès.", "success");
                            location.reload();
                        } else {
                            Swal.fire("Erreur !", "Impossible de supprimer l'entrée.", "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Erreur !", "Une erreur s'est produite. Veuillez réessayer.", "error");
                    }
                });
            }
        });
    });
</script>

            <script>
                // Lorsque le bouton "Voir les Colis" est cliqué
                $(document).on('click', '.view-packages', function () {
                    const senderPhone = $(this).data('phone');

                    // Appel AJAX pour récupérer les données des colis
                    $.ajax({
                        url: 'fetch_colis.php', // Script PHP pour récupérer les données des colis
                        method: 'GET',
                        data: { sender_phone: senderPhone },
                        success: function (response) {
                            const data = JSON.parse(response);

                            if (data.success) {
                                // Construire le contenu HTML pour afficher les colis
                                let tableContent = `
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID Colis</th>
                                                <th>Total (DT)</th>
                                                <th>Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                                data.colis.forEach(colis => {
                                    tableContent += `
                                        <tr>
                                            <td>${colis.request_id}</td>
                                            <td>${parseFloat(colis.total_fee - 8.3 * colis.nbre_paquets).toFixed(2)} DT</td>
                                            <td>${colis.payment_status} </td>

                                        </tr>`;
                                });
                                tableContent += '</tbody></table>';

                                // Afficher les données dans une SweetAlert
                                Swal.fire({
                                    title: `Colis pour l'expéditeur : ${senderPhone}`,
                                    html: tableContent,
                                    icon: 'info',
                                    width: '70%',
                                    confirmButtonText: 'Fermer'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: 'Impossible de récupérer les colis pour cet expéditeur.',
                                    icon: 'error',
                                    confirmButtonText: 'Fermer'
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: 'Erreur',
                                text: 'Une erreur est survenue lors de la récupération des données.',
                                icon: 'error',
                                confirmButtonText: 'Fermer'
                            });
                        }
                    });
                });
            </script>
            <script>
                $(document).on('click', '.print-receipt', function () {
                    const senderPhone = $(this).data('phone');
                    const senderName = $(this).data('name');
                    const totalDue = $(this).data('total');
                    const totalPackages = $(this).data('packages');

                    const receiptContent = `
                        <div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; border: 2px solid #ddd; padding: 20px; border-radius: 10px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <div>
                                    <h2 style="margin: 0; color: #3498db;">Wassaley Delivery</h2>
                                    <p style="margin: 5px 0; font-size: 14px; color: #7f8c8d;">Contact : +216 51 284 062</p>
                                </div>
                                <div>
                                    <img src="assets/images/logo/logo2.png" alt="Logo" style="max-width: 100px;">
                                </div>
                            </div>
                            <div style="text-align: center; border-bottom: 2px solid #ddd; padding-bottom: 10px;">
                                <h2 style="color: #3498db; margin: 0;">Reçu de Paiement</h2>
                                <small style="color: #7f8c8d;">Document officiel</small>
                            </div>
                            <div style="margin-top: 20px; line-height: 1.6;">
                                <p><strong>Nom de l'Expéditeur :</strong> ${senderName}</p>
                                <p><strong>Téléphone de l'Expéditeur :</strong> ${senderPhone}</p>
                                <p><strong>Total Colis Livrés :</strong> ${totalPackages}</p>
                                <p><strong>Montant Total Dû :</strong> <span style="color: #e74c3c;">${totalDue} DT</span></p>
                                <p><strong>Date :</strong> ${new Date().toLocaleDateString()}</p>
                            </div>
                            <div style="margin-top: 30px; text-align: center; color: #2c3e50;">
                                <p style="font-style: italic;">Ce reçu atteste que l'argent dû a été remis à l'expéditeur.</p>
                                <p style="margin-top: 10px; font-size: 14px; color: #95a5a6;">Merci d'avoir utilisé notre service.</p>
                            </div>
                        </div>
                    `;

                    const printWindow = window.open('', '_blank', 'width=800,height=600');
                    printWindow.document.open();
                    printWindow.document.write(`
                        <html>
                        <head>
                            <title>Reçu de Paiement</title>
                            <style>
                                body {
                                    font-family: Arial, sans-serif; 
                                    margin: 0; 
                                    padding: 0; 
                                    background-color: #f9f9f9; 
                                    color: #2c3e50;
                                }
                                .receipt-container {
                                    max-width: 600px; 
                                    margin: 50px auto; 
                                    background: #fff; 
                                    border: 2px solid #ddd; 
                                    border-radius: 10px; 
                                    padding: 20px;
                                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                                }
                            </style>
                        </head>
                        <body onload="window.print(); window.close();">
                            ${receiptContent}
                        </body>
                        </html>
                    `);
                    printWindow.document.close();
                });
            </script>
            <?php include 'pages/footer.php'; ?>


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
    // Initialiser le premier tableau
    if (!$.fn.DataTable.isDataTable('#datatable1')) {
        $('#datatable1').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
            }
        });
    }

    // Initialiser le deuxième tableau
    if (!$.fn.DataTable.isDataTable('#datatable2')) {
        $('#datatable2').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
            }
        });
    }
});

    </script>
</body>
</html>
