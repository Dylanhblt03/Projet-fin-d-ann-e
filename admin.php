<?php
// Démarre la session pour accéder aux variables de session comme l'identifiant de l'utilisateur.
session_start();

// Sécurité : vérifie si l'utilisateur est connecté et s'il a bien le rôle 'admin'.
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php'); // Redirige vers la page de connexion si non autorisé.
    exit; // Arrête le script.
}

// Inclut la connexion à la base de données.
include 'includes/db.inc.php';

// Initialise une variable pour les messages de statut (succès, erreur).
$message = '';

// Traitement du formulaire d'ajout d'un projet au portfolio.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_portfolio'])) {
    $titre = $_POST['titre'] ?? ''; // Récupère le titre du projet.
    $description = $_POST['description'] ?? ''; // Récupère la description.
    $categorie = $_POST['categorie'] ?? 'site_web'; // Récupère la catégorie.
    $image_path_for_db = null;

    // --- Gestion de l'upload de l'image ---
    if (isset($_FILES['portfolio_media']) && $_FILES['portfolio_media']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/portfolio/';
        // Crée le dossier s'il n'existe pas
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_tmp_name = $_FILES['portfolio_media']['tmp_name'];
        $file_name = basename($_FILES['portfolio_media']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm'];

        // Validation du fichier
        if (in_array($file_ext, $allowed_ext)) {
            if ($_FILES['portfolio_media']['size'] < 50000000) { // 50MB max
                // Crée un nom de fichier unique pour éviter les conflits
                $new_file_name = uniqid('', true) . '.' . $file_ext;
                $destination = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp_name, $destination)) {
                    $image_path_for_db = '/' . $destination; // Chemin à stocker en BDD
                } else {
                    $message = '<div class="alert alert-danger">Erreur lors du déplacement du fichier.</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Le fichier est trop volumineux (50MB maximum).</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Type de fichier non autorisé. (jpg, png, webp, mp4, webm)</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Veuillez sélectionner une image ou une vidéo.</div>';
    }

    // Si l'image a bien été uploadée et que les autres champs sont remplis
    if ($image_path_for_db && !empty($titre) && !empty($description)) {
        try {
            $sql = "INSERT INTO portfolio (titre, description, categorie, image_url, visible, ordre_affichage) VALUES (?, ?, ?, ?, 1, 99)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $description, $categorie, $image_path_for_db]);
            $message = '<div class="alert alert-success">Projet ajouté avec succès !</div>';
        } catch (PDOException $e) {
            $message = '<div class="alert alert-danger">Erreur de base de données: ' . $e->getMessage() . '</div>';
        }
    } elseif (empty($message)) { // Affiche une erreur générale si aucune autre erreur n'a été définie
        $message = '<div class="alert alert-danger">Tous les champs sont requis.</div>';
    }
}

// Traitement de la suppression d'un projet
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_portfolio'])) {
    $id_to_delete = $_POST['id_projet'] ?? 0;
    // On pourrait aussi supprimer le fichier image du serveur ici
    $sql = "DELETE FROM portfolio WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$id_to_delete])) {
        $message = '<div class="alert alert-warning">Projet supprimé avec succès.</div>';
    } else {
        $message = '<div class="alert alert-danger">Erreur lors de la suppression du projet.</div>';
    }
}

// Récupère la liste de tous les projets du portfolio pour les afficher.
$projets_portfolio = $pdo->query("SELECT * FROM portfolio ORDER BY ordre_affichage DESC")->fetchAll();

// Inclut l'en-tête de la page.
include 'includes/header.inc.php';
?>
<main class="main-content-wrapper" style="padding: 150px 0; background: var(--grey-light);">
    <style>
        /* Styles pour le cadre de l'écran d'ordinateur */
        .screen-mockup {
            position: relative;
            width: 100%;
            max-width: 450px; /* Taille maximale du cadre */
            margin: 0 auto;
        }
        .screen-mockup img.frame {
            width: 100%;
            height: auto;
        }
        .screen-mockup .project-image-container {
            position: absolute;
            /* Ces valeurs dépendent de l'image du cadre. Ajustez-les pour que l'image s'insère parfaitement. */
            top: 6.5%;
            left: 13.5%;
            width: 73%;
            height: 77%;
            overflow: hidden;
        }
        .screen-mockup .project-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Assure que l'image remplit le conteneur */
            object-position: top center; /* Commence par afficher le haut de l'image */
        }
        .project-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        /* Correction pour les formulaires sur fond clair */
        .card .form-control,
        .card .form-select {
            color: #212529; /* Couleur de texte par défaut de Bootstrap (noir) */
            background-color: #fff; /* Fond blanc par défaut */
        }
        .card .form-select option {
            color: #212529;
        }
    </style>
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title">Espace Administrateur</h1>
            <p class="section-subtitle">Gérer le contenu du site.</p>
        </div>

        <!-- Formulaire d'ajout au portfolio -->
        <div class="card mb-5">
            <div class="card-header"><h2 class="h5 mb-0">Ajouter un projet au Portfolio</h2></div>
            <div class="card-body">
                <!-- Affiche le message de succès ou d'erreur après la soumission du formulaire. -->
                <?php echo $message; ?>
                <form action="admin.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="add_portfolio" value="1">
                    <div class="mb-3"><label class="form-label">Titre du projet</label><input type="text" name="titre" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Image ou Vidéo du projet</label><input type="file" name="portfolio_media" class="form-control" accept="image/*,video/mp4,video/webm" required></div>
                    <div class="mb-3"><label class="form-label">Catégorie</label>
                        <select name="categorie" class="form-select">
                            <option value="site_web">Développement Web</option>
                            <option value="design">Design & Branding</option>
                            <option value="photo">Photographie</option>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3" required></textarea></div>
                    <button type="submit" class="btn btn-gold">Ajouter le projet</button>
                </form>
            </div>
        </div>

        <!-- Liste des projets actuels -->
        <div class="card">
            <div class="card-header"><h2 class="h5 mb-0">Gérer les projets existants</h2></div>
            <div class="card-body">
                <?php if (empty($projets_portfolio)): ?>
                    <p class="text-center text-muted">Aucun projet dans le portfolio pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($projets_portfolio as $projet): ?>
                        <?php
                            $media_url = htmlspecialchars($projet['image_url']);
                            $media_ext = strtolower(pathinfo($media_url, PATHINFO_EXTENSION));
                            $is_video = in_array($media_ext, ['mp4', 'webm']);
                        ?>
                        <div class="row mb-5 border-bottom pb-4">
                            <!-- Colonne de gauche : Mockup écran -->
                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <div class="screen-mockup">
                                    <!-- Image du cadre de l'écran -->
                                    <img src="/images/screen-frame.png" alt="Cadre d'écran" class="frame">
                                    <!-- Conteneur pour l'image ou la vidéo du projet -->
                                    <div class="project-image-container">
                                        <?php if ($is_video): ?>
                                            <video src="<?php echo $media_url; ?>" class="project-image" autoplay loop muted playsinline></video>
                                        <?php else: ?>
                                            <img src="<?php echo $media_url; ?>" alt="<?php echo htmlspecialchars($projet['titre']); ?>" class="project-image">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Colonne de droite : Titre, description et actions -->
                            <div class="col-lg-6 project-details">
                                <h3><?php echo htmlspecialchars($projet['titre']); ?></h3>
                                <p class="text-muted"><?php echo nl2br(htmlspecialchars($projet['description'])); ?></p>
                                <form action="admin.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">
                                    <input type="hidden" name="delete_portfolio" value="1">
                                    <input type="hidden" name="id_projet" value="<?php echo $projet['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash me-1"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.inc.php'; // Inclut le pied de page. ?>