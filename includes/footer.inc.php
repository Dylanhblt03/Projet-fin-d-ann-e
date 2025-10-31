        <!-- Pied de page du site -->
        <footer>
            <div class="container">
                <div class="row">
                    <!-- Section 1: Logo et description -->
                    <div class="col-md-4 mb-4">
                        <div class="footer-logo">Oléris</div>
                        <p class="footer-text">
                            Votre partenaire digital pour des projets web innovants et performants. Excellence, créativité et sur-mesure.
                        </p>
                    </div>
                    <!-- Section 2: Liens de navigation rapides -->
                    <div class="col-md-4 mb-4">
                        <h4 class="footer-title">Liens Rapides</h4>
                        <ul class="footer-links">
                            <li><a href="/index.php#accueil">Accueil</a></li>
                            <li><a href="/index.php#services">Services</a></li>
                            <li><a href="/index.php#portfolio">Portfolio</a></li>
                            <li><a href="/index.php#contact">Contact</a></li>
                        </ul>
                    </div>
                    <!-- Section 3: Liens vers les réseaux sociaux -->
                    <div class="col-md-4 mb-4">
                        <h4 class="footer-title">Me Suivre</h4>
                        <div class="social-links">
                            <a href="https://www.linkedin.com/in/humblot-dylan-49835b341/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://github.com/Dylanhblt03" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="https://www.instagram.com/nuagedencre/?igsh=MXViOTA2N3A3amFudg%3D%3D#" target="_blank"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Ligne de copyright -->
                <div class="copyright">
                    <p class="mb-0">&copy; 2025 Oléris. Tous droits réservés.</p>
                </div>
            </div>
        </footer>

        <!-- =============================================== -->
        <!-- CHATBOT HTML -->
        <!-- =============================================== -->
        <!-- Bouton flottant pour ouvrir/fermer le chatbot -->
        <div id="chatbot-toggle-btn" class="chatbot-toggle-btn">
            <i class="fas fa-comment-dots"></i>
        </div>
        
        <!-- Fenêtre du chatbot, cachée par défaut -->
        <div id="chatbot-window" class="chatbot-window">
            <!-- En-tête du chatbot -->
            <div class="chatbot-header">
                <span class="chatbot-title">Oléris Assistant</span>
                <button id="chatbot-close-btn" class="chatbot-close-btn">&times;</button>
            </div>
            <!-- Corps du chatbot où les messages s'affichent -->
            <div class="chatbot-body" id="chatbot-messages">
                <div class="message bot-message">Bonjour ! Je suis l'assistant Oléris. Posez-moi une question sur nos services, nos tarifs ou votre projet pour commencer.</div>
            </div>
            <!-- Pied de page du chatbot avec le champ de saisie et le bouton d'envoi -->
            <div class="chatbot-footer">
                <input type="text" id="chatbot-input" placeholder="Écrivez votre question..." autofocus>
                <button id="chatbot-send-btn" class="chatbot-send-btn"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>

    <!-- Scripts JavaScript chargés à la fin du body pour de meilleures performances -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>AOS.init();</script> <!-- Initialisation simple de la bibliothèque AOS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="java.js"></script> <!-- Votre fichier JavaScript personnalisé -->
    
</body>
</html>