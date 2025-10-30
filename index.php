<?php
// 1. Inclure le fichier de connexion à la base de données.
include 'includes/db.inc.php';

// 2. Récupérer les services actifs pour les afficher dans la section "Services" et le formulaire de contact.
$stmt_services = $pdo->query("SELECT * FROM services WHERE actif = 1 ORDER BY ordre_affichage");
$services = $stmt_services->fetchAll();

// 3. Récupérer les 5 derniers projets visibles pour la section "Portfolio".
$stmt_portfolio = $pdo->query("SELECT * FROM portfolio WHERE visible = 1 ORDER BY ordre_affichage LIMIT 5");
$portfolio_items = $stmt_portfolio->fetchAll();

// 4. Récupérer les statistiques pour la section avec les compteurs animés.
// Compte le nombre total de projets réalisés.
$stmt_projets_count = $pdo->query("SELECT COUNT(*) as total FROM portfolio WHERE visible = 1");
$projets_realises = $stmt_projets_count->fetch()['total'] ?? 0;

// Compte le nombre de clients uniques ayant des projets avec le statut 'terminé'.
$stmt_clients_count = $pdo->query("SELECT COUNT(DISTINCT client_id) as total FROM projets WHERE statut = 'termine'");
$clients_satisfaits = $stmt_clients_count->fetch()['total'] ?? 0;

// 5. Inclure le fichier d'en-tête (header), qui contient le début du HTML, la navbar, etc.
include 'includes/header.inc.php';
?>

