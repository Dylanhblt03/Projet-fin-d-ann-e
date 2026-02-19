<?php
include __DIR__ . '/../includes/db.inc.php';
$services = getServices($conn);
include __DIR__ . '/../includes/header.inc.php';
?>

<main>
    <section class="services-hero-section section-padding" style="background-color: var(--grey-dark); padding: 40px 0; min-height: 220px; display: flex; align-items: center;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-up">
                    <h1 class="display-3 text-white mb-3 mt-5 p-5">Propulsez votre activité avec une présence web d'exception</h1>
                    <p class="lead text-white-50">De la stratégie digitale à la réalisation sur-mesure, je crée des solutions web uniques qui transforment vos visiteurs en clients.</p>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/devis" class="btn btn-gold btn-lg">Demander un devis gratuit</a>
            </div>
        </div>
    </section>

    <section class="services-list-section section-padding">
        <div class="container">
            <?php foreach ($services as $index => $service) : ?>
                <?php
                $fade_direction = ($index % 2 == 0) ? 'fade-right' : 'fade-left';
                $row_reverse_class = ($index % 2 == 0) ? '' : 'flex-md-row-reverse';
                ?>
                <div class="row mb-5 align-items-center mt-5 <?php echo $row_reverse_class; ?>" data-aos="<?php echo $fade_direction; ?>">
                    <div class="col-md-6">
                        <h2 class="section-title-gold"><?php echo htmlspecialchars($service['nom']); ?></h2>
                        <p class="text-secondary"><?php echo htmlspecialchars($service['description']); ?></p>
                        
                        <?php if ($service['prix_min']) : ?>
                            <p class="text-gold mt-3">
                                À partir de <strong><?php echo number_format($service['prix_min'], 0, ',', ' '); ?>€</strong>
                            </p>
                        <?php endif; ?>

                        <a href="/devis?service=<?php echo urlencode($service['nom']); ?>" class="btn btn-gold btn-lg mt-3">Demander un devis</a>
                    </div>
                    
                    <div class="col-md-6 mt-4 mt-md-0 text-center">
                        <i class="fas <?php echo htmlspecialchars($service['icone']); ?> fa-5x text-gold"></i>
                    </div>
                </div>

                <?php if ($index < count($services) - 1) : ?>
                    <hr class="my-5 border-gold">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php
include __DIR__ . '/../includes/footer.inc.php';
?>