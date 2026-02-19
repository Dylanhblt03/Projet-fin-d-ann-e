<?php
/**
 * Configuration du routage - Fonctionne sans mod_rewrite
 */

// Déterminer quelle page afficher basée sur le paramètre ?page= ou l'URI
function get_current_page() {
    // Vérifier si ?page= est passé
    if (!empty($_GET['page'])) {
        return htmlspecialchars($_GET['page'], ENT_QUOTES, 'UTF-8');
    }
    
    // Sinon, vérifier l'URI (pour support du .htaccess si disponible)
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    
    // Obtenir le dernier segment
    $segments = array_filter(explode('/', $uri));
    if (!empty($segments)) {
        return htmlspecialchars(end($segments), ENT_QUOTES, 'UTF-8');
    }
    
    return 'accueil';
}

// Fichiers de pages disponibles
$PAGES = [
    'accueil' => ['file' => 'index.php', 'title' => 'Accueil'],
    'contact' => ['file' => 'pages/contact.php', 'title' => 'Contact'],
    'devis' => ['file' => 'pages/devis.php', 'title' => 'Devis'],
    'nos-services' => ['file' => 'pages/nos-services.php', 'title' => 'Nos Services'],
    'realisations' => ['file' => 'pages/realisations.php', 'title' => 'Réalisations'],
    'mentions-legales' => ['file' => 'pages/mentions-legales.php', 'title' => 'Mentions Légales'],
    'politique-confidentialite' => ['file' => 'pages/politique-confidentialite.php', 'title' => 'Politique de Confidentialité'],
    'traitement_contact' => ['file' => 'pages/traitement_contact.php', 'title' => 'Traitement Contact'],
    'traitement_devis' => ['file' => 'pages/traitement_devis.php', 'title' => 'Traitement Devis'],
];

$current_page = get_current_page();
$page_info = $PAGES[$current_page] ?? null;

if (!$page_info) {
    $current_page = '404';
    $page_info = ['file' => 'pages/404.php', 'title' => 'Page non trouvée'];
}
?>
