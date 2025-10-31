<?php
// Démarre ou reprend une session existante.
session_start();
// Inclut le fichier de connexion à la base de données.
include 'includes/db.inc.php';

// Initialise les variables pour les messages d'erreur ou de succès.
$error_message = '';
$success_message = '';

// Vérifie si le formulaire a été soumis via la méthode POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // --- Validation des données ---
    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        $error_message = 'Tous les champs sont obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'L\'adresse email n\'est pas valide.';
    } elseif ($password !== $password_confirm) {
        $error_message = 'Les mots de passe ne correspondent pas.';
    } elseif (strlen($password) < 8) {
        $error_message = 'Le mot de passe doit contenir au moins 8 caractères.';
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM clients WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $error_message = 'Cette adresse email est déjà utilisée.';
        } else {
            // Hacher le mot de passe pour le stocker de manière sécurisée
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer le nouvel utilisateur dans la base de données
            $sql = "INSERT INTO clients (nom, prenom, email, mot_de_passe, date_inscription) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$nom, $prenom, $email, $hashed_password])) {
                // Rediriger vers la page de connexion avec un message de succès
                $_SESSION['success_message'] = 'Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter.';
                header('Location: login.php');
                exit;
            } else {
                $error_message = 'Une erreur est survenue lors de la création de votre compte.';
            }
        }
    }
}

// Inclut l'en-tête de la page.
include 'includes/header.inc.php';
?>
<main class="main-content-wrapper" style="padding: 150px 0;">
    <section class="contact-section" id="register">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <h2 class="section-title text-white">Inscription</h2>
                        <p class="section-subtitle text-white-50">Créez votre compte client.</p>
                    </div>
                    <div class="contact-form">
                        <?php if ($error_message): ?><div class="alert alert-danger"><?php echo $error_message; ?></div><?php endif; ?>
                        <form action="register.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3"><label class="form-label">Prénom</label><input type="text" name="prenom" class="form-control" required></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                            </div>
                            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                            <div class="mb-3"><label class="form-label">Mot de passe (8 caractères min.)</label><input type="password" name="password" class="form-control" required></div>
                            <div class="mb-4"><label class="form-label">Confirmer le mot de passe</label><input type="password" name="password_confirm" class="form-control" required></div>
                            <div class="text-center"><button type="submit" class="btn btn-gold btn-lg">S'inscrire</button></div>
                        </form>
                        <div class="text-center mt-4"><p class="text-white-50">Déjà un compte ? <a href="login.php">Connectez-vous</a></p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include 'includes/footer.inc.php'; ?>