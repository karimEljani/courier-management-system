<?php
include 'server/inc/connection.php'; // Connexion à la base de données

header('Content-Type: application/json'); // Définir le type de contenu JSON

$query = "SELECT area_id, area_name FROM area"; // Remplacez 'areas' par le nom correct de votre table
$result = $con->query($query);

$areas = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $areas[] = $row;
    }
    echo json_encode($areas); // Retourner les résultats en JSON
} else {
    echo json_encode([]); // Retourner un tableau vide si aucune zone
}

$con->close();
?>
