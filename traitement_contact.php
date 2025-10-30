<?php
// Démarrer la session (bien que non utilisé ici, c'est une bonne pratique si vous prévoyez d'ajouter des fonctionnalités liées à la session).
session_start();

// 1. Connexion à la base de données
include 'includes/db.inc.php';

// 2. Vérifier que la requête est bien de type POST (sécurité de base).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 3. Récupérer et nettoyer les données du formulaire pour éviter les failles de sécurité.
    $nom = htmlspecialchars(trim($_POST['nom'])); // `trim` enlève les espaces, `htmlspecialchars` convertit les caractères spéciaux.
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); // `filter_var` avec `FILTER_SANITIZE_EMAIL` nettoie l'email.
    $telephone = htmlspecialchars(trim($_POST['telephone'])); // Même nettoyage pour le téléphone.
    $service = htmlspecialchars(trim($_POST['service']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Validation
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom est requis";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide";
    }
    
    if (empty($telephone)) {
        $errors[] = "Le téléphone est requis";
    }
    
    if (empty($service)) {
        $errors[] = "Veuillez sélectionner un service";
    }
    
    if (empty($message)) {
        $errors[] = "Le message est requis";
    }
    
    // 5. Si aucune erreur de validation n'est trouvée, on procède à l'insertion.
    if (empty($errors)) {
        try {
            // Requête SQL préparée pour insérer les données en toute sécurité.
            $sql = "INSERT INTO contacts (nom, email, telephone, service, message, date_creation) 
                    VALUES (:nom, :email, :telephone, :service, :message, NOW())";
            
            $stmt = $pdo->prepare($sql);
            // Exécution de la requête avec les données nettoyées.
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':telephone' => $telephone,
                ':service' => $service,
                ':message' => $message
            ]);
            
            // 6. Envoyer un email de notification à l'administrateur avec PHPMailer.
            require_once 'includes/mail.config.php';
            $mail = getMailer();

            // Destinataires
            $mail->setFrom('noreply@oleris.com', 'Oleris Site Web');
            $mail->addAddress('dylan.hblt03@gmail.com', 'Dylan H.'); // L'admin
            $mail->addReplyTo($email, $nom);

            // Contenu
            $mail->isHTML(false); // Email en format texte
            $mail->Subject = 'Nouvelle demande de contact - Oleris';
            $mail->Body    = "Nouvelle demande de contact reçue :\n\n" .
                             "Nom : $nom\n" .
                             "Email : $email\n" .
                             "Téléphone : $telephone\n" .
                             "Service : $service\n\n" .
                             "Message :\n$message";
            
            $mail->send();
            
            // 7. Réponse JSON de succès pour le script AJAX côté client.
            echo json_encode([
                'success' => true, 
                'message' => 'Votre demande a été envoyée avec succès !'
            ]);
            
        } catch(PDOException $e) {
            // En cas d'erreur avec la base de données, on renvoie une erreur.
            // Idéalement, en production, on ne montrerait pas $e->getMessage() à l'utilisateur.
            echo json_encode([
                'success' => false, 
                'message' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()
            ]);
        }
        
    } else {
        // 8. S'il y a des erreurs de validation, on les renvoie au format JSON.
        echo json_encode([
            'success' => false, 
            'message' => implode(', ', $errors)
        ]);
    }
    
} else {
    // 9. Si la méthode n'est pas POST, on renvoie une erreur.
    echo json_encode([
        'success' => false, 
        'message' => 'Méthode non autorisée'
    ]);
}
?>