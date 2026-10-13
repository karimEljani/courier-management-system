<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: recover_psw.php');
    exit();
}

if (isset($_POST['verify_code'])) {
    $userCode = $_POST['verification_code'];

    if ($userCode == $_SESSION['verification_code']) {
        unset($_SESSION['verification_code']); // Supprime le code après validation
        header('Location: reset_psw.php'); // Redirige vers la page de réinitialisation
        exit();
    } else {
        $error = "Le code de vérification est incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1s ease-in-out;
            text-align: center;
        }
        .glass-card img {
            max-width: 120px;
            margin-bottom: 20px;
        }
        .glass-card-header {
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
            text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
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
            box-shadow: 0 0 10px rgba(0, 150, 255, 0.5);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(90deg, #4facfe, #00f2fe);
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
        .alert {
            background: rgba(255, 0, 0, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 0, 0, 0.3);
            border-radius: 10px;
            padding: 10px;
            font-size: 0.9rem;
        }
        .card-footer a {
            text-decoration: none;
            color: #00f2fe;
        }
        .card-footer a:hover {
            color: #4facfe;
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
        <!-- Logo du site -->
        <img src="assets/images/logo/logo2.png" alt="Logo du site">
        
        <!-- En-tête -->
        <div class="glass-card-header">
            Vérification du code
        </div>

        <!-- Message d'erreur si nécessaire -->
        <?php if (isset($error)) { ?>
            <div class="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <!-- Formulaire -->
        <form method="POST">
            <div class="mb-4">
                <label for="verification_code" class="form-label text-white">Code de vérification</label>
                <input type="text" id="verification_code" name="verification_code" class="form-control" placeholder="Entrez le code reçu par e-mail" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="verify_code" class="btn btn-primary">Vérifier</button>
            </div>
        </form>

        <!-- Lien pour renvoyer le code -->
        <div class="card-footer mt-4">
            <a href="recover_psw.php">Renvoyer le code</a>
        </div>
    </div>
</body>
</html>
