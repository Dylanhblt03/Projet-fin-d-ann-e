<?php
session_start();
include '../includes/db.inc.php';
$services = getServices($conn);
include '../includes/header.inc.php';

$isSuccess = (isset($_SESSION['flash_type']) && $_SESSION['flash_type'] === 'success');

$message_preselect = '';
$service_preselect = $_GET['service'] ?? '';
if (isset($_GET['source']) && $_GET['source'] === 'estimation') {
    $services_estimes = $_GET['services'] ?? '';
    $fourchette_prix = $_GET['estimation'] ?? '';
    $message_preselect = "Bonjour,\n\nSuite à une estimation sur votre site, je souhaiterais recevoir un devis formel pour :\n- " . str_replace(',', "\n- ", $services_estimes) . "\n\nL'estimation était de : " . $fourchette_prix . "\n\nMerci.\n";
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

    <section class="contact-section" id="devis">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <?php if ($isSuccess) { ?>
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-file-invoice-dollar text-gold" style="font-size: 5rem;"></i>
                            </div>
                            <h2 class="section-title text-white">Demande reçue !</h2>
                            <div class="p-4 border border-gold rounded shadow-lg bg-dark">
                                <p class="text-white fs-4">Nous avons bien reçu votre demande de devis.</p>
                                <p class="text-gold fw-bold fs-5">Nous prenons en compte votre demande et revenons vers vous dans les plus brefs délais.</p>
                            </div>
                            <div class="mt-5">
                                <a href="../index.php" class="btn btn-outline-gold">Retour à l'accueil</a>
                            </div>
                        </div>
                    <?php 
                        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
                    } else { ?>

                        <div class="text-center">
                            <h2 class="section-title text-white mt-5">Confiez-nous votre vision.</h2>
                            <p class="section-subtitle text-white-50">Plus votre description sera détaillée, plus ma proposition sera précise. Recevez sous 48h un devis complet.</p>
                        </div>

                        <?php if (isset($_SESSION['flash_message'])) { ?>
                            <div class="alert alert-danger text-center fw-bold">
                                <?php echo htmlspecialchars($_SESSION['flash_message']); ?>
                            </div>
                            <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
                        <?php } ?>

                        <div class="contact-form mt-4">
                            <form id="devisForm" action="traitement_devis.php" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <div style="display:none;"><input type="text" name="website_check"></div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-gold">Nom complet *</label>
                                        <input type="text" name="nom" class="form-control" placeholder="Votre nom" required minlength="2">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-gold">Email *</label>
                                        <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-gold">Téléphone *</label>
                                        <input type="tel" name="telephone" class="form-control" placeholder="06XXXXXXXX" required pattern="[0-9]{10}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-gold">Entreprise (optionnel)</label>
                                        <input type="text" name="entreprise" class="form-control" placeholder="Nom de l'entreprise">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-gold">Type de service *</label>
                                        <select id="serviceSelect" name="service" class="form-select" required>
                                            <option value="" class="bg-white text-dark">Sélectionnez un service</option>
                                            <?php foreach ($services as $service) { 
                                                $nom = $service['nom'];
                                            ?>
                                                <option value="<?php echo htmlspecialchars($nom); ?>" 
                                                        class="bg-white text-dark"
                                                        <?php echo ($nom === $service_preselect) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($nom); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-gold">Budget indicatif (optionnel)</label>
                                        <input type="text" name="budget" class="form-control" placeholder="Ex: 1500-3000€">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-gold">Date souhaitée (optionnel)</label>
                                    <input type="date" name="date_souhaitee" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label text-gold">Détails du projet * (20 caractères min.)</label>
                                    <textarea name="message" class="form-control" rows="8" placeholder="Décrivez votre projet..." required minlength="20"><?php echo htmlspecialchars($message_preselect); ?></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-gold btn-lg w-100">Demander mon devis</button>
                                </div>
                            </form>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </section>


<?php include '../includes/footer.inc.php'; ?>