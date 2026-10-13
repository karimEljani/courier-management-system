<?php
include 'server/inc/connection.php'; // Inclure la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $nic = $_POST['nic'];

    $location = $_POST['location'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $phone2 = $_POST['phone2'] ?? '';
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $gender = $_POST['gender'];



    // Insertion dans la base de données
    $sql = "INSERT INTO customer (name,nic, location, address, email, phone, phone2, password, gender) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssssss", $name,$nic, $location, $address, $email, $phone, $phone2, $password, $gender);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
    $con->close();
} else {
    echo "error";
}
?>
