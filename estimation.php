<?php
session_start();
include 'includes/db.inc.php';

// Récupérer tous les services actifs pour l'estimateur
$stmt_services = $pdo->query("SELECT nom, description, prix_min, prix_max FROM services WHERE actif = 1 AND prix_min > 0 ORDER BY ordre_affichage");
$services = $stmt_services->fetchAll();

include 'includes/header.inc.php';
?>
<main class="main-content-wrapper" style="padding: 150px 0; background: var(--grey-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title">Estimateur de Projet</h1>
            <p class="section-subtitle">Obtenez une première estimation pour votre projet en quelques clics.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title mb-4">1. Sélectionnez les services souhaités</h3>
                        <div id="services-list">
                            <?php if (empty($services)): ?>
                                <p class="text-center text-muted">Aucun service disponible pour l'estimation pour le moment.</p>
                            <?php else: ?>
                                <?php foreach ($services as $service): ?>
                                <div class="form-check fs-5 mb-3">
                                    <input class="form-check-input service-checkbox" type="checkbox" 
                                           value="<?php echo htmlspecialchars($service['nom']); ?>" 
                                           id="service-<?php echo md5($service['nom']); ?>"
                                           data-prix-min="<?php echo $service['prix_min']; ?>"
                                           data-prix-max="<?php echo $service['prix_max']; ?>">
                                    <label class="form-check-label" for="service-<?php echo md5($service['nom']); ?>">
                                        <?php echo htmlspecialchars($service['nom']); ?>
                                    </label>
                                    <small class="d-block text-muted ps-4"><?php echo htmlspecialchars($service['description']); ?></small>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <hr class="my-5">

                        <h3 class="card-title mb-4">2. Votre estimation préliminaire</h3>
                        <div class="text-center bg-light p-4 rounded">
                            <p class="fs-4 mb-1">Fourchette de prix estimée :</p>
                            <p class="display-4 fw-bold text-gold" id="estimation-result">0 € - 0 €</p>
                            <p class="text-danger mt-3"><i class="fas fa-exclamation-triangle me-2"></i><strong>Attention :</strong> Ceci est une estimation non contractuelle. Un devis détaillé sera nécessaire pour un chiffrage précis.</p>
                        </div>

                        <hr class="my-5">

                        <div class="text-center">
                            <h3 class="card-title mb-3">3. Étape suivante</h3>
                            <p>Cette estimation vous convient ? Contactez-moi pour affiner votre projet et recevoir un devis formel.</p>
                            <a href="/contact.php" id="request-quote-btn" class="btn btn-gold btn-lg disabled">
                                Demander un devis sur cette base
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.service-checkbox');
    const estimationResult = document.getElementById('estimation-result');
    const requestQuoteBtn = document.getElementById('request-quote-btn');

    function calculateEstimate() {
        let totalMin = 0;
        let totalMax = 0;
        let selectedServices = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                totalMin += parseFloat(checkbox.dataset.prixMin);
                totalMax += parseFloat(checkbox.dataset.prixMax);
                selectedServices.push(checkbox.value);
            }
        });

        const formatter = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR', minimumFractionDigits: 0 });
        
        estimationResult.textContent = `${formatter.format(totalMin)} - ${formatter.format(totalMax)}`;

        if (selectedServices.length > 0) {
            requestQuoteBtn.classList.remove('disabled');
            let contactUrl = '/contact.php?source=estimation';
            contactUrl += '&services=' + encodeURIComponent(selectedServices.join(', '));
            contactUrl += '&estimation=' + encodeURIComponent(`${formatter.format(totalMin)} - ${formatter.format(totalMax)}`);
            requestQuoteBtn.href = contactUrl;
        } else {
            requestQuoteBtn.classList.add('disabled');
            requestQuoteBtn.href = '#';
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', calculateEstimate);
    });

    // Initial calculation in case of back button usage
    calculateEstimate();
});
</script>

<?php include 'includes/footer.inc.php'; ?>

```

### Étape 2 : Vérifier le lien dans `profil.php`

Assurons-nous que le lien dans votre page de profil est correct. Il doit avoir l'attribut `role="link"` pour fonctionner correctement avec les onglets.

```diff
                    <div class="card-header"><h2 class="h5 mb-0">Mes Devis</h2></div>
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="estimation.php" class="btn btn-gold" role="link">
                                <i class="fas fa-calculator me-2"></i>Obtenir une estimation (Devis factice)
                            </a>
                        </div>

