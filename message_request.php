<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'adhésion reçue</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
        }
        .message-container {
            text-align: center;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }
        .message-container i {
            font-size: 50px;
            color: #4caf50;
            margin-bottom: 20px;
        }
        .message-container h2 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .message-container p {
            color: #666666;
            font-size: 16px;
            margin-bottom: 30px;
        }
        .back-link {
            color: #4caf50;
            font-size: 16px;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <i class="fas fa-check-circle"></i>
        <h2>Merci!</h2>
        <p>Nous traiterons votre demande d'adhésion dans les plus brefs délais.</p>
        <a href="index.php" class="back-link">Retourner à l'accueil</a>
    </div>
</body>
</html>
