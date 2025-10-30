<?php
// ===============================================
// Fichier: chatbot_reponse.php
// Récupère la question et cherche une réponse dans la BDD
// ===============================================

// Définit le type de contenu de la réponse comme étant du JSON.
header('Content-Type: application/json');

// 1. Connexion à la Base de Données
include 'includes/db.inc.php';

// 2. Récupération de la question utilisateur
$question = trim($_POST['question'] ?? ''); // Récupère la question envoyée en POST, avec une valeur par défaut vide.
$reponse_finale = ''; // Initialise la variable qui contiendra la réponse à envoyer.

if (empty($question)) {
    echo json_encode(['reponse' => "Veuillez poser une question."]);
    exit();
}

// 3. Nettoyage et préparation de la question pour la recherche
// Sépare la question en mots-clés.
$keywords = explode(' ', strtolower($question));
$search_terms = [];
foreach ($keywords as $word) {
    // Filtre les mots trop courts ou communs pour améliorer la pertinence de la recherche.
    if (strlen($word) > 3) {
        $search_terms[] = "%" . $word . "%"; // Ajoute les '%' pour une recherche de type LIKE.
    }
}

// 4. Logique de Recherche dans la BDD
// Priorité 1 : Rechercher dans la table `services`
if (!empty($search_terms)) {
    $sql_conditions = [];
    foreach ($search_terms as $term) {
        // Recherche des mots-clés dans le nom ou la description des services
        $sql_conditions[] = "(nom LIKE ? OR description LIKE ?)"; // Crée des conditions pour la requête SQL.
    }
    
    // Requête SQL pour trouver un service correspondant aux mots-clés.
    $sql_service = "
        SELECT nom, description, prix_min 
        FROM services 
        WHERE actif = 1 AND (" . implode(' OR ', $sql_conditions) . ") 
        LIMIT 1
    ";

    // Prépare les paramètres pour la requête préparée (pour éviter les injections SQL).
    $params = [];
    foreach ($search_terms as $term) {
        $params[] = $term;
        $params[] = $term;
    }

    $stmt = $pdo->prepare($sql_service); // Prépare la requête.
    $stmt->execute($params); // Exécute la requête avec les paramètres.
    $service = $stmt->fetch(); // Récupère le premier résultat.

    if ($service) {
        // Si un service est trouvé, on construit une réponse formatée.
        $prix_indicatif = $service['prix_min'] ? " à partir de " . number_format($service['prix_min'], 0, ',', ' ') . "€" : "";
        $reponse_finale = "Absolument ! Le service **" . htmlspecialchars($service['nom']) . "** est l'une de nos expertises. Description : " . htmlspecialchars($service['description']) . " Prix indicatif" . $prix_indicatif . ". Voulez-vous [prendre rendez-vous](/prendrerdv.php) ?";
    }
}


// 5. Réponses par défaut ou génériques (Fallback)
// Si aucune réponse n'a été trouvée dans la base de données.
if (empty($reponse_finale)) {
    $lower_question = strtolower($question);

    // On utilise une structure switch(true) pour plus de lisibilité quand il y a beaucoup de conditions.
    switch (true) {
        case (str_contains($lower_question, 'bonjour') || str_contains($lower_question, 'salut')):
            $reponse_finale = "Bonjour ! Comment puis-je vous aider aujourd'hui ?";
            break;

        case (str_contains($lower_question, 'prix') || str_contains($lower_question, 'tarif') || str_contains($lower_question, 'coûte')):
        $reponse_finale = "Nos tarifs dépendent de la complexité du projet. Vous pouvez consulter la page [Services](/service.php) pour des prix indicatifs, ou [prendre rendez-vous](/prendrerdv.php) pour un devis précis.";
            break;

        case (str_contains($lower_question, 'contact') || str_contains($lower_question, 'parler') || str_contains($lower_question, 'devis') || str_contains($lower_question, 'rdv')):
        $reponse_finale = "Pour obtenir un devis ou discuter directement, vous pouvez [nous contacter ici](/contact.php) ou utiliser notre [calendrier de prise de rendez-vous](/prendrerdv.php).";
            break;

        case (str_contains($lower_question, 'délai') || str_contains($lower_question, 'temps') || str_contains($lower_question, 'durée')):
            $reponse_finale = "La durée d'un projet varie beaucoup. Un site vitrine simple peut prendre 2-4 semaines, tandis qu'un site e-commerce complexe peut nécessiter plusieurs mois. Le mieux est de [prendre rendez-vous](/prendrerdv.php) pour en discuter.";
            break;

        case (str_contains($lower_question, 'portfolio') || str_contains($lower_question, 'exemple') || str_contains($lower_question, 'réalisation')):
            $reponse_finale = "Bien sûr ! Vous pouvez consulter mes dernières réalisations sur la page d'accueil, dans la section [Portfolio](/index.php#portfolio).";
            break;

        case (str_contains($lower_question, 'qui êtes-vous') || str_contains($lower_question, 'agence')):
            $reponse_finale = "Je suis l'assistant virtuel d'Oléris, une agence web dirigée par Dylan Humblot, spécialisée dans la création de sites web sur-mesure et performants.";
            break;

        case (str_contains($lower_question, 'merci')):
            $reponse_finale = "De rien ! N'hésitez pas si vous avez d'autres questions.";
            break;

        default:
        $reponse_finale = "Désolé, je n'ai pas trouvé d'information pertinente. J'ai de l'information sur nos **services**, **prix** et comment **nous contacter**. Si votre question est complexe, veuillez [remplir le formulaire de contact](/contact.php).";
    }
}

// 6. Envoi de la réponse finale au format JSON.
echo json_encode(['reponse' => $reponse_finale]);
?>