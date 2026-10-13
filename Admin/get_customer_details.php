<?php
include '../server/inc/connection.php'; // Connexion à la base de données

if (isset($_GET['customer_id'])) {
    $customer_id = intval($_GET['customer_id']);

    // Récupérer les informations du client
    $sql = "SELECT * FROM customer WHERE customer_id = $customer_id";
    $result = mysqli_query($con, $sql);
    $customer = mysqli_fetch_assoc($result);

    if ($customer) {
        echo "<h5>Nom : {$customer['name']}</h5>";
        echo "<p>Email : {$customer['email']}</p>";
        echo "<p>Téléphone : {$customer['phone']}</p>";
        echo "<p>Adresse : {$customer['address']}</p>";
        echo "<p>Genre : " . ($customer['gender'] == "1" ? "Homme" : "Femme") . "</p>";
        echo "<hr>";

        // Récupérer les colis du client
        $colis_sql = "SELECT * FROM request WHERE customer_id = $customer_id";
        $colis_result = mysqli_query($con, $colis_sql);

        echo "<h6>Colis :</h6>";
        while ($colis = mysqli_fetch_assoc($colis_result)) {
            // Définir le texte pour le statut du colis
            switch ($colis['tracking_status']) {
                case 1:
                    $statusText = "En attente";
                    break;
                case 2:
                    $statusText = "Préparation";
                    break;
                case 3:
                    $statusText = "Expédié";
                    break;
                case 4:
                    $statusText = "Livré";
                    break;
                case 5:
                    $statusText = "Annulé";
                    break;
                default:
                    $statusText = "Statut inconnu";
            }

            echo "<p>Colis ID : {$colis['request_id']} - Statut : $statusText</p>";
        }
    } else {
        echo "<p>Aucun détail trouvé pour ce client.</p>";
    }
}
?>
