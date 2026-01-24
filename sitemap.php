<?php
header("Content-Type: application/xml; charset=utf-8");
include 'includes/db.inc.php';

// Détection automatique du domaine
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domain = $_SERVER['HTTP_HOST'];
$base_url = $protocol . $domain;

// Si localhost, on garde localhost pour le développement
if (strpos($domain, 'localhost') !== false) {
    $base_url = "http://localhost";
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc><?php echo $base_url; ?>/</loc><priority>1.0</priority><changefreq>weekly</changefreq></url>
    <url><loc><?php echo $base_url; ?>/service</loc><priority>0.9</priority><changefreq>monthly</changefreq></url>
    <url><loc><?php echo $base_url; ?>/realisation</loc><priority>0.9</priority><changefreq>weekly</changefreq></url>
    <url><loc><?php echo $base_url; ?>/contact</loc><priority>0.8</priority><changefreq>monthly</changefreq></url>
    <url><loc><?php echo $base_url; ?>/devis</loc><priority>0.8</priority><changefreq>monthly</changefreq></url>
    <url><loc><?php echo $base_url; ?>/mentions-legales</loc><priority>0.3</priority><changefreq>yearly</changefreq></url>
    <url><loc><?php echo $base_url; ?>/politique-confidentialite</loc><priority>0.3</priority><changefreq>yearly</changefreq></url>

    <?php
    // Ajout dynamique des services (si tu as des pages de détail par service plus tard)
    // Pour l'instant on se concentre sur les pages principales.
    ?>
</urlset>