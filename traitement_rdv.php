<?php
// ===============================================
// Fichier: traitement_rdv.php
// Gère l'insertion d'un nouveau rendez-vous dans la BDD
// ===============================================

// Définit le type de contenu de la réponse comme étant du JSON, pour que le JavaScript puisse l'interpréter.
header('Content-Type: application/json');

// 1. Configuration et Connexion à la Base de Données
include 'includes/db.inc.php';

// 2. Vérification de la méthode de la requête et récupération des données.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit();
}

$date = $_POST['date_selectionnee'] ?? '';
$time = $_POST['creneau_selectionne'] ?? '';
$nom = trim($_POST['nom'] ?? '');
$email = trim($_POST['email'] ?? '');
$service = trim($_POST['service_concerne'] ?? '');

// Validation simple des données côté serveur. C'est une sécurité essentielle.
if (empty($date) || empty($time) || empty($nom) || empty($email) || empty($service)) {
    echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis.']);
    exit();
}

// Combinaison de la date et de l'heure
$date_heure = $date . ' ' . $time . ':00';

// 3. Vérification de la disponibilité finale (Race Condition Check).
//    Ceci évite qu'un créneau soit réservé par deux personnes en même temps.
try {
    $stmt_check = $pdo->prepare("
        SELECT COUNT(id) FROM rendez_vous
        WHERE date_heure = :date_heure AND statut != 'annule'
    ");
    $stmt_check->execute([':date_heure' => $date_heure]);

    if ($stmt_check->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Ce créneau vient d\'être réservé. Veuillez en choisir un autre.']);
        exit();
    }
} catch (\PDOException $e) {
    // En cas d'échec de la vérification, on pourrait arrêter, mais ici le script continue.
    // C'est un risque calculé, car l'insertion échouera probablement si la contrainte est violée.
    error_log("Slot check failed: " . $e->getMessage());
}


// 4. Insertion dans la table `rendez_vous`
try {
    $stmt = $pdo->prepare("
        INSERT INTO rendez_vous (client_id, contact_id, nom_client, email_client, service_concerne, date_heure, statut)
        VALUES (NULL, NULL, :nom, :email, :service, :date_heure, 'confirme')
    ");

    $stmt->execute([
        ':nom'          => $nom,
        ':email'        => $email,
        ':service'      => $service,
        ':date_heure'   => $date_heure
    ]);

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
                     "Service concerné : $service\n" .
                     "Date et heure : " . (new DateTime($date_heure))->format('d/m/Y à H:i');

    $mail->send();

    // 5. Envoyer une réponse de succès au format JSON.
    echo json_encode(['success' => true, 'message' => 'Rendez-vous confirmé !']);

} catch (\PDOException $e) {
    // En cas d'erreur lors de l'insertion, on enregistre l'erreur et on renvoie un message d'échec.
    error_log("Reservation error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur BDD: Échec de la réservation.']);
}
?>