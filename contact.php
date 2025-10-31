<?php

// 1. Inclure la connexion à la base de données.
include 'includes/db.inc.php';

// 2. Récupérer les services actifs pour peupler le menu déroulant du formulaire.
$stmt = $pdo->query("SELECT nom FROM services WHERE actif = 1 ORDER BY ordre_affichage");
$services = $stmt->fetchAll();

// 3. Inclure l'en-tête de la page.
include 'includes/header.inc.php';

// 4. Pré-remplissage du formulaire si les données viennent de l'estimateur
$service_preselect = $_GET['service'] ?? '';
$message_preselect = '';
if (isset($_GET['source']) && $_GET['source'] === 'estimation') {
    $services_estimes = $_GET['services'] ?? '';
    $fourchette_prix = $_GET['estimation'] ?? '';
    $message_preselect = "Bonjour,\n\nSuite à une estimation sur votre site, je serais intéressé(e) par un devis formel pour les services suivants :\n- " . str_replace(',', "\n- ", $services_estimes) . "\n\nL'estimation était de : " . $fourchette_prix . "\n\nMerci de revenir vers moi.\n\nCordialement,";
}


?>
    <main>

        <section class="hero-section" id="accueil"> <!-- Section de présentation "Qui sommes-nous ?" -->
            <div class="hero-pattern"></div>
            <div class="hero-gradient"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="hero-content">
                            <h1 class="hero-title fs-1">
                                Qui sommes-nous ?<br>
                            </h1>
                            <p class="hero-subtitle">
                                Nous sommes une agence web spécialisée dans la création de sites internet sur-mesure, prêt à vous accompagner dans vos projets digitaux les plus ambitieux.
                            </p>
                            <div class="text-center mt-4">
                            <button class="btn btn-gold btn-lg me-3">Découvrir</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <div class="hero-logo">
                            <div class="hero-logo-box">
                                <img src="/images/oleris.jpg" alt="logo Oléris" class="hero-logo-img-fill img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-section" id="contact"> <!-- Section du formulaire de contact -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center">
                            <span class="section-label text-white bg-transparent" data-aos="fade-up">Contact</span>
                            <h2 class="section-title text-white" data-aos="fade-up" data-aos-delay="100">N'hesitez pas à nous contacter</h2>
                            <p class="section-subtitle text-white-50" data-aos="fade-up" data-aos-delay="200">
                                Discutons de votre projet ensemble
                            </p>
                        </div>

                        <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
                            <!-- Le formulaire est géré par AJAX via java.js -->
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
                                            <!-- Boucle pour générer les options du menu déroulant -->
                                            <option value="">Sélectionnez un service</option>
                                            <?php foreach ($services as $service): ?>
                                                <option value="<?php echo htmlspecialchars($service['nom']); ?>">
                                                    <?php echo htmlspecialchars($service['nom']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Décrivez votre projet</label>
                                    <textarea name="message" class="form-control" rows="8" placeholder="Parlez-moi de votre projet..." required><?php echo htmlspecialchars($message_preselect); ?></textarea>
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
// Inclure le footer
include 'includes/footer.inc.php'; // Inclut le pied de page.
?>