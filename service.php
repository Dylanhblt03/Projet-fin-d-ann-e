<?php

// 1. Inclure la connexion à la base de données.
include 'includes/db.inc.php';

// 2. Récupérer tous les services marqués comme "actifs" pour les afficher.
$stmt = $pdo->query("SELECT * FROM services WHERE actif = 1 ORDER BY ordre_affichage");
$services = $stmt->fetchAll();

// 3. Inclure l'en-tête de la page.
include 'includes/header.inc.php';
?>
    <main>
        <!-- Section d'en-tête de la page des services -->
        <section class="services-hero-section section-padding" style="background-color: var(--grey-dark); padding-top: 150px;">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center" data-aos="fade-up">
                        <h1 class="display-3 text-white mb-3">Nos Services d'Excellence</h1>
                        <p class="lead text-white-50">Découvrez comment nous pouvons transformer votre présence en ligne, du concept à la réalisation.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section listant chaque service -->
        <section class="services-list-section section-padding">
            <div class="container">
                <!-- Boucle pour afficher chaque service récupéré de la BDD. -->
                <?php foreach ($services as $index => $service): ?>
                    <?php
                        // Logique pour alterner l'alignement de l'image (gauche/droite) pour un design plus dynamique.
                        $fade_direction = ($index % 2 == 0) ? 'fade-right' : 'fade-left';
                        $row_reverse_class = ($index % 2 == 0) ? '' : 'flex-md-row-reverse';
                    ?>
                    <div class="row mb-5 align-items-center mt-5 <?php echo $row_reverse_class; ?>" data-aos="<?php echo $fade_direction; ?>">
                        <div class="col-md-6">
                            <h2 class="section-title-gold"><?php echo htmlspecialchars($service['nom']); ?></h2>
                            <p class="text-secondary"><?php echo htmlspecialchars($service['description']); ?></p>
                            <?php if ($service['prix_min']): ?>
                                <!-- Affiche le prix de départ s'il est défini. -->
                                <p class="text-gold mt-3">
                                    À partir de <strong><?php echo number_format($service['prix_min'], 0, ',', ' '); ?>€</strong>
                                </p>
                            <?php endif; ?>
                            <!-- Le bouton "Demander un devis" pré-remplit le service sur la page de contact. -->
                            <a href="contact.php?service=<?php echo urlencode($service['nom']); ?>" class="btn btn-gold btn-lg me-3">Demander un devis</a>
                        </div>
                        <div class="col-md-6 mt-4 mt-md-0 text-center">
                            <!-- Affiche l'icône associée au service. -->
                            <i class="fas <?php echo htmlspecialchars($service['icone']); ?> fa-5x text-gold"></i>
                        </div>
                    </div>
                    <!-- Ajoute une ligne de séparation entre chaque service, sauf le dernier. -->
                    <?php if ($index < count($services) - 1): ?>
                        <hr class="my-5 border-gold">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

 <?php
// Inclure le pied de page.
include 'includes/footer.inc.php';
?>