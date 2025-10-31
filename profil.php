<?php
// Démarre la session pour accéder aux informations de l'utilisateur connecté.
session_start();

// Sécurité : vérifie si l'utilisateur est bien un client connecté.
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié comme client.
    header('Location: login.php');
    exit;
}

include 'includes/db.inc.php';

$client_id = $_SESSION['user_id']; // Récupère l'ID du client depuis la session.

// Récupère les informations complètes du client.
$stmt_client = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
$stmt_client->execute([$client_id]);
$client = $stmt_client->fetch();
$client_name = $client['prenom'] ?? 'Client';

// Récupère tous les devis associés à ce client.
$stmt_devis = $pdo->prepare("SELECT * FROM devis WHERE client_id = ? ORDER BY date_emission DESC");
$stmt_devis->execute([$client_id]);
$devis = $stmt_devis->fetchAll();

// Récupère tous les projets associés à ce client.
$stmt_projets = $pdo->prepare("SELECT * FROM projets WHERE client_id = ? ORDER BY date_debut DESC");
$stmt_projets->execute([$client_id]);
$projets = $stmt_projets->fetchAll();

// Récupère toutes les factures associées à ce client.
$stmt_factures = $pdo->prepare("SELECT * FROM factures WHERE client_id = ? ORDER BY date_emission DESC");
$stmt_factures->execute([$client_id]);
$factures = $stmt_factures->fetchAll();

// Récupère tous les rendez-vous associés à ce client.
$stmt_rdv = $pdo->prepare("SELECT *, CONCAT(date_rdv, ' ', heure_debut) as datetime_rdv FROM rendez_vous WHERE client_id = ? ORDER BY datetime_rdv DESC");
$stmt_rdv->execute([$client_id]);
$rendez_vous = $stmt_rdv->fetchAll();

include 'includes/header.inc.php';
?>
<main class="main-content-wrapper" style="padding: 150px 0; background: var(--grey-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title">Espace Client</h1>
            <p class="section-subtitle">Bienvenue, <?php echo htmlspecialchars($client_name); ?> !</p>
        </div>

        <!-- Système d'onglets pour une meilleure organisation -->
        <ul class="nav nav-tabs justify-content-center mb-4" id="profilTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="projets-tab" data-bs-toggle="tab" data-bs-target="#projets" type="button" role="tab">Mes Projets</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="devis-tab" data-bs-toggle="tab" data-bs-target="#devis" type="button" role="tab">Mes Devis</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="factures-tab" data-bs-toggle="tab" data-bs-target="#factures" type="button" role="tab">Mes Factures</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rdv-tab" data-bs-toggle="tab" data-bs-target="#rdv" type="button" role="tab">Mes Rendez-vous</button>
            </li>
        </ul>

        <div class="tab-content" id="profilTabContent">
            <!-- Onglet Projets -->
            <div class="tab-pane fade show active" id="projets" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h2 class="h5 mb-0">Mes Projets en cours</h2></div>
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="nouveau_projet.php" class="btn btn-gold"><i class="fas fa-plus me-2"></i>Démarrer un nouveau projet</a>
                        </div>
                        <?php if (empty($projets)): ?>
                            <p class="text-center text-muted">Vous n'avez aucun projet en cours.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($projets as $projet): ?>
                                    <li class="list-group-item">
                                        <h5><?php echo htmlspecialchars($projet['titre']); ?></h5>
                                        <p class="mb-2">Statut : <span class="badge bg-primary"><?php echo htmlspecialchars(ucfirst($projet['statut'])); ?></span></p>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-gold" role="progressbar" style="width: <?php echo $projet['pourcentage_avancement']; ?>%;" aria-valuenow="<?php echo $projet['pourcentage_avancement']; ?>" aria-valuemin="0" aria-valuemax="100">
                                                <?php echo $projet['pourcentage_avancement']; ?>%
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Onglet Devis -->
            <div class="tab-pane fade" id="devis" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h2 class="h5 mb-0">Mes Devis</h2></div>
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="estimation.php" class="btn btn-gold" role="link">
                                <i class="fas fa-calculator me-2"></i>Obtenir une estimation (Devis factice)
                            </a>
                        </div>

                        <?php if (empty($devis)): ?>
                            <p class="text-center text-muted">Vous n'avez aucun devis pour le moment.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($devis as $item): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Devis #<?php echo htmlspecialchars($item['numero_devis']); ?></strong> - <?php echo htmlspecialchars($item['titre']); ?><br>
                                            <small class="text-muted">Émis le <?php echo (new DateTime($item['date_emission']))->format('d/m/Y'); ?> - Montant : <?php echo number_format($item['montant_ttc'], 2, ',', ' '); ?> €</small>
                                        </div>
                                        <span class="badge bg-info text-dark"><?php echo htmlspecialchars(ucfirst($item['statut'])); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Onglet Factures -->
            <div class="tab-pane fade" id="factures" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h2 class="h5 mb-0">Mes Factures</h2></div>
                    <div class="card-body">
                        <?php if (empty($factures)): ?>
                            <p class="text-center text-muted">Vous n'avez aucune facture pour le moment.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($factures as $facture):
                                    $statut_class = 'bg-secondary';
                                    if ($facture['statut'] == 'payee') $statut_class = 'bg-success';
                                    if ($facture['statut'] == 'en_attente') $statut_class = 'bg-warning text-dark';
                                    if ($facture['statut'] == 'en_retard') $statut_class = 'bg-danger';
                                ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Facture #<?php echo htmlspecialchars($facture['numero_facture']); ?></strong> - <?php echo htmlspecialchars($facture['titre']); ?><br>
                                            <small class="text-muted">Émise le <?php echo (new DateTime($facture['date_emission']))->format('d/m/Y'); ?> - Montant : <?php echo number_format($facture['montant_ttc'], 2, ',', ' '); ?> €</small>
                                        </div>
                                        <span class="badge <?php echo $statut_class; ?>"><?php echo htmlspecialchars(ucfirst($facture['statut'])); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Onglet Rendez-vous -->
            <div class="tab-pane fade" id="rdv" role="tabpanel">
                <div class="card">
                    <div class="card-header"><h2 class="h5 mb-0">Mes Rendez-vous</h2></div>
                    <div class="card-body">
                        <?php if (empty($rendez_vous)): ?>
                            <p class="text-center text-muted">Vous n'avez aucun rendez-vous planifié.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($rendez_vous as $rdv):
                                    $date_rdv = new DateTime($rdv['datetime_rdv']);
                                    $is_past = $date_rdv < new DateTime();
                                    $statut_class = 'bg-secondary';
                                    if ($rdv['statut'] == 'confirme' && !$is_past) $statut_class = 'bg-primary';
                                    if ($rdv['statut'] == 'termine' || ($rdv['statut'] == 'confirme' && $is_past)) $statut_class = 'bg-light text-dark';
                                    if ($rdv['statut'] == 'annule') $statut_class = 'bg-danger';
                                ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center <?php if($is_past) echo 'text-muted'; ?>">
                                        <div>
                                            <strong><?php echo htmlspecialchars($rdv['titre']); ?></strong><br>
                                            <small><i class="fas fa-calendar-alt me-1"></i> <?php echo $date_rdv->format('d/m/Y à H:i'); ?></small>
                                        </div>
                                        <span class="badge <?php echo $statut_class; ?>">
                                            <?php 
                                                if ($rdv['statut'] == 'confirme' && $is_past) {
                                                    echo 'Terminé';
                                                } else {
                                                    echo htmlspecialchars(ucfirst($rdv['statut']));
                                                }
                                            ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<?php include 'includes/footer.inc.php'; ?>