<?php



$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['email']) && !empty($data['email'])) {
    $email = $data['email'];

    $conn = new mysqli("localhost", "root", "", "royal_express_db");
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row['password'];

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'karimsuslu@gmail.com'; // Remplacez par votre e-mail
            $mail->Password = 'lfpj rycl qhzz fxdl'; // Remplacez par votre mot de passe d'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('karimsuslu@gmail.com', 'WassaleyDelivery');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Récupération de mot de passe';
            $mail->Body = "<p>Bonjour,</p><p>Voici votre mot de passe : <strong>$password</strong></p><p>Veuillez le conserver en lieu sûr.</p>";

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Un e-mail contenant votre mot de passe a été envoyé.']);
        } catch (Exception $e) {
            error_log("Erreur PHPMailer: " . $mail->ErrorInfo);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi de l\'e-mail.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Cet e-mail n\'existe pas dans notre base de données.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Adresse e-mail invalide.']);
}
