<?php
// Détecte automatiquement le préfixe du chemin selon le répertoire courant
$current_dir = dirname($_SERVER['PHP_SELF']);
$is_in_pages_folder = (basename($current_dir) === 'pages');
$path_prefix = $is_in_pages_folder ? '' : 'pages/';
?>
<footer class="site-footer">
    <div class="container">
        <div class="row footer-content justify-content-between">
            <div class="col-md-3 mb-4 text-center">
                <div class="footer-brand">
                    <a class="navbar-brand logo-text" href="/">
                        <img src="/images/oleris.jpg" alt="Logo Oléris - Agence Web" class="footer-logo" width="150">
                    </a>
                </div>
                <p class="footer-description mt-3">
                    Votre partenaire digital pour des projets web innovants et performants. Expertise en développement, design et stratégie.
                </p>
            </div>

            <div class="col-md-3 mb-4 text-center">
                <h4 class="footer-title">Navigation</h4>
                <ul class="footer-links list-unstyled d-inline-block text-start">
                    <li><a href="/"><i class="fas fa-chevron-right me-2"></i>Accueil</a></li>
                    <li><a href="<?php echo $path_prefix; ?>service.php"><i class="fas fa-chevron-right me-2"></i>Nos Services</a></li>
                    <li><a href="<?php echo $path_prefix; ?>realisation.php"><i class="fas fa-chevron-right me-2"></i>Réalisations</a></li>
                    <li><a href="<?php echo $path_prefix; ?>contact.php"><i class="fas fa-chevron-right me-2"></i>Contact</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-4 text-center">
                <h4 class="footer-title">Contact</h4>
                <ul class="footer-contact list-unstyled d-inline-block text-start">
                    <li class="mb-3">
                        <a href="tel:+33677508835" class="text-decoration-none text-reset">
                            <i class="fas fa-phone text-gold me-2"></i>06 77 50 88 35
                        </a>
                    </li>
                    <li>
                        <a href="mailto:contact@oleris.fr" class="text-decoration-none text-reset">
                            <i class="fas fa-envelope text-gold me-2"></i>contact@oleris.fr
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 mb-4 text-center">
                <h4 class="footer-title">Suivez l'Agence</h4>
                <div class="social-links">
                    <a href="https://www.linkedin.com/in/humblot-dylan-49835b341/" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://github.com/Dylanhblt03" target="_blank" rel="noopener" aria-label="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://www.instagram.com/nuagedencre/" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr class="border-secondary opacity-25">

        <div class="footer-bottom py-3">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> **Oléris**. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="<?php echo $path_prefix; ?>mentions-legales.php" class="text-white-50 text-decoration-none small">Mentions Légales</a>
                    <span class="text-white-50 mx-2">|</span>
                    <a href="<?php echo $path_prefix; ?>politique-confidentialite.php" class="text-white-50 text-decoration-none small">Confidentialité</a>
                </div>
            </div>
        </div>
    </div>

    <div id="cookie-banner" class="cookie-banner shadow-lg">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="cookie-text me-md-4 mb-3 mb-md-0">
            <i class="fas fa-cookie-bite text-gold me-2"></i>
            <span>En poursuivant votre navigation, vous acceptez l’utilisation de cookies pour améliorer votre expérience sur **Oléris**.</span>
        </div>
        <div class="cookie-buttons">
            <button id="accept-cookies" class="btn btn-gold btn-sm px-4 me-2">Accepter</button>
            <a href="<?php echo $path_prefix; ?>politique-confidentialite.php" class="text-white-50 small text-decoration-none">En savoir plus</a>
        </div>
    </div>
</div>
</footer>

<div id="chatbot-toggle-btn" class="chatbot-toggle-btn" aria-label="Ouvrir l'assistant">
    <i class="fas fa-comment-dots"></i>
</div>

<div id="chatbot-window" class="chatbot-window">
    <div class="chatbot-header">
        <span class="chatbot-title">Oléris Assistant</span>
        <button id="chatbot-close-btn" class="chatbot-close-btn" aria-label="Fermer">&times;</button>
    </div>
    <div class="chatbot-body" id="chatbot-messages">
        <div class="message bot-message">Bonjour ! Je suis l'assistant Oléris. Comment puis-je vous aider aujourd'hui ?</div>
    </div>
    <div class="chatbot-footer">
        <input type="text" id="chatbot-input" placeholder="Posez votre question..." aria-label="Message au chatbot">
        <button id="chatbot-send-btn" class="chatbot-send-btn"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="/script/java.js" defer></script>

<!-- Preload critical resources -->
<link rel="preload" href="/css/cssprojet.css" as="style">
<link rel="preload" href="/images/oleris.jpg" as="image">

</body>
</html>