<!DOCTYPE html>
<html lang="fr">

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
                <h3>Liste des employés</h3>
            </div>

            <div class="row">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des employés</li>
                        </ol>
                    </nav>
                </div>
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin') : ?>
                    <div class="col-lg-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EmployeeModal">Ajouter un nouvel employé</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <table id="datatablesSimple" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>NIC</th>
                                    <th>Adresse</th>
                                    <th>Succursale</th>
                                    <th>Genre</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                if ($_SESSION['admin'] != 'admin') {
                                    $getall = getemployeeByEmail($_SESSION['admin']);
                                } else {
                                    $getall = getAllemployee();
                                }

                                while ($row = mysqli_fetch_assoc($getall)) {
                                    $emp_id = $row['emp_id'];
                                ?>
                                    <tr>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['nic']; ?></td>
                                        <td><?php echo $row['address']; ?></td>
                                        <td>
                                            <?php 
                                            $getCat = getBranchByID($row['branch_id']);
                                            if ($row4 = mysqli_fetch_assoc($getCat)) {
                                                echo $row4['branch_name'];
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['gender'] == "1" ? "Homme" : "Femme"; ?>
                                        </td>
                                        <td>
                                            <a href="empolyee_edit.php?emp_id=<?php echo $emp_id; ?>" class="btn btn-darkblue">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin') : ?>
                                                <button type="button" onclick="permenantdeleteData(<?php echo $row['emp_id']; ?>, 'employee', 'emp_id')" class="btn btn-darkblue">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>



            
<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "royal_express_db");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Ajouter une association entre un employé et une zone
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign'])) {
    $employeeId = $_POST['employee_id'];
    $areaId = $_POST['area_id'];

    // Vérifier si l'association existe déjà
    $stmt = $conn->prepare("INSERT INTO employee_areas (employee_id, area_id) VALUES (?, ?) 
                            ON DUPLICATE KEY UPDATE area_id = area_id");
    $stmt->bind_param("ii", $employeeId, $areaId);

    if ($stmt->execute()) {
        $message = "Zone assignée avec succès à l'employé.";
    } else {
        $message = "Erreur : " . $stmt->error;
    }
}

// Récupérer les employés
$employeesQuery = "SELECT emp_id, name FROM employee";
$employeesResult = $conn->query($employeesQuery);

// Récupérer les zones
$areasQuery = "SELECT area_id, area_name FROM area";
$areasResult = $conn->query($areasQuery);

// Récupérer les associations actuelles
$assignmentsQuery = "SELECT ea.id, e.name AS employee_name, a.area_name 
                     FROM employee_areas ea 
                     JOIN employee e ON ea.employee_id = e.emp_id 
                     JOIN area a ON ea.area_id = a.area_id";
$assignmentsResult = $conn->query($assignmentsQuery);
?>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Gestion des zones par employé</title>
<div class="container mt-5">
    <h1 class="text-center">Gestion des zones par employé</h1>

    <!-- Formulaire d'attribution -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h3>Assigner une zone à un employé</h3>
        </div>
        <div class="card-body">
            <?php if (isset($message)) : ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="POST" class="row g-3">
                <div class="col-md-6">
                    <label for="employee_id" class="form-label">Employé</label>
                    <select name="employee_id" id="employee_id" class="form-select" required>
                        <option value="">-- Sélectionner un employé --</option>
                        <?php while ($employee = $employeesResult->fetch_assoc()) : ?>
                            <option value="<?php echo $employee['emp_id']; ?>"><?php echo htmlspecialchars($employee['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="area_id" class="form-label">Zone</label>
                    <select name="area_id" id="area_id" class="form-select" required>
                        <option value="">-- Sélectionner une zone --</option>
                        <?php while ($area = $areasResult->fetch_assoc()) : ?>
                            <option value="<?php echo $area['area_id']; ?>"><?php echo htmlspecialchars($area['area_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" name="assign" class="btn btn-success">Assigner</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des associations actuelles -->
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            <h3>Associations actuelles</h3>
        </div>
        <div class="card-body">
            <?php if ($assignmentsResult->num_rows > 0) : ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employé</th>
                        <th>Zone</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($assignment = $assignmentsResult->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $assignment['id']; ?></td>
                            <td><?php echo htmlspecialchars($assignment['employee_name']); ?></td>
                            <td><?php echo htmlspecialchars($assignment['area_name']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p class="text-center">Aucune association trouvée.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>




            <?php include 'pages/footer.php'; ?>
        </div>
    </div>

    <!-- Modal pour ajouter un employé -->
    <div class="modal fade" id="EmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exampleModalLabel">Ajouter un employé</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" id="basicform" data-parsley-validate="" enctype="multipart/form-data">
                    <div class="modal-body bg-white">
                        <div class="form-group mt-2">
                            <label for="inputName">Nom</label>
                            <input id="inputName" type="text" name="name" data-parsley-trigger="change" required="" placeholder="Entrez le nom complet" autocomplete="off" class="form-control">
                        </div>

                        <div class="form-group mt-2">
                            <label for="inputEmail">Adresse email</label>
                            <input id="inputEmail" type="email" name="email" data-parsley-trigger="change" required="" placeholder="Entrez l'email" autocomplete="off" class="form-control">
                        </div>

                        <div class="form-group mt-2">
                            <label for="inputPhone">Numéro de téléphone</label>
                            <input id="inputPhone" type="text" name="phone" data-parsley-trigger="change" required="" placeholder="Entrez le numéro de téléphone" autocomplete="off" class="form-control">
                        </div>

                        <div class="form-group mt-2">
                            <label for="inputNic">NIC</label>
                            <input id="inputNic" type="text" name="nic" data-parsley-trigger="change" required="" placeholder="Entrez le NIC" autocomplete="off" class="form-control">
                        </div>

                        <div class="form-group mt-2">
                            <label for="inputAddress">Adresse</label>
                            <input id="inputAddress" type="text" name="address" data-parsley-trigger="change" required="" placeholder="Entrez l'adresse" autocomplete="off" class="form-control">
                        </div>

                        <div class="form-group mt-2">
                            <label for="inputBranch">Succursale</label>
                            <select name="branch_id" id="inputBranch" class="form-control">
                                <?php 
                                $getBranch = getAllBranches();
                                while ($branch = mysqli_fetch_assoc($getBranch)) {
                                    echo "<option value='".$branch['branch_id']."'>".$branch['branch_name']."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label for="inputGender">Genre</label>
                            <select name="gender" id="inputGender" class="form-control">
                                <option value="1">Homme</option>
                                <option value="2">Femme</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="submit" class="btn btn-primary">Ajouter l'employé</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>







