<!DOCTYPE html>
<html lang="fr">
<!-- NOTE: Ce fichier semble être une ancienne version statique de la page d'accueil. -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DILIGIRIUS - Agence Web Premium</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- TON FICHIER CSS - TRÈS IMPORTANT ! -->
    <link href="cssprojet.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container"> 
            <a class="navbar-brand logo-text" href="#">
                DILIG<span class="logo-accent">I</span>RIUS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Les liens de navigation sont statiques ici. -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-gold ms-3">Prendre RDV</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="accueil">
        <div class="hero-pattern"></div>
        <div class="hero-gradient"></div>
        <div class="container">
            <div class="row align-items-center">
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
                        <button class="btn btn-gold btn-lg me-3">Découvrir</button>
                        <button class="btn btn-outline-gold btn-lg">Me contacter</button>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="hero-logo">
                        <div class="hero-logo-box">
                            <div class="logo-image">DILIGIRIUS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <!-- Les chiffres des statistiques sont en dur (hard-coded) et non dynamiques. -->
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Projets Réalisés</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number">40+</div>
                        <div class="stat-label">Clients Satisfaits</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Sur-Mesure</div>
                    </div>
                </div>
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
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Services Premium</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
                    Des solutions digitales haut de gamme pour votre entreprise
                </p>
            </div>
            
            <!-- Les cartes de service sont également statiques. -->
            <div class="row">
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="service-number">01</div>
                        <i class="fas fa-code service-icon"></i>
                        <h3 class="service-title">Sites Web Sur-Mesure</h3>
                        <p class="service-description">
                            Conception et développement de sites web uniques, performants et adaptés à votre identité. De la landing page au site e-commerce complexe.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card">
                        <div class="service-number">02</div>
                        <i class="fas fa-palette service-icon"></i>
                        <h3 class="service-title">Design & Identité Visuelle</h3>
                        <p class="service-description">
                            Création de logos professionnels, chartes graphiques complètes et identité visuelle cohérente pour marquer les esprits.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card">
                        <div class="service-number">03</div>
                        <i class="fas fa-camera service-icon"></i>
                        <h3 class="service-title">Photographie Professionnelle</h3>
                        <p class="service-description">
                            Shootings photo de qualité pour sublimer vos produits, locaux et équipes. Traitement et retouche professionnelle inclus.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card">
                        <div class="service-number">03</div>
                        <i class="fas fa-camera service-icon"></i>
                        <h3 class="service-title">Photographie Professionnelle</h3>
                        <p class="service-description">
                            Shootings photo de qualité pour sublimer vos produits, locaux et équipes. Traitement et retouche professionnelle inclus.
                        </p>
                    </div>
                </div>
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
            
            <!-- Les éléments du portfolio sont statiques. -->
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
                
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
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
                
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="400">
                    <div class="portfolio-item">
                        <img src="https://images.unsplash.com/photo-1626785774573-4b799315345d?w=600" alt="Logo Design">
                        <div class="portfolio-overlay">
                            <div class="portfolio-info">
                                <div class="portfolio-category">Design</div>
                                <h4>Création Logo Premium</h4>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <!-- Le formulaire de contact est statique, sans la liste déroulante des services chargée depuis la BDD. -->
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
                                    <select name="service" class="form-select" required>
                                        <option value="">Sélectionnez un service</option>
                                        <option value="site_web">Site Web Sur-Mesure</option>
                                        <option value="design">Design & Identité Visuelle</option>
                                        <option value="photo">Photographie Professionnelle</option>
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

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="footer-logo">DILIGIRIUS</div>
                    <p class="footer-text">
                        Votre partenaire digital pour des projets web innovants et performants. Excellence, créativité et sur-mesure.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h4 class="footer-title">Liens Rapides</h4>
                    <ul class="footer-links">
                        <li><a href="#accueil">Accueil</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#portfolio">Portfolio</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h4 class="footer-title">Me Suivre</h4>
                    <div class="social-links">
                        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p class="mb-0">&copy; 2025 DILIGIRIUS. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Chatbot Button -->
    <div class="chatbot-btn" title="Assistant virtuel">
        <i class="fas fa-comment-dots"></i>
    </div>

    <!-- Scripts JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <!-- jQuery pour AJAX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    

</body>
</html>