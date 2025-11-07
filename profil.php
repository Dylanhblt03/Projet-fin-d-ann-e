<?php
// 1. Démarrer la session pour accéder aux informations de l'utilisateur.
// C'est redondant si header.inc.php le fait déjà, mais c'est une bonne pratique de sécurité.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. Sécurité : vérifier si l'utilisateur est connecté.
// Si 'user_id' n'est pas dans la session, on le redirige vers la page de connexion.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit; // Arrête l'exécution du script.
}

// 3. Inclure l'en-tête de la page.
include 'includes/header.inc.php';
?>

<main class="main-content-wrapper" style="padding: 150px 0; background: var(--grey-light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h1 class="h3 mb-0">Mon Profil</h1>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <!-- Affiche un message de bienvenue personnalisé -->
                            <h2 class="h4">Bonjour, <?php echo htmlspecialchars($_SESSION['user_name']); ?> !</h2>
                            <p class="text-muted">Bienvenue dans votre espace personnel.</p>
                        </div>

                        <div class="list-group">
                            <a href="prendrerdv.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-calendar-plus me-2 text-gold"></i>Prendre un nouveau rendez-vous
                            </a>
                            <a href="estimation.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-calculator me-2 text-gold"></i>Obtenir une estimation
                            </a>
                        </div>

                        <div class="text-center mt-5">
                            <!-- Bouton de déconnexion qui redirige vers le script logout.php -->
                            <a href="logout.php" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// 4. Inclure le pied de page.
include 'includes/footer.inc.php';
?>