<?php 
http_response_code(404);
include __DIR__ . '/../includes/header.inc.php';
?>

<main class="main-content-wrapper">

    <section class="error-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    
                    <div class="error-animation">
                        <div class="error-number">404</div>
                    </div>

                    <h1 class="error-title">Page Introuvable</h1>

                    <p class="error-subtitle">Oups ! La page que vous recherchez semble s'être envolée dans le cyberespace...</p>

                    <div class="error-info-box">
                        <p class="error-info-text">
                            La page que vous tentez d'accéder n'existe pas ou a peut-être été déplacée. <br>
                            <strong>Pas de panique !</strong> Utilisez la navigation ci-dessous pour explorer notre site.
                        </p>
                    </div>

                    <div class="error-actions">
                        <a href="/" class="btn btn-gold btn-lg">
                            <i class="fas fa-home"></i> Retour à l'accueil
                        </a>
                        <a href="/contact" class="btn btn-outline-gold btn-lg">
                            <i class="fas fa-envelope"></i> Nous contacter
                        </a>
                    </div>

                    <hr class="error-divider">

                    <div class="error-explore-section">
                        <h3 class="error-explore-title">Explorer notre site</h3>
                        <div class="error-cards-grid">
                            <a href="/nos-services" class="error-card">
                                <div class="error-card-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <h4 class="error-card-title">Nos Services</h4>
                                <p class="error-card-text">Découvrez nos expertises en développement et design</p>
                            </a>

                            <a href="/realisations" class="error-card">
                                <div class="error-card-icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <h4 class="error-card-title">Portfolio</h4>
                                <p class="error-card-text">Consultez nos derniers projets réalisés</p>
                            </a>

                            <a href="/devis" class="error-card">
                                <div class="error-card-icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <h4 class="error-card-title">Devis</h4>
                                <p class="error-card-text">Demandez un devis pour votre projet</p>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main>

<?php include __DIR__ . '/../includes/footer.inc.php'; ?>