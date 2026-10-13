<?php 
session_start();
include('../server/inc/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
            backdrop-filter: blur(20px);
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.8s ease-in-out;
        }
        .glass-card img {
            max-width: 120px;
            margin-bottom: 20px;
            animation: slideIn 1s ease-in-out;
        }
        .glass-card-header {
            text-align: center;
            color: #ffffff;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            height: 50px;
            font-size: 1rem;
            padding-left: 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(0, 150, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 150, 255, 0.5);
        }
        .btn-primary {
            background: linear-gradient(90deg, #4facfe, #00f2fe);
            border: none;
            font-size: 1.2rem;
            font-weight: bold;
            height: 50px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #00f2fe, #4facfe);
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        .bi-eye-slash, .bi-eye {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ffffff;
        }
        .card-footer a {
            color: #00f2fe;
            text-decoration: none;
        }
        .card-footer a:hover {
            color: #4facfe;
            text-decoration: underline;
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
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
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
    <div class="text-center">
        <img src="assets/images/logo/logo2.png" alt="Logo du site">
    </div>

    <!-- Titre principal -->
    <div class="glass-card-header">
        Réinitialiser votre mot de passe
    </div>

    <!-- Formulaire -->
    <form action="#" method="POST" name="login">
        <div class="mb-4 position-relative">
            <label for="password" class="form-label text-white">Nouveau mot de passe</label>
            <input type="password" id="password" class="form-control" name="password" placeholder="Entrez votre nouveau mot de passe" required>
            <i class="bi bi-eye-slash" id="togglePassword"></i>
        </div>
        <div class="d-grid">
            <button type="submit" name="reset" class="btn btn-primary">Réinitialiser</button>
        </div>
    </form>

    <!-- Lien pour retourner -->
    <div class="card-footer mt-4 text-center">
        <p class="mb-0 text-white">Retourner à <a href="login.php">la page de connexion</a></p>
    </div>
</div>

<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>

<?php
if (isset($_POST["reset"])) {
    include('../server/inc/connection.php');
    $psw = $_POST["password"];

    $token = $_SESSION['token'];
    $Email = $_SESSION['email'];

    $hash = password_hash($psw, PASSWORD_DEFAULT);

    $sql = mysqli_query($con, "SELECT * FROM customer WHERE email='$Email'");
    $fetch = mysqli_fetch_assoc($sql);

    if ($Email) {
        $new_pass = $hash;
        mysqli_query($con, "UPDATE customer SET password='$new_pass' WHERE email='$Email'");
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'Succès!',
                text: 'Votre mot de passe a été réinitialisé avec succès !',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.replace("login.php");
            });
        </script>
        <?php
    } else {
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'Erreur!',
                text: 'Une erreur est survenue. Veuillez réessayer.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        <?php
    }
    
}
?>

<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function () {
        // Toggle password visibility
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle icon class
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>
