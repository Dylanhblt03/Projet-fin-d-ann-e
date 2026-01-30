<?php
include __DIR__ . '/includes/db.inc.php';
$services = getServicesRand($conn);
$portfolio_items = getPortfolioSelection($conn);
$projets_realises = getProjetsCount($conn);
$clients_satisfaits = getClientsSatisfaitsCount($conn);

include __DIR__ . '/includes/header.inc.php';
?>

<main class="main-content-wrapper">

    <section class="hero-section" id="accueil">
        <div class="hero-pattern"></div>
        <div class="hero-gradient"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="hero-content">
                        <span class="hero-label d-flex justify-content-center">Agence Web Créative & Stratégique</span>
                        <h1 class="hero-title">
                            Façonner votre <br>
                            <span class="gold-text">identité digitale</span> <br>
                            par l'excellence
                        </h1>
                        <p class="hero-subtitle">
                            Architecture web sur-mesure, design immersif et photographie haute définition. Nous concevons des outils numériques performants qui propulsent votre image de marque.
                        </p>
                        <a href="#services" class="btn btn-gold btn-lg me-3">Découvrir</a>
                        <a href="pages/contact.php" class="btn btn-outline-gold btn-lg">Me contacter</a>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1" data-aos="fade-left">
                    <div class="hero-logo">
                        <div class="hero-logo-box">
                            <img src="/images/oleris.jpg" alt="Logo Oléris" class="hero-logo-img-fill img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services-section" id="services">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-label" data-aos="fade-up">Nos Expertises</span>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5" data-aos="fade-right">
                    <h3 class="h1 fw-bold mb-4">
                        <span class="display-5 fw-bold">Découvrez</span> <span class="text-nowrap">l'ensemble de nos</span> <br>
                        <span class="text-gold fw-bold d-block">savoir-faire</span>
                    </h3>
                    <p class="lead text-secondary mb-4 lh-lg">
                       Que votre objectif soit de créer un site innovant, de développer votre activité, d'améliorer votre marketing digital ou votre SEO, nous sommes à vos côtés. Nous vous proposons des solutions efficaces et pérennes qui répondent à vos besoins.
                    </p>
                    <p class="lead text-secondary mb-4 lh-lg">
                        De plus, nous gérons vos projets de refonte, nous nous chargeons de la maintenance et de l'hébergement de vos sites et élaborons des stratégies SEO efficaces pour renforcer votre présence en ligne.
                    </p>
                    <div class="text-center">
                        <a href="pages/service.php" class="btn btn-gold btn-lg">Voir tous nos services</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row g-2">
                    <?php
                    $delay = 200;
                    foreach ($services as $service) {
                    ?>
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                            <div class="service-card h-100 p-2 text-center">
                                <i class="fas <?php echo htmlspecialchars($service['icone']); ?> service-icon text-gold fa-lg mb-3 mt-4"></i>
                                <h3 class="service-title h6 text-dark mb-2"><?php echo htmlspecialchars($service['nom']); ?></h3>
                                <p class="service-description text-muted small mb-0" style="font-size: 0.8rem;">
                                    <?php echo htmlspecialchars($service['description']); ?>
                                </p>
                                <?php if ($service['prix_min'] && $service['prix_max']) { ?>
                                    <p class="text-gold mt-2 fw-bold" style="font-size: 0.75rem;">
                                        <?php echo number_format($service['prix_min'], 0, ',', ' '); ?>€ - 
                                        <?php echo number_format($service['prix_max'], 0, ',', ' '); ?>€
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                        $delay += 100;
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="portfolio-section" id="portfolio">
    <div class="container">
        <div class="text-center">
            <span class="section-label" data-aos="fade-up">Réalisations Marquantes</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Projets Sélectionnés</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
                Découvrez comment nous transformons des idées complexes en expériences digitales fluides.
            </p>
        </div>

        <?php
        $categories = [
            'site_web' => 'Développement Web',
            'design'   => 'Design & Branding',
            'photo'    => 'Photographie',
            'autre'    => 'Création'
        ];

        if (count($portfolio_items) > 0) { 
        ?>
            <div class="portfolio-grid" data-aos="zoom-in">
                <?php
                $styles_grille = ['spot-large', 'spot-medium', 'spot-medium'];
                
                foreach ($portfolio_items as $index => $item) {
                    $classe_spot = $styles_grille[$index % 3];
                    $categorie_nom = $categories[$item['categorie']] ?? 'Projet';
                    
                    $image_src = !empty($item['image_url']) 
                        ? (strpos($item['image_url'], '/') === 0 ? $item['image_url'] : "/images/" . $item['image_url']) 
                        : "/images/default-portfolio.jpg";
                ?>
                    <div class="spot <?php echo $classe_spot; ?>">
                        <img src="<?php echo htmlspecialchars($image_src); ?>" alt="<?php echo htmlspecialchars($item['titre']); ?>">
                        <div class="portfolio-overlay">
                            <div class="portfolio-info">
                                <div class="portfolio-category"><?php echo $categorie_nom; ?></div>
                                <h4><?php echo htmlspecialchars($item['titre']); ?></h4>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="pages/realisation.php" class="btn btn-gold btn-lg">Voir tous nos projets</a>
        </div>
    </div>
</section>

    <section class="services-section" id="process" style="padding-top: 60px; padding-bottom: 60px; background: var(--white-color);">
        <div class="container">
            <div class="text-center mb-4">
                <span class="section-label">Méthodologie & Accompagnement</span>
                <h2 class="section-title">Comment nous travaillons</h2>
                <p class="section-subtitle">Un parcours structuré en trois étapes clés pour garantir la réussite de votre transformation digitale, de la stratégie à la mise en ligne.</p>
            </div>
            <div class="row text-center">
                <div class="col-md-4 mb-4" data-aos="fade-up">
                    <i class="fas fa-lightbulb fa-2x text-gold mb-3"></i>
                    <h5>Phase d'Immersion & Stratégie</h5>
                    <p class="text-secondary">Analyse de vos besoins, étude de votre cible et définition d'une feuille de route précise. Nous posons les bases solides de votre futur succès.</p>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-pencil-ruler fa-2x text-gold mb-3"></i>
                    <h5>Conception & Expérience Utilisateur (UX/UI)</h5>
                    <p class="text-secondary">Création de maquettes sur-mesure et prototypes interactifs. Nous validons ensemble l'ergonomie et l'esthétique avant d'écrire la moindre ligne de code.</p>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-code fa-2x text-gold mb-3"></i>
                    <h5>Développement & Déploiement</h5>
                    <p class="text-secondary">Intégration technique rigoureuse, tests de performance et mise en production. Vous bénéficiez d'un suivi post-lancement pour garantir la pérennité de votre outil.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="hero-section hero-cta" style="background: linear-gradient(135deg, rgba(212,175,55,0.12), rgba(0,0,0,0)); padding: 12px 0;">
        <div class="container text-center">
            <h3 class="mb-3">Prêt à passer à l'étape supérieure ?</h3>
            <p class="mb-4 text-secondary">Ne laissez pas votre présence en ligne au hasard. Profitez d'un accompagnement sur-mesure dès aujourd'hui. Réponse garantie en moins de 48 heures.</p>
            <a href="pages/devis.php" class="btn btn-gold btn-lg">Demander un devis</a>
            <a href="pages/realisation.php" class="btn btn-outline-gold btn-lg ms-3">Voir notre travail</a>
        </div>
    </section>

</main>

<?php
include __DIR__ . '/includes/footer.inc.php';
?>