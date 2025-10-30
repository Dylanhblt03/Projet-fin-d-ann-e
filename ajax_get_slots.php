<?php
// ===============================================
// Fichier: ajax_get_slots.php
// Récupère les créneaux horaires réservés pour une date donnée
// ===============================================

// Définit le type de contenu de la réponse comme étant du JSON.
header('Content-Type: application/json');

// 1. Configuration et Connexion à la Base de Données
include 'includes/db.inc.php';

// 2. Récupération et validation de la date passée en paramètre GET.
$date = $_GET['date'] ?? ''; // Récupère la date depuis l'URL (ex: ?date=2024-12-25).

// Vérifie que la date a le bon format (YYYY-MM-DD) pour éviter les erreurs et les injections.
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode(['error' => 'Invalid date format']);
    exit();
}

// 3. Récupération des créneaux réservés
$reserved_slots = []; // Initialise un tableau pour stocker les créneaux trouvés.
try {
    // Prépare une requête pour sélectionner uniquement l'heure (au format HH:MM) des rendez-vous
    // pour la date spécifiée, en excluant les rendez-vous annulés.
    $stmt = $pdo->prepare("
        SELECT TIME_FORMAT(date_heure, '%H:%i') as slot
        FROM rendez_vous
        WHERE DATE(date_heure) = :date AND statut != 'annule'
    ");

    $stmt->execute([':date' => $date]);
    $results = $stmt->fetchAll(); // Exécute et récupère tous les résultats.

    // Boucle sur les résultats pour créer un simple tableau d'heures.
    foreach ($results as $row) {
        $reserved_slots[] = $row['slot'];
    }

    // Encode le tableau en JSON et l'envoie comme réponse.
    echo json_encode($reserved_slots);

} catch (\PDOException $e) {
    // En cas d'erreur de base de données, renvoie une erreur JSON.
    echo json_encode(['error' => 'Database query failed', 'message' => $e->getMessage()]);
}
?>