<main class="main-content-wrapper">

    <!-- Hero Section -->
    <section class="hero-section" id="accueil">
        <div class="hero-pattern"></div> <!-- Élément pour le motif de fond -->
        <div class="hero-gradient"></div> <!-- Élément pour le dégradé de fond -->
        <div class="container">
            <div class="row align-items-center">
                <!-- Colonne de gauche avec le contenu textuel -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="hero-content">
                        <span class="hero-label">Agence Web Premium</span>
                        <h1 class="hero-title">
                            Créations Web<br>
                            <span class="gold-text">Exceptionnelles</span>
                        </h1>
                        <p class="hero-subtitle">
                            Design sur-mesure, développement web innovant et photographie professionnelle pour donner vie à vos projets digitaux.
                        </p>
                        <a href="#services" class="btn btn-gold btn-lg me-3">Découvrir</a>
                        <a href="/contact.php" class="btn btn-outline-gold btn-lg">Me contacter</a>
                    </div>
                </div>
                <!-- Colonne de droite avec le logo/image -->
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="hero-logo">
                        <div class="hero-logo-box">
                            <img src="/images/oleris.jpg" alt="Logo Oléris" class="hero-logo-img-fill img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section des Statistiques (Stats) -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <!-- Statistique 1 : Projets Réalisés -->
                <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <!-- Le `data-target` est utilisé par le JavaScript pour l'animation du compteur -->
                        <div class="stat-number counter" data-target="<?php echo $projets_realises; ?>">0</div>
                        <div class="stat-label">Projets Réalisés</div>
                    </div>
                </div>
                <!-- Statistique 2 : Clients Satisfaits -->
                <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number counter" data-target="<?php echo $clients_satisfaits; ?>">0</div>
                        <div class="stat-label">Clients Satisfaits</div>
                    </div>
                </div>
                <!-- Statistique 3 : Sur-Mesure (valeur fixe) -->
                <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number counter" data-target="100">0</div>
                        <div class="stat-label">Sur-Mesure</div>
                    </div>
                </div>
                <!-- Statistique 4 : Support Client (valeur fixe, non animée) -->
                <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support Client</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="text-center">
                <span class="section-label" data-aos="fade-up">Nos Expertises</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Services</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
                    Des solutions digitales haut de gamme pour votre entreprise
                </p>
            </div>

            <div class="row">
                <?php
                $delay = 200; // Délai initial pour l'animation AOS.
                $number = 1; // Numéro du service pour l'affichage.
                // Boucle pour afficher chaque service récupéré de la BDD.
                foreach ($services as $service):
                ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="service-card">
                            <div class="service-number"><?php echo str_pad($number, 2, '0', STR_PAD_LEFT); ?></div>
                            <i class="fas <?php echo htmlspecialchars($service['icone']); ?> service-icon"></i>
                            <h3 class="service-title"><?php echo htmlspecialchars($service['nom']); ?></h3> <!-- Utiliser htmlspecialchars pour la sécurité -->
                            <p class="service-description">
                                <?php echo htmlspecialchars($service['description']); ?>
                            </p>
                            <!-- Affiche la fourchette de prix si elle existe -->
                            <?php if ($service['prix_min'] && $service['prix_max']): ?>
                                <p class="text-gold mt-3">
                                    <strong><?php echo number_format($service['prix_min'], 0, ',', ' '); ?>€ -
                                        <?php echo number_format($service['prix_max'], 0, ',', ' '); ?>€</strong>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                    $delay += 100; // Augmente le délai pour la carte suivante.
                    $number++; // Incrémente le numéro du service.
                endforeach;

                if (empty($services)):
                // Message affiché si aucun service n'est trouvé dans la BDD.
                ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Aucun service disponible pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="/service.php" class="btn btn-gold btn-lg">Voir tous nos services</a>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section class="portfolio-section" id="portfolio">
        <div class="container">
            <div class="text-center">
                <span class="section-label" data-aos="fade-up">Réalisations</span>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Portfolio</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
                    Découvrez mes dernières créations
                </p>
            </div>

            <div class="row">
                <?php
                $delay = 200;
                // Boucle pour afficher chaque projet du portfolio.
                foreach ($portfolio_items as $item):
                    // Traduction de la catégorie du projet pour l'affichage.
                    $categories = [
                        'site_web' => 'Développement Web',
                        'design' => 'Design & Branding',
                        'photo' => 'Photographie',
                        'autre' => 'Création'
                    ];
                    $categorie_fr = $categories[$item['categorie']] ?? 'Projet'; // Valeur par défaut si la catégorie n'est pas trouvée.

                    // Logique pour varier la taille des colonnes et créer une grille asymétrique.
                    $current_index = ($delay - 200) / 100; // 0, 1, 2, 3, 4
                    $col_class = 'col-md-4'; // Valeur par défaut
                    if ($current_index === 0 || $current_index === 1) {
                        $col_class = 'col-md-6'; // Les deux premiers
                    } elseif ($current_index === 2) {
                        $col_class = 'col-md-5'; // Le troisième
                    } elseif ($current_index === 3) {
                        $col_class = 'col-md-3'; // Le quatrième
                    } elseif ($current_index === 4) {
                        $col_class = 'col-md-4'; // Le cinquième
                    }
                ?>
                    <div class="<?php echo $col_class; ?> mb-4" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                        <div class="portfolio-item">
                            <!-- Affiche l'image du projet ou une image par défaut si non fournie -->
                            <?php if ($item['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>"
                                    alt="<?php echo htmlspecialchars($item['titre']); ?>">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800"
                                    alt="<?php echo htmlspecialchars($item['titre']); ?>">
                            <?php endif; ?>

                            <!-- Superposition (overlay) qui apparaît au survol -->
                            <div class="portfolio-overlay">
                                <div class="portfolio-info">
                                    <div class="portfolio-category"><?php echo $categorie_fr; ?></div>
                                    <h4><?php echo htmlspecialchars($item['titre']); ?></h4>
                                    <?php if ($item['url_projet']): ?>
                                        <a href="<?php echo htmlspecialchars($item['url_projet']); ?>"
                                            target="_blank" class="btn btn-outline-gold btn-sm mt-2">
                                            Voir le projet <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    $delay += 100;
                endforeach;

                // Si aucun projet n'est trouvé dans la BDD, affiche des exemples statiques.
                if (empty($portfolio_items)):
                ?>
            <div class="row">
                <div class="col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="portfolio-item">
                        <img src="https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800" alt="Site Web Luxe">
                        <div class="portfolio-overlay">
                            <div class="portfolio-info">
                                <div class="portfolio-category">Développement Web</div>
                                <h4>Site E-commerce Luxe</h4>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="portfolio-item">
                        <img src="https://images.unsplash.com/photo-1558655146-9f40138edfeb?w=800" alt="Branding">
                        <div class="portfolio-overlay">
                            <div class="portfolio-info">
                                <div class="portfolio-category">Design & Branding</div>
                                <h4>Identité Visuelle Complète</h4>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8" data-aos="zoom-in" data-aos-delay="200">
                    <div class="portfolio-item">
                        <img src="https://images.unsplash.com/photo-1542744094-3a31f272c490?w=600" alt="Photo Produit">
                        <div class="portfolio-overlay">
                            <div class="portfolio-info">
                                <div class="portfolio-category">Photographie</div>
                                <h4>Shooting Produit</h4>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="portfolio-item">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600" alt="Application Web">
                        <div class="portfolio-overlay">
                            <div class="portfolio-info">
                                <div class="portfolio-category">Développement Web</div>
                                <h4>Application SaaS</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="/portfolio.php" class="btn btn-gold btn-lg">Voir tout le portfolio</a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center">
                        <span class="section-label text-white bg-transparent" data-aos="fade-up">Contact</span>
                        <h2 class="section-title text-white" data-aos="fade-up" data-aos-delay="100">Prendre Rendez-vous</h2>
                        <p class="section-subtitle text-white-50" data-aos="fade-up" data-aos-delay="200">
                            Discutons de votre projet ensemble
                        </p>
                    </div>

                    <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
                        <!-- Le formulaire est envoyé via AJAX (voir java.js) -->
                        <form id="contactForm" action="traitement_contact.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom complet</label>
                                    <input type="text" name="nom" class="form-control" placeholder="Votre nom" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" name="telephone" class="form-control" placeholder="06 12 34 56 78" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Type de service</label>
                                    <select name="service" class="form-select" required id="serviceSelect">
                                        <option value="">Sélectionnez un service</option>
                                        <!-- Boucle pour peupler la liste déroulante avec les services de la BDD -->
                                        <?php foreach ($services as $service): ?>
                                            <option value="<?php echo htmlspecialchars($service['nom']); ?>">
                                                <?php echo htmlspecialchars($service['nom']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Décrivez votre projet</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="Parlez-moi de votre projet..." required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-gold btn-lg">Envoyer la demande</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
// Inclure le fichier de pied de page (footer).
include 'includes/footer.inc.php';
?>
