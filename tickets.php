<?php
include 'pages/head.php';
include 'server/inc/connection.php'; // Connexion à la base de données
include 'auth.php'; // Vérifie l'authentification

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'identifiant et le nom du client connecté
$customerId = $_SESSION['customer'];
$query = "SELECT name FROM customer WHERE customer_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
$customerName = $customer['name'] ?? 'Client';

// Récupérer les colis disponibles
$requestsQuery = "
    SELECT request_id, tracking_status
    FROM request
    WHERE customer_id = ? AND is_deleted = 0
";
$requestStmt = $con->prepare($requestsQuery);
$requestStmt->bind_param("i", $customerId);
$requestStmt->execute();
$requests = $requestStmt->get_result();
?>
<?php
include 'server/inc/connection.php'; // Inclure la connexion à la base de données

// Vérifier si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $date = $_POST['date'] ?? null;
    $description = $_POST['description'] ?? null;
    $category = $_POST['category'] ?? null;

    // Valider les données
    if ($request_id && $name && $date && $description && $category) {
        // Insérer le ticket dans la base de données
        $query = "INSERT INTO tickets (request_id, customer_id, name, date, description, category, status) 
                  VALUES (?, ?, ?, ?, ?, ?, 'Ouvert')";
        
        // Remplacer `customer_id` par l'ID de l'utilisateur connecté
        $stmt = $con->prepare($query);
        $stmt->bind_param("iissss", $request_id, $_SESSION['customer'], $name, $date, $description, $category);

        if ($stmt->execute()) {
            echo 'success'; // Succès
        } else {
            echo 'error'; // Erreur SQL
        }
        $stmt->close();
    } else {
        echo 'error'; // Données invalides
    }
} else {
    echo 'error'; // Mauvaise méthode HTTP
}

$con->close();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
<?php include 'pages/navbar.php'; ?>

<div class="container mt-5">
<h3><a href="tickets_resolus.php">Tickets Résolus</a></h3>

    <h1 class="text-center">Créer un Ticket</h1>
    <p class="text-center">Soumettez une demande ou signalez un problème pour un colis.</p>

    <form id="ticketForm" class="mt-4">
        <div class="row mb-3">
            <label for="request_id" class="col-sm-2 col-form-label">ID du Colis</label>
            <div class="col-sm-10">
                <select name="request_id" id="request_id" class="form-select" required>
                    <option value="">-- Sélectionnez un colis --</option>
                    <?php
                    // Tableau d'équivalence pour les statuts
                    $trackingStatusMap = [
                        1 => 'En attente',
                        2 => 'En cours de traitement',
                        3 => 'En transit',
                        4 => 'Livré',
                        5 => 'Annulé',
                    ];

                    while ($request = $requests->fetch_assoc()): 
                        $statusText = $trackingStatusMap[$request['tracking_status']] ?? 'Statut inconnu'; // Récupérer le statut en lettres
                    ?>
                        <option value="<?php echo $request['request_id']; ?>">
                            #<?php echo $request['request_id']; ?> - Statut: <?php echo $statusText; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Nom</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($customerName); ?>" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label for="date" class="col-sm-2 col-form-label">Date</label>
            <div class="col-sm-10">
                <input type="text" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea name="description" id="description" rows="4" class="form-control" placeholder="Décrivez votre demande ou problème..." required></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <label for="category" class="col-sm-2 col-form-label">Catégorie</label>
            <div class="col-sm-10">
                <select name="category" id="category" class="form-select" required>
                    <option value="">-- Sélectionnez une catégorie --</option>
                    <option value="Colis à annuler">Colis à annuler</option>
                    <option value="Colis à reporter">Colis à reporter</option>
                    <option value="Colis perdu">Colis perdu</option>
                    <option value="Colis en retard">Colis en retard</option>
                    <option value="Colis non payé">Colis non payé</option>
                    <option value="Colis non retourné">Colis non retourné</option>
                    <option value="Statut colis incorrect">Statut colis incorrect</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
    document.getElementById('ticketForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('tickets.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Ticket soumis!',
                text: 'Votre ticket a été soumis avec succès.',
                showConfirmButton: false,
                timer: 2000
            });
            document.getElementById('ticketForm').reset();
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur!',
                text: 'Une erreur est survenue lors de la soumission du ticket.',
                showConfirmButton: true,
            });
        });
    });
</script>

<?php include 'pages/footer.php'; ?>
</body>

</html>
