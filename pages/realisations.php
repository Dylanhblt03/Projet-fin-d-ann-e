<?php
include __DIR__ . '/../includes/db.inc.php';
$all_items = getPortfolioFull($conn);
$portfolio_items = array_filter($all_items, function($item) {
    return $item['visible'] == 1;
});
include __DIR__ . '/../includes/header.inc.php';
?>

<main class="main-content-wrapper" style="padding-top: 60px;">

    <section class="hero-section section-padding" style="background-color: var(--grey-dark); min-height: 25vh; display: flex; align-items: center;">
        <div class="container text-center" data-aos="fade-up">
            <h1 class="display-3 text-white mb-3">Ils nous ont fait confiance</h1>
            <p class="lead text-white-50">Découvrez nos réalisations et les détails de chaque projet.</p>
        </div>
    </section>

    <section class="portfolio-section" id="portfolio-grid">
        <div class="container">
            <div class="row">
                <?php if (empty($portfolio_items)) { ?>
                    <div class="col-12 text-center">
                        <p class="text-muted fs-4">Aucun projet à afficher pour le moment.</p>
                    </div>
                <?php } else { 
                    foreach ($portfolio_items as $item) {
                        $categories = [
                            'site_web' => 'Développement Web',
                            'design' => 'Design & Branding',
                            'photo' => 'Photographie',
                            'app_mobile' => 'Application Mobile'
                        ];
                        $categorie_fr = $categories[$item['categorie']] ?? 'Projet';
                        $thumb_url = strpos($item['image_url'], '/') === 0 
                            ? $item['image_url'] 
                            : "/images/" . $item['image_url'];
                        
                        $full_url = $thumb_url;
                        foreach ($all_items as $sub_item) {
                            if ($sub_item['visible'] == 0 && $sub_item['titre'] === $item['titre']) {
                                $full_url = strpos($sub_item['image_url'], '/') === 0 
                                    ? $sub_item['image_url']
                                    : "/images/" . $sub_item['image_url'];
                                break;
                            }
                        }
                ?>
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in">
                            <a href="#" class="portfolio-item-link"
                               data-bs-toggle="modal"
                               data-bs-target="#portfolioModal"
                               data-modal-title="<?= htmlspecialchars($item['titre']) ?>"
                               data-modal-full="<?= $full_url ?>"
                               data-modal-desc="<?= htmlspecialchars($item['description']) ?>"
                               data-modal-cat="<?= htmlspecialchars($categorie_fr) ?>">
                                
                                <div class="portfolio-item">
                                    <img src="<?= $thumb_url ?>" alt="<?= htmlspecialchars($item['titre']) ?>">
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-info">
                                            <h4><i class="fas fa-search-plus me-2"></i> Voir les détails</h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php } } ?>
            </div>
        </div>
    </section>

</main>

<div class="modal fade" id="portfolioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered"> 
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center position-relative">
                <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                
                <h5 class="modal-title fw-bold text-center mt-2 fs-3">Titre du Projet</h5>
                <span id="portfolioModalCategory" class="modal-category-gold text-center text-gold fw-bold">Catégorie</span>
            </div>
            <div class="modal-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-4 mb-md-0 text-center">
                        <img src="" id="portfolioModalImage" class="img-fluid rounded shadow" alt="Grand format">
                    </div>
                    <div class="col-md-4">
                        <h5 class="fw-bold mb-3 border-bottom pb-2 text-gold text-center">Description du projet</h5>
                        <p id="portfolioModalDescription" class="text-secondary lh-lg"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const portfolioModal = document.getElementById('portfolioModal');
    if (portfolioModal) {
        portfolioModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            portfolioModal.querySelector('.modal-title').textContent = button.getAttribute('data-modal-title');
            portfolioModal.querySelector('#portfolioModalCategory').textContent = button.getAttribute('data-modal-cat');
            
            // Gestion de la description
            const desc = button.getAttribute('data-modal-desc');
            portfolioModal.querySelector('#portfolioModalDescription').innerHTML = desc ? desc.replace(/\n/g, '<br>') : "Aucune description disponible.";
            
            portfolioModal.querySelector('#portfolioModalImage').src = button.getAttribute('data-modal-full');
        });
    }
});
</script>


<?php include __DIR__ . '/../includes/footer.inc.php'; ?>