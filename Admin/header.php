<!-- header.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <!-- Logo et Titre -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="bi bi-boxes me-2"></i> <!-- Icône de boîte pour le logo -->
            <h4 class="text-white mb-0">WassaleyDelivery</h4>
        </a>

        <!-- Toggle pour les petits écrans -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Horloge en temps réel -->
                <li class="nav-item me-3">
                    <span id="current-time" class="text-white"></span>
                </li>

                <!-- Icône de message -->
                <li class="nav-item position-relative">
                    <a href="message.php" class="nav-link text-white">
                        <i class="bi bi-chat-left-text-fill fs-4"></i>
                        <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">3</span>
                    </a>
                </li>

                <!-- Icône du compte client -->
                <li class="nav-item">
                    <a href="settings.php" class="nav-link text-white">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                </li>

                <!-- Icône de déconnexion -->
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-white">
                        <i class="bi bi-box-arrow-right fs-4"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Script JavaScript pour mettre à jour l'heure et la date -->
<script>
    function updateClock() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const day = now.getDate().toString().padStart(2, '0');
        const month = (now.getMonth() + 1).toString().padStart(2, '0'); // Les mois sont 0-indexés
        const year = now.getFullYear();

        // Format de l'horloge
        const timeString = `${hours}:${minutes}:${seconds} ${day}/${month}/${year}`;
        document.getElementById('current-time').textContent = timeString;
    }

    // Met à jour l'horloge toutes les secondes
    setInterval(updateClock, 1000);
    // Initialisation au chargement
    updateClock();
</script>

<!-- Ajoutez Bootstrap JS (si non déjà inclus dans le fichier principal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
