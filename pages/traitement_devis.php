<?php
session_start();
require_once __DIR__ . '/../includes/db.inc.php';
require_once __DIR__ . '/../includes/mail.config.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /devis");
    exit();
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['flash_message'] = "Session expirée.";
    $_SESSION['flash_type'] = 'danger';
    header("Location: /devis");
    exit();
}

$nom = trim(htmlspecialchars($_POST['nom']));
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$telephone = trim(htmlspecialchars($_POST['telephone']));
$entreprise = trim(htmlspecialchars($_POST['entreprise'] ?? ''));
$service = trim(htmlspecialchars($_POST['service']));
$budget = trim(htmlspecialchars($_POST['budget'] ?? ''));
$date_souhaitee = trim(htmlspecialchars($_POST['date_souhaitee'] ?? ''));
$message = trim(htmlspecialchars($_POST['message']));

$message_complet = $message;
if (!empty($entreprise)) $message_complet .= "\n\nEntreprise: " . $entreprise;
if (!empty($budget)) $message_complet .= "\n\nBudget indicatif: " . $budget;
if (!empty($date_souhaitee)) $message_complet .= "\n\nDate souhaitée: " . $date_souhaitee;

$sql = "INSERT INTO contacts (nom, email, telephone, service, message, statut, date_creation, client_id) 
        VALUES (?, ?, ?, ?, ?, 'nouveau', NOW(), 0)";

$db_success = false;
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssss", $nom, $email, $telephone, $service, $message_complet);
    if ($stmt->execute()) {
        $db_success = true;
    }
    $stmt->close();
}

$email_success = false;
if ($db_success) {
    try {
        $mail = getMailer();

        $mail->setFrom('dylan.hblt03@gmail.com', 'Oleris Web');
        $mail->addAddress('oleris@gmail.com');
        $mail->addReplyTo($email, $nom);

        $mail->isHTML(true);
        $mail->Subject = "Nouvelle demande de devis Oleris : " . $service;
        $mail->Body = "
            <h3>Nouvelle demande de devis</h3>
            <p><strong>Nom :</strong> {$nom}</p>
            <p><strong>Email :</strong> {$email}</p>
            <p><strong>Téléphone :</strong> {$telephone}</p>
            " . (!empty($entreprise) ? "<p><strong>Entreprise :</strong> {$entreprise}</p>" : "") . "
            <p><strong>Service demandé :</strong> {$service}</p>
            " . (!empty($budget) ? "<p><strong>Budget indicatif :</strong> {$budget}</p>" : "") . "
            " . (!empty($date_souhaitee) ? "<p><strong>Date souhaitée :</strong> {$date_souhaitee}</p>" : "") . "
            <p><strong>Détails du projet :</strong><br>" . nl2br($message) . "</p>
        ";

        $mail->send();
        $email_success = true;

    } catch (Exception $e) {
        $email_success = false;
    }
}

if ($db_success) {
    if ($email_success) {
        $_SESSION['flash_message'] = "Votre demande de devis a bien été envoyée !";
        $_SESSION['flash_type'] = 'success';
    } else {
        $_SESSION['flash_message'] = "Demande enregistrée, mais l'envoi de l'email a échoué.";
        $_SESSION['flash_type'] = 'warning';
    }
} else {
    $_SESSION['flash_message'] = "Erreur technique lors de l'enregistrement.";
    $_SESSION['flash_type'] = 'danger';
}

header("Location: /devis#devis");
exit();
?>