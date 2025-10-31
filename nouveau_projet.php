<?php
session_start();

// Sécurité : vérifie si l'utilisateur est bien un client connecté.
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
    header('Location: login.php');
    exit;
}

include 'includes/db.inc.php';

$error_message = '';
$success_message = '';
$client_id = $_SESSION['user_id'];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $type_projet = trim($_POST['type_projet'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($titre) || empty($type_projet) || empty($description)) {
        $error_message = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            $sql = "INSERT INTO projets (client_id, titre, description, type_projet, statut, date_creation) 
                    VALUES (?, ?, ?, ?, 'demande_initiale', NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$client_id, $titre, $description, $type_projet]);

            // Envoyer un email à l'admin
            require_once 'includes/mail.config.php';
            $mail = getMailer();
            $mail->setFrom('noreply@oleris.com', 'Oleris Projets');
            $mail->addAddress('dylan.hblt03@gmail.com', 'Dylan H.');
            $mail->Subject = 'Nouvelle demande de projet client';
            $mail->Body    = "Une nouvelle demande de projet a été soumise par un client.\n\n" .
                             "Titre : $titre\n" .
                             "Type : $type_projet\n" .
                             "Description : \n$description\n\n" .
                             "Veuillez vous connecter à l'espace admin pour la consulter.";
            $mail->send();

            $_SESSION['success_message_profil'] = 'Votre demande de projet a bien été envoyée ! Nous reviendrons vers vous rapidement.';
            header('Location: profil.php');
            exit;

        } catch (Exception $e) {
            $error_message = 'Une erreur est survenue. Veuillez réessayer. ' . $e->getMessage();
        }
    }
}

// Récupérer les services pour le menu déroulant
$stmt_services = $pdo->query("SELECT nom FROM services WHERE actif = 1 ORDER BY ordre_affichage");
$services_list = $stmt_services->fetchAll();

include 'includes/header.inc.php';
?>
<main class="main-content-wrapper" style="padding: 150px 0;">
    <section class="contact-section" id="new-project">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center">
                        <h2 class="section-title text-white">Démarrer un nouveau projet</h2>
                        <p class="section-subtitle text-white-50">Décrivez-nous votre idée et nous la concrétiserons.</p>
                    </div>
                    <div class="contact-form">
                        <?php if ($error_message): ?><div class="alert alert-danger"><?php echo $error_message; ?></div><?php endif; ?>
                        <form action="nouveau_projet.php" method="POST">
                            <div class="mb-3"><label class="form-label">Nom du projet</label><input type="text" name="titre" class="form-control" placeholder="Ex: Refonte de mon site e-commerce" required></div>
                            <div class="mb-3"><label class="form-label">Type de projet</label><select name="type_projet" class="form-select" required><option value="">Sélectionnez un type</option><?php foreach ($services_list as $service): ?><option value="<?php echo htmlspecialchars($service['nom']); ?>"><?php echo htmlspecialchars($service['nom']); ?></option><?php endforeach; ?><option value="Autre">Autre</option></select></div>
                            <div class="mb-4"><label class="form-label">Description de votre projet</label><textarea name="description" class="form-control" rows="6" placeholder="Décrivez vos objectifs, vos attentes, les fonctionnalités souhaitées, etc." required></textarea></div>
                            <div class="text-center"><button type="submit" class="btn btn-gold btn-lg">Envoyer ma demande</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include 'includes/footer.inc.php'; ?>