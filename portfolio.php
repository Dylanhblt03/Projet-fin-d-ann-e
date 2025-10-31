<?php
// 1. Inclure la connexion à la base de données.
include 'includes/db.inc.php';

// 2. Récupérer TOUS les projets visibles pour la page portfolio.
$stmt_portfolio = $pdo->query("SELECT * FROM portfolio WHERE visible = 1 ORDER BY ordre_affichage, date_realisation DESC");
$portfolio_items = $stmt_portfolio->fetchAll();

// 3. Inclure l'en-tête de la page.
include 'includes/header.inc.php';
?>

<main class="main-content-wrapper" style="padding-top: 120px;">

    <!-- En-tête de la page Portfolio -->
    <section class="hero-section section-padding" style="background-color: var(--grey-dark);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-up">
                    <h1 class="display-3 text-white mb-3">Notre Portfolio</h1>
                    <p class="lead text-white-50">Découvrez une sélection de nos projets et réalisations.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Grille du Portfolio -->
    <section class="portfolio-section section-padding" id="portfolio-grid">
        <div class="container">
            <div class="row">
                <?php if (empty($portfolio_items)): ?>
                    <div class="col-12 text-center">
                        <p class="text-muted fs-4">Aucun projet à afficher pour le moment. Revenez bientôt !</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($portfolio_items as $item):
                        // Traduction de la catégorie du projet pour l'affichage.
                        $categories = [
                            'site_web' => 'Développement Web',
                            'design' => 'Design & Branding',
                            'photo' => 'Photographie',
                            'autre' => 'Création'
                        ];
                        $categorie_fr = $categories[$item['categorie']] ?? 'Projet';
                        $media_url = htmlspecialchars($item['image_url']);
                        $media_ext = strtolower(pathinfo($media_url, PATHINFO_EXTENSION));
                        $is_video = in_array($media_ext, ['mp4', 'webm']);
                    ?>
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in">
                            <a href="#" class="portfolio-item-link"
                               data-bs-toggle="modal"
                               data-bs-target="#portfolioModal"
                               data-modal-title="<?php echo htmlspecialchars($item['titre']); ?>"
                               data-modal-media="<?php echo $media_url; ?>"
                               data-modal-type="<?php echo $is_video ? 'video' : 'image'; ?>"
                               data-modal-desc="<?php echo htmlspecialchars($item['description']); ?>"
                               data-modal-cat="<?php echo htmlspecialchars($categorie_fr); ?>">
                                <div class="portfolio-item">
                                    <?php if ($is_video): ?>
                                        <video src="<?php echo $media_url; ?>" autoplay loop muted playsinline></video>
                                    <?php else: ?>
                                        <img src="<?php echo $media_url; ?>" alt="<?php echo htmlspecialchars($item['titre']); ?>">
                                    <?php endif; ?>
                                    <!-- Superposition (overlay) qui apparaît au survol -->
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-info">
                                            <h4><i class="fas fa-search-plus me-2"></i> Voir les détails</h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

</main>

<!-- Modale pour afficher les détails du projet -->
<div class="modal fade" id="portfolioModal" tabindex="-1" aria-labelledby="portfolioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="portfolioModalLabel">Titre du Projet</h5>
                    <span class="badge bg-gold" id="portfolioModalCategory">Catégorie</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7 mb-3 mb-md-0">
                        <!-- Conteneurs pour l'image et la vidéo -->
                        <img src="" id="portfolioModalImage" class="img-fluid rounded" alt="Image du projet" style="display: none;">
                        <video src="" id="portfolioModalVideo" class="img-fluid rounded" controls style="display: none;"></video>
                    </div>
                    <div class="col-md-5">
                        <p id="portfolioModalDescription" class="text-dark"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var portfolioModal = document.getElementById('portfolioModal');
    portfolioModal.addEventListener('show.bs.modal', function (event) {
        // Bouton qui a déclenché la modale
        var button = event.relatedTarget;

        // Extraction des informations des attributs data-*
        const title = button.getAttribute('data-modal-title');
        const media = button.getAttribute('data-modal-media');
        const type = button.getAttribute('data-modal-type');
        const description = button.getAttribute('data-modal-desc');
        const category = button.getAttribute('data-modal-cat');

        // Sélection des éléments de la modale
        const modalTitle = portfolioModal.querySelector('.modal-title');
        const modalImage = portfolioModal.querySelector('#portfolioModalImage');
        const modalVideo = portfolioModal.querySelector('#portfolioModalVideo');
        const modalDescription = portfolioModal.querySelector('#portfolioModalDescription');
        const modalCategory = portfolioModal.querySelector('#portfolioModalCategory');

        // Mise à jour du contenu de la modale
        modalTitle.textContent = title;
        modalDescription.innerHTML = description.replace(/\n/g, '<br>');
        modalCategory.textContent = category;

        if (type === 'video') {
            modalVideo.src = media;
            modalVideo.style.display = 'block';
            modalImage.style.display = 'none';
        } else {
            modalImage.src = media;
            modalImage.style.display = 'block';
            modalVideo.style.display = 'none';
        }
    });
});
</script>

<?php include 'includes/footer.inc.php'; ?>