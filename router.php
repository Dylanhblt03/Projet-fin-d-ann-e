<?php
/**
 * Router - Détermine quelle page afficher en fonction de l'URI
 */

// Récupérer l'URI demandée
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = trim(str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $request_uri), '/');

// Empêcher les remontées de répertoires
$request_uri = str_replace('..', '', $request_uri);

// Déterminer la page à afficher
$page = '';
if (empty($request_uri) || $request_uri === 'index.php') {
    // Accueil
    echo "<!-- Accueil chargé via router -->";
    include __DIR__ . '/index.php';
} else {
    // Essayer de charger pages/{uri}.php
    $page_file = __DIR__ . '/pages/' . $request_uri . '.php';
    
    if (file_exists($page_file)) {
        include $page_file;
    } else {
        // Essayer les URLs sans extension
        $base = $request_uri;
        if (in_array($request_uri, ['contact', 'devis', 'nos-services', 'realisations', 'mentions-legales', 'politique-confidentialite', 'traitement_contact', 'traitement_devis'])) {
            $page_file = __DIR__ . '/pages/' . $request_uri . '.php';
            if (file_exists($page_file)) {
                include $page_file;
                exit;
            }
        }
        
        // 404
        include __DIR__ . '/pages/404.php';
    }
}
?>

