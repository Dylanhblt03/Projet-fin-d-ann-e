<?php
// Fichier: includes/mail.config.php
// Configuration pour l'envoi d'e-mails avec PHPMailer

// 1. Inclure les fichiers nécessaires de la bibliothèque PHPMailer.
require_once __DIR__ . '/PHPMailer.php';
require_once __DIR__ . '/SMTP.php';
require_once __DIR__ . '/Exception.php';

// 2. Importer les classes PHPMailer dans l'espace de noms global.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// 3. Définir une fonction qui retourne une instance de PHPMailer pré-configurée.
//    Cela évite de répéter la configuration dans chaque script qui envoie un e-mail.
function getMailer() {
    $mail = new PHPMailer(true); // `true` active les exceptions en cas d'erreur.

    // Paramètres du serveur SMTP (ici, configuré pour Gmail).
    $mail->isSMTP();                                    // Utiliser le protocole SMTP.
    $mail->Host       = 'smtp.gmail.com';               // Le serveur SMTP de Gmail.
    $mail->SMTPAuth   = true;                           // Activer l'authentification SMTP.
    $mail->Username   = 'dylan.hblt03@gmail.com';       // Votre adresse e-mail Gmail.
    $mail->Password   = 'okroqcwpyikemlfp';             // IMPORTANT: C'est un mot de passe d'application, pas votre mot de passe Gmail.
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     // Activer le chiffrement SSL/TLS implicite.
    $mail->Port       = 465;                            // Le port TCP pour se connecter (465 pour SMTPS).
    $mail->CharSet    = 'UTF-8';                        // Définir le jeu de caractères pour les e-mails.

    return $mail;
}
