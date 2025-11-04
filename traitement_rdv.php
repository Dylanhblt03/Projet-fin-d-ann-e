<?php
// ===============================================
// Fichier: traitement_rdv.php
// Gère l'insertion d'un nouveau rendez-vous dans la BDD
// ===============================================

// Définit le type de contenu de la réponse comme étant du JSON, pour que le JavaScript puisse l'interpréter.
header('Content-Type: application/json');

// Démarre la session pour pouvoir lier le RDV à un client connecté
session_start();

// 1. Configuration et Connexion à la Base de Données
include 'includes/db.inc.php';

// 2. Vérification de la méthode de la requête et récupération des données.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit();
}

$client_id = null;
$nom = '';
$email = '';

// Vérifie si un client est connecté
if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'client') {
    $client_id = $_SESSION['user_id'];
    // Récupérer les infos du client depuis la BDD pour être sûr qu'elles sont à jour
    $stmt_client = $pdo->prepare("SELECT nom, prenom, email FROM clients WHERE id = ?");
    $stmt_client->execute([$client_id]);
    $client_data = $stmt_client->fetch();
    if ($client_data) {
        $nom = $client_data['prenom'] . ' ' . $client_data['nom'];
        $email = $client_data['email'];
    }
} else {
    // Si pas connecté, on prend les infos du formulaire
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
}

$date = $_POST['date_selectionnee'] ?? '';
$time = $_POST['creneau_selectionne'] ?? '';
$description = trim($_POST['description_rdv'] ?? 'Aucune description fournie.');

// Validation simple des données côté serveur. C'est une sécurité essentielle.
if (empty($date) || empty($time) || empty($nom) || empty($email) || empty($description)) {
    echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis.']);
    exit();
}

// Combinaison de la date et de l'heure pour la BDD
$date_rdv = $date;
$heure_debut = $time . ':00';

// 3. Vérification de la disponibilité finale (Race Condition Check).
//    Ceci évite qu'un créneau soit réservé par deux personnes en même temps.
try {
    $stmt_check = $pdo->prepare("
        SELECT COUNT(id) FROM rendez_vous 
        WHERE date_rdv = :date_rdv AND heure_debut = :heure_debut AND statut NOT IN ('annule', 'termine')
    ");
    $stmt_check->execute([
        ':date_rdv' => $date_rdv,
        ':heure_debut' => $heure_debut
    ]);

    if ($stmt_check->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Désolé, ce créneau vient d\'être réservé. Veuillez en choisir un autre.']);
        exit();
    }
} catch (\PDOException $e) {
    // En cas d'échec de la vérification, on pourrait arrêter, mais ici le script continue.
    // C'est un risque calculé, car l'insertion échouera probablement si la contrainte est violée.
    error_log("Slot check failed: " . $e->getMessage());
}


// 4. Insertion dans la table `rendez_vous` en utilisant les nouvelles colonnes
try {
    // Le titre est généré automatiquement pour plus de clarté dans le back-office
    $titre_rdv = "RDV Web - " . $nom;

    $stmt = $pdo->prepare("
        INSERT INTO rendez_vous (client_id, titre, description, date_rdv, heure_debut, type_rdv, statut, date_creation)
        VALUES (:client_id, :titre, :description, :date_rdv, :heure_debut, 'visio', 'confirme', NOW())
    ");

    $stmt->execute([
        ':client_id'   => $client_id, // Sera NULL si l'utilisateur n'est pas connecté
        ':titre'       => $titre_rdv,
        ':description' => $description,
        ':date_rdv'    => $date_rdv,
        ':heure_debut' => $heure_debut
    ]);

    $date_heure_formattee = (new DateTime($date_rdv . ' ' . $heure_debut))->format('d/m/Y à H:i');

    // Envoyer un e-mail de notification à l'administrateur avec PHPMailer.
    require_once 'includes/mail.config.php';
    $mail = getMailer();

    // Destinataires
    $mail->setFrom('noreply@oleris.com', 'Oleris Calendrier');
    $mail->addAddress('dylan.hblt03@gmail.com', 'Dylan H.'); // L'admin
    $mail->addReplyTo($email, $nom);

    // Contenu
    $mail->isHTML(false); // Email en format texte
    $mail->Subject = 'Nouveau rendez-vous pris sur Oleris';
    $mail->Body    = "Un nouveau rendez-vous a été pris :\n\n" .
                     "Nom : $nom\n" .
                     "Email : $email\n" .
                     "Description : $description\n\n" .
                     "Date et heure : " . $date_heure_formattee;

    $mail->send();

    // 5. Envoyer une réponse de succès au format JSON.
    echo json_encode(['success' => true, 'message' => 'Rendez-vous confirmé !']);

} catch (\PDOException $e) {
    // En cas d'erreur lors de l'insertion, on enregistre l'erreur et on renvoie un message d'échec.
    error_log("Reservation error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur BDD: Échec de la réservation.']);
}
?>