<?php
session_start();
require_once __DIR__ . '/includes/db.inc.php';
require_once __DIR__ . '/includes/mail.config.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: pages/contact.php");
    exit();
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode(['success' => false, 'message' => 'Session expirée.']);
        exit();
    } else {
        die("Session expirée.");
    }
}

$nom = trim(htmlspecialchars($_POST['nom']));
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$telephone = trim(htmlspecialchars($_POST['telephone']));
$service = trim(htmlspecialchars($_POST['service']));
$message = trim(htmlspecialchars($_POST['message']));


$sql = "INSERT INTO contacts (nom, email, telephone, service, message, statut, date_creation, client_id) 
        VALUES (?, ?, ?, ?, ?, 'nouveau', NOW(), 0)";

$db_success = false;
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("sssss", $nom, $email, $telephone, $service, $message);
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

        // Contenu du mail
        $mail->isHTML(true);
        $mail->Subject = "Nouveau contact Oleris : " . $service;
        $mail->Body    = "
            <h3>Nouveau message de contact</h3>
            <p><strong>Nom :</strong> {$nom}</p>
            <p><strong>Email :</strong> {$email}</p>
            <p><strong>Téléphone :</strong> {$telephone}</p>
            <p><strong>Service demandé :</strong> {$service}</p>
            <p><strong>Message :</strong><br>" . nl2br($message) . "</p>
        ";

        $mail->send();
        $email_success = true;
    } catch (Exception $e) {
        $email_success = false;
    }
}

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($db_success) {
        if ($email_success) {
            echo json_encode(['success' => true, 'message' => 'Votre demande a bien été envoyée !']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Demande enregistrée, mais l\'envoi de l\'email a échoué.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur technique lors de l\'enregistrement.']);
    }
} else {
    if ($db_success) {
        if ($email_success) {
            $_SESSION['flash_message'] = "Votre demande a bien été envoyée !";
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = "Demande enregistrée, mais l'envoi de l'email a échoué.";
            $_SESSION['flash_type'] = 'warning';
        }
    } else {
        $_SESSION['flash_message'] = "Erreur technique lors de l'enregistrement en base de données.";
        $_SESSION['flash_type'] = 'danger';
    }
    header("Location: pages/contact.php#contact");
    exit();
}
