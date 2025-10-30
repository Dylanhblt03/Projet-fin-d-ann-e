<?php
// Démarre la session pour accéder aux informations de l'utilisateur connecté.
session_start();

// Sécurité : vérifie si l'utilisateur est bien un client connecté.
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
    // La redirection est commentée, ce qui signifie que pour le moment,
    // on simule un client connecté pour les besoins du développement.
    $_SESSION['user_id'] = 1;
    $_SESSION['user_name'] = 'Client de Démo';
}

include 'includes/db.inc.php';

$client_id = $_SESSION['user_id']; // Récupère l'ID du client depuis la session.

// Récupère les informations du client.
$client_name = $_SESSION['user_name'];

// Récupère tous les devis associés à ce client.
$stmt_devis = $pdo->prepare("SELECT * FROM devis WHERE client_id = ? ORDER BY date_emission DESC");
$stmt_devis->execute([$client_id]);
$devis = $stmt_devis->fetchAll();

// Récupère tous les projets associés à ce client.
$stmt_projets = $pdo->prepare("SELECT * FROM projets WHERE client_id = ? ORDER BY date_debut DESC");
$stmt_projets->execute([$client_id]);
$projets = $stmt_projets->fetchAll();

include 'includes/header.inc.php';
?>
<main class="main-content-wrapper" style="padding: 150px 0; background: var(--grey-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title">Espace Client</h1>
            <p class="section-subtitle">Bienvenue, <?php echo htmlspecialchars($client_name); ?> !</p>
        </div>

        <!-- Section Projets -->
        <div class="mb-5">
            <h2 class="section-title-gold">Mes Projets en cours</h2>
            <!-- Affiche un message si aucun projet n'est trouvé. -->
            <?php if (empty($projets)): ?>
                <p>Vous n'avez aucun projet en cours.</p>
            <?php else: ?>
                <ul class="list-group">
                    <!-- Boucle pour afficher chaque projet. -->
                    <?php foreach ($projets as $projet): ?>
                        <li class="list-group-item">
                            <h5><?php echo htmlspecialchars($projet['titre']); ?></h5>
                            <p>Statut : <span class="badge bg-primary"><?php echo htmlspecialchars($projet['statut']); ?></span></p>
                            <!-- Barre de progression pour suivre l'avancement. -->
                            <div class="progress">
                                <div class="progress-bar bg-gold" role="progressbar" style="width: <?php echo $projet['pourcentage_avancement']; ?>%;" aria-valuenow="<?php echo $projet['pourcentage_avancement']; ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo $projet['pourcentage_avancement']; ?>%
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Section Devis -->
        <div>
            <h2 class="section-title-gold">Mes Devis</h2>
            <?php if (empty($devis)): ?>
                <p>Vous n'avez aucun devis pour le moment.</p>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($devis as $item): ?>
                        <!-- Affiche chaque devis avec son statut. -->
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Devis #<?php echo htmlspecialchars($item['numero_devis']); ?> - <?php echo htmlspecialchars($item['titre']); ?></span>
                            <span class="badge bg-info"><?php echo htmlspecialchars($item['statut']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php include 'includes/footer.inc.php'; ?>