<?php
// Démarre ou reprend une session existante. C'est essentiel pour gérer les informations de l'utilisateur connecté.
session_start();
// Inclut le fichier de connexion à la base de données.
include 'includes/db.inc.php';

// Initialise une variable pour stocker les messages d'erreur.
$error_message = '';
$success_message = '';

// Récupère et affiche un message de succès depuis la session (par ex. après une inscription)
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Supprime le message pour ne pas l'afficher à nouveau
}

// Vérifie si le formulaire a été soumis via la méthode POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? ''; // Récupère l'email ou l'identifiant.
    $password = $_POST['password'] ?? ''; // Récupère le mot de passe.

    // --- Logique de connexion pour l'administrateur (méthode simple) ---
    // Cette méthode est moins sécurisée mais plus directe pour le développement.
    if ($email === 'Dylan' && $password === 'dylan456') {
        $_SESSION['user_id'] = 'admin_id'; // Un identifiant simple pour la session admin
        $_SESSION['user_role'] = 'admin';
        $_SESSION['user_name'] = 'Dylan'; // Le nom à afficher
        header('Location: admin.php');
        exit;
    }

    // --- Logique de connexion pour les clients (depuis la table `clients`) ---
    // Si la connexion admin a échoué, on essaie de connecter un client.
    // Cette section devrait interroger la base de données pour vérifier les identifiants d'un client.
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE email = ?");
    $stmt->execute([$email]);
    $client = $stmt->fetch();
    // La fonction password_verify est la méthode sécurisée pour vérifier un mot de passe haché.
    if ($client && password_verify($password, $client['mot_de_passe']) && $client['statut_compte'] === 'actif') {
        $_SESSION['user_id'] = $client['id'];
        $_SESSION['user_role'] = 'client';
        $_SESSION['user_name'] = $client['prenom']; // Stocke le prénom du client
        header('Location: profil.php');
        exit;
    }

    // Si les identifiants ne correspondent à aucun utilisateur, on définit un message d'erreur.
    $error_message = 'Identifiants incorrects.';
}

// Inclut l'en-tête de la page.
include 'includes/header.inc.php';
?>
<main class="main-content-wrapper" style="padding: 150px 0;">
    <section class="contact-section" id="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <h2 class="section-title text-white">Connexion</h2>
                        <p class="section-subtitle text-white-50">Accédez à votre espace personnel.</p>
                    </div>
                    <div class="contact-form">
                        <!-- Affiche le message d'erreur s'il y en a un. -->
                        <?php if ($error_message): ?><div class="alert alert-danger"><?php echo $error_message; ?></div><?php endif; ?>
                        <!-- Affiche le message de succès s'il y en a un. -->
                        <?php if ($success_message): ?><div class="alert alert-success"><?php echo $success_message; ?></div><?php endif; ?>

                        <form action="login.php" method="POST">
                            <div class="mb-3"><label class="form-label">Email ou Identifiant</label><input type="text" name="email" class="form-control" required></div>
                            <div class="mb-4"><label class="form-label">Mot de passe</label><input type="password" name="password" class="form-control" required></div>
                            <div class="text-center"><button type="submit" class="btn btn-gold btn-lg">Se connecter</button></div>
                        </form>
                        <div class="text-center mt-4">
                            <p class="text-white-50">Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include 'includes/footer.inc.php'; // Inclut le pied de page. ?>