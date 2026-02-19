<?php
session_start();
include __DIR__ . '/../includes/db.inc.php';
$services = getServices($conn);
include __DIR__ . '/../includes/header.inc.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$isSuccess = (isset($_SESSION['flash_type']) && $_SESSION['flash_type'] === 'success');

$message_preselect = '';
if (isset($_GET['source']) && $_GET['source'] === 'estimation') {
    $services_estimes = $_GET['services'] ?? '';
    $fourchette_prix = $_GET['estimation'] ?? '';
    $message_preselect = "Bonjour,\n\nSuite à une estimation...\n- " . str_replace(',', "\n- ", $services_estimes) . "\n\nEstimation : " . $fourchette_prix . "\n\nCordialement,";
}
?>

<section class="contact-section" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <?php
                if ($isSuccess) { ?>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-gold" style="font-size: 5rem;"></i>
                        </div>
                        <h2 class="section-title text-white">Merci !</h2>
                        <div class="p-4 border border-gold rounded shadow-lg bg-dark">
                            <p class="text-white fs-4">Votre message a bien été pris en compte.</p>
                            <p class="text-gold fw-bold fs-5">Nous vous répondrons sous 48H.</p>
                        </div>
                        <div class="mt-5">
                            <a href="/" class="btn btn-outline-gold">Retour à l'accueil</a>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['flash_message']);
                    unset($_SESSION['flash_type']);
                }
                else { ?>

                    <div class="text-center">
                        <h2 class="section-title text-white mt-5">Donnons vie à vos ambitions.</h2>
                        <p class="text-white-50">Tous les champs sont obligatoires.</p>
                    </div>

                    <?php if (isset($_SESSION['flash_message'])) { ?>
                        <div class="alert alert-danger text-center fw-bold">
                            <?php echo htmlspecialchars($_SESSION['flash_message']); ?>
                        </div>
                    <?php
                        unset($_SESSION['flash_message']);
                        unset($_SESSION['flash_type']);
                    } ?>

                    <div class="contact-form mt-4">
                        <form id="contactForm" action="/traitement_contact" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div style="display:none;"><input type="text" name="website_check"></div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-gold">Nom complet *</label>
                                    <input type="text" name="nom" class="form-control"
                                        placeholder="Ex: Jean Dupont" required minlength="2">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-gold">Email *</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="votre@email.com" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-gold">Téléphone *</label>
                                    <input type="tel" name="telephone" class="form-control"
                                        required pattern="[0-9]{10}" placeholder="06XXXXXXXX">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-gold">Service *</label>
                                    <select name="service" class="form-select text-white bg-transparent" required>
                                        <option value="" class="bg-white text-dark">Sélectionnez un service</option>

                                        <?php foreach ($services as $service) { ?>
                                            <option value="<?php echo htmlspecialchars($service['nom']); ?>" class="bg-white text-dark">
                                                <?php echo htmlspecialchars($service['nom']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-gold">Message (minimum 10 caractères) *</label>
                                <textarea name="message" class="form-control" rows="8"
                                    required minlength="10"
                                    placeholder="Décrivez votre projet ici..."><?php echo htmlspecialchars($message_preselect); ?></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-gold btn-lg w-100">Envoyer la demande</button>
                            </div>
                        </form>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.inc.php'; ?>