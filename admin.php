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
    $image_url = $_POST['image_url'] ?? ''; // Récupère l'URL de l'image.
    $categorie = $_POST['categorie'] ?? 'site_web'; // Récupère la catégorie.

    // Valide que les champs essentiels ne sont pas vides.
    if (!empty($titre) && !empty($description) && !empty($image_url)) {
        // Prépare et exécute la requête d'insertion dans la base de données.
        $sql = "INSERT INTO portfolio (titre, description, categorie, image_url, visible, ordre_affichage) VALUES (?, ?, ?, ?, 1, 99)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $description, $categorie, $image_url]);
        $message = '<div class="alert alert-success">Projet ajouté avec succès !</div>';
    } else {
        $message = '<div class="alert alert-danger">Tous les champs sont requis.</div>';
    }
}

// Récupère la liste de tous les projets du portfolio pour les afficher.
$projets_portfolio = $pdo->query("SELECT * FROM portfolio ORDER BY ordre_affichage DESC")->fetchAll();

// Inclut l'en-tête de la page.
include 'includes/header.inc.php';
?>
<main class="main-content-wrapper" style="padding: 150px 0; background: var(--grey-light);">
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
                <form action="admin.php" method="POST">
                    <input type="hidden" name="add_portfolio" value="1">
                    <div class="mb-3"><label class="form-label">Titre du projet</label><input type="text" name="titre" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">URL de l'image</label><input type="text" name="image_url" class="form-control" placeholder="https://images.unsplash.com/..." required></div>
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
            <div class="card-header"><h2 class="h5 mb-0">Projets existants</h2></div>
            <ul class="list-group list-group-flush">
                <!-- Boucle pour afficher chaque projet existant dans une liste. -->
                <?php foreach ($projets_portfolio as $projet): ?>
                    <li class="list-group-item"><?php echo htmlspecialchars($projet['titre']); // Utilise htmlspecialchars pour la sécurité. ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</main>
<?php include 'includes/footer.inc.php'; // Inclut le pied de page. ?>