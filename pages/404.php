<?php http_response_code(404); include 'includes/header.inc.php'; ?>
<main class="main-content-wrapper">
    <section class="error-section">
        <div class="container text-center">
            <div class="error-container">
                <img src="images/favicon.png" alt="Logo" class="error-logo">
                <div class="error-number">404</div>
                <h1 class="error-title">Page Introuvable</h1>
                <div class="error-divider"></div>
                <p class="error-subtitle">Oups ! Cette page semble s'être envolée...</p>
                <p class="error-description">La page que vous recherchez n'existe pas ou a été déplacée. Ne vous inquiétez pas, nous sommes là pour vous aider.</p>
                <div class="error-actions">
                    <a href="index.php" class="btn-error-home"><i class="fas fa-home"></i> Retour</a>
                    <a href="contact.php" class="btn-error-contact"><i class="fas fa-envelope"></i> Contact</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include 'includes/footer.inc.php'; ?>