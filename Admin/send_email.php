<?php

if (isset($_POST['requestId'])) {
    $requestId = $_POST['requestId'];

    // Connexion à la base de données
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "royal_express_db";
    $con = new mysqli($host, $user, $password, $db);

    if ($con->connect_error) {
        die("Erreur de connexion : " . $con->connect_error);
    }

    // Récupérer les informations du client
    $sql = "SELECT email, name FROM customer WHERE customer_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if ($customer) {
        // Générer un mot de passe temporaire
        $tempPassword = bin2hex(random_bytes(4)); // 8 caractères aléatoires
        $hashedPassword = password_hash($tempPassword, PASSWORD_BCRYPT);

        // Mettre à jour le mot de passe temporaire dans la base de données
        $updateQuery = "UPDATE customer SET password = ? WHERE customer_id = ?";
        $updateStmt = $con->prepare($updateQuery);
        $updateStmt->bind_param("si", $hashedPassword, $requestId);
        $updateStmt->execute();

        require 'Mail/phpmailer/PHPMailerAutoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'karimsuslu@gmail.com';
            $mail->Password = 'lfpj rycl qhzz fxdl';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('karimsuslu@gmail.com', 'WassaleyDelivery');
            $mail->addAddress($customer['email']);
            $mail->isHTML(true);
            $mail->Subject = 'Votre demande a été acceptée';
            $mail->CharSet = 'UTF-8';

            // Envoyer le mot de passe temporaire dans l'email
            $mail->Body = "<b>Bonjour " . htmlspecialchars($customer['name']) . ",</b>
            <p>Votre demande de création de compte a été acceptée.</p>
            <p>Voici vos informations de connexion :</p>
            <p><strong>Email :</strong> " . htmlspecialchars($customer['email']) . "</p>
            <p><strong>Mot de passe :</strong> " . htmlspecialchars($tempPassword) . "</p>
            <p>Merci de faire confiance à WassaleyDelivery.</p>";

            // Envoyer l'email
            if ($mail->send()) {
                // Mettre à jour la colonne email_sent à 1
                $updateEmailSent = "UPDATE customer SET email_sent = 1 WHERE customer_id = ?";
                $updateEmailStmt = $con->prepare($updateEmailSent);
                $updateEmailStmt->bind_param("i", $requestId);
                $updateEmailStmt->execute();
                echo 'success'; // Succès
            } else {
                echo 'Erreur lors de l\'envoi de l\'email.';
            }
        } catch (Exception $e) {
            echo 'Erreur lors de l\'envoi de l\'email : ' . $mail->ErrorInfo;
        }
    } else {
        echo 'Erreur : Aucun client trouvé.';
    }

    $stmt->close();
    $con->close();
}

?>
