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

// Récupérer l'ID du client
$customerId = $_SESSION['customer'];

// Récupérer les tickets résolus
$query = "
    SELECT t.ticket_id, t.request_id, t.date, t.description, t.category, t.status
    FROM tickets t
    WHERE t.customer_id = ? AND t.status = 'Résolu'
    ORDER BY t.date DESC
";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets Résolus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<?php include 'pages/navbar.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Tickets Résolus</h1>
    <p class="text-center">Voici la liste de vos tickets résolus.</p>

    <table class="table table-striped table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID Ticket</th>
                <th>ID Colis</th>
                <th>Date</th>
                <th>Description</th>
                <th>Catégorie</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($ticket = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $ticket['ticket_id']; ?></td>
                        <td>#<?php echo $ticket['request_id']; ?></td>
                        <td><?php echo $ticket['date']; ?></td>
                        <td><?php echo htmlspecialchars($ticket['description']); ?></td>
                        <td><?php echo htmlspecialchars($ticket['category']); ?></td>
                        <td>
                            <span class="badge bg-success"><?php echo htmlspecialchars($ticket['status']); ?></span>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Aucun ticket résolu trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'pages/footer.php'; ?>
</body>

</html>
