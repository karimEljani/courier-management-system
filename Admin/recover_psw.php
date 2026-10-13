<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération du mot de passe</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #000000, #002ba5);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1.2s ease-in-out;
        }
        .glass-card-header {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #ffffff;
            text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.4);
        }
        .form-control {
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 1rem;
            height: 50px;
            padding-left: 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: rgba(0, 150, 255, 0.8);
            box-shadow: 0 0 5px rgba(0, 150, 255, 0.5);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(90deg, #1e0bbf, #cf2ed1);
            border: none;
            height: 50px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #00f2fe, #4facfe);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .card-footer {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }
        .card-footer a {
            text-decoration: none;
            color: #00f2fe;
        }
        .card-footer a:hover {
            color: #4facfe;
        }
        .logo {
            display: block;
            margin: 0 auto;
            width: 160px;
            height: 120px;
        }
        .site-name {
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            color: #ffffff;
            margin-top: 10px;
            text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.4);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="glass-card">
        <!-- Logo et nom du site -->
        <img src="assets/images/logo/logo2.png" alt="Site Logo" class="logo">

        <!-- En-tête -->
        <div class="glass-card-header">
            Récupération du mot de passe
        </div>

        <!-- Formulaire -->
        <form action="#" method="POST" name="recover_psw">
            <div class="mb-4">
                <label for="email_address" class="form-label text-white">Adresse e-mail</label>
                <input type="email" id="email_address" class="form-control" name="email" placeholder="Entrez votre e-mail" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary" name="recover">Récupérer</button>
            </div>
        </form>

        <!-- Pied de page -->
        <div class="card-footer text-center mt-4">
            <p>Retourner à la <a href="login.php">page de connexion</a></p>
        </div>
    </div>
    
    
</body>
</html>

<?php
include('../server/inc/connection.php');

if (isset($_POST["recover"])) {
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $sql = mysqli_query($con, "SELECT * FROM customer WHERE email='$email'");
    $fetch = mysqli_fetch_assoc($sql);

    if (mysqli_num_rows($sql) <= 0) {
        echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'E-mail non trouvé',
                    text: 'Désolé, cet e-mail n\'existe pas.',
                    confirmButtonText: 'OK'
                });
            </script>
        ";
    } else if ($fetch['status'] == 0) {
        echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Compte non vérifié',
                    text: 'Votre compte doit être vérifié avant de récupérer votre mot de passe.',
                    confirmButtonText: 'OK'
                });
            </script>
        ";
    }
     else {
        $verificationCode = rand(100000, 999999); // Génère un code à 6 chiffres
        $_SESSION['verification_code'] = $verificationCode;
        $_SESSION['email'] = $email;

        // Envoyer l'e-mail
        require "Mail/phpmailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'karimsuslu@gmail.com';
        $mail->Password = 'lfpj rycl qhzz fxdl';

        $mail->setFrom('karimsuslu@gmail.com', 'WassaleyDelivery');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Code de vérification pour réinitialiser votre mot de passe";
        $mail->CharSet = 'UTF-8';
        $mail->Body = "
            <p>Bonjour,</p>
            <p>Voici votre code de vérification pour réinitialiser votre mot de passe :</p>
            <h1>$verificationCode</h1>
            <p>Si vous n'avez pas demandé cette action, ignorez cet e-mail.</p>
            <p>Cordialement,</p>
            <p>L'équipe WassaleyDelivery</p>
        ";

        if ($mail->send()) {
            echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Code envoyé !',
                        text: 'Un code de vérification a été envoyé à votre e-mail.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.replace('verify_code.php');
                    });
                </script>
            ";
        } else {
            echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Impossible d\'envoyer l\'e-mail. Veuillez réessayer plus tard.',
                        confirmButtonText: 'OK'
                    });
                </script>
            ";
        }
        
    }
}
?>

