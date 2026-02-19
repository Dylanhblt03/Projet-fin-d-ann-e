<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- LOGIQUE SEO DYNAMIQUE ---
// On récupère le nom du fichier actuel (ex: index.php)
$current_page = basename($_SERVER['PHP_SELF']);
$site_name = "OLÉRIS";

// Détection automatique du domaine pour les URLs
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domain = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base_url = $protocol . $domain;

// Valeurs par défaut (Accueil)
$meta_title = "OLÉRIS | Agence Web Créative & Stratégique";
$meta_desc = "Expert en architecture web sur-mesure, design immersif et identité digitale. Propulsez votre entreprise avec l'excellence Oléris.";
$canonical_url = $base_url . '/';
$og_image = $base_url . '/images/oleris.jpg';

// Personnalisation selon la page
switch($current_page) {
    case 'nos-services.php':
        $meta_title = "Nos Services Digitaux | $site_name";
        $meta_desc = "Découvrez nos expertises : développement web, design UX/UI, SEO et maintenance applicative pour votre business.";
        $canonical_url = $base_url . '/nos-services';
        break;
    case 'realisations.php':
        $meta_title = "Nos Réalisations & Projets | $site_name";
        $meta_desc = "Explorez notre portfolio : sites vitrines, e-commerce et photographie haute définition pour nos clients.";
        $canonical_url = $base_url . '/realisations';
        break;
    case 'contact.php':
        $meta_title = "Contactez l'Agence | $site_name";
        $meta_desc = "Un projet web ? Une question ? Contactez Oléris pour un accompagnement personnalisé et un devis sous 48h.";
        $canonical_url = $base_url . '/contact';
        break;
    case 'devis.php':
        $meta_title = "Demander un Devis Gratuit | $site_name";
        $meta_desc = "Obtenez une estimation gratuite pour la création de votre site web ou votre stratégie digitale sur-mesure.";
        $canonical_url = $base_url . '/devis';
        break;
    case 'mentions-legales.php':
        $meta_title = "Mentions Légales | $site_name";
        $meta_desc = "Consultez les mentions légales de l'agence Oléris : informations juridiques, propriété intellectuelle et conditions d'utilisation.";
        $canonical_url = $base_url . '/mentions-legales';
        break;
    case 'politique-confidentialite.php':
        $meta_title = "Politique de Confidentialité | $site_name";
        $meta_desc = "Découvrez comment Oléris protège vos données personnelles : RGPD, cookies et droits des utilisateurs.";
        $canonical_url = $base_url . '/politique-confidentialite';
        break;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo htmlspecialchars($meta_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    
    <!-- SEO Essentials -->
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="OLÉRIS">
    <meta name="language" content="fr-FR">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($meta_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta property="og:site_name" content="OLÉRIS">
    <meta property="og:image" content="<?php echo htmlspecialchars($og_image); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="fr_FR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($meta_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($og_image); ?>">
    
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <link rel="apple-touch-icon" href="/images/favicon.png">
    
    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "OLÉRIS",
        "description": "Agence Web Créative & Stratégique spécialisée en architecture web sur-mesure, design immersif et identité digitale",
        "url": "<?php echo htmlspecialchars($base_url); ?>",
        "logo": "<?php echo htmlspecialchars($base_url); ?>/images/oleris.jpg",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+33-6-77-50-88-35",
            "contactType": "Customer Service",
            "availableLanguage": "French"
        },
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "FR"
        },
        "sameAs": [
            "https://www.linkedin.com/in/humblot-dylan-49835b341/",
            "https://github.com/Dylanhblt03"
        ],
        "serviceType": ["Web Development", "Design", "SEO", "Photography"],
        "areaServed": "FR",
        "priceRange": "€€€"
    }
    </script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/css/aos.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="/css/cssprojet.css" rel="stylesheet">

    <link rel="canonical" href="https://tonsite.com/<?php echo ($current_page == 'index.php') ? '' : str_replace('.php', '', $current_page); ?>">
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top"> 
        <div class="container">
            <a class="navbar-brand logo-text" href="/">
                <img src="/images/oleris.jpg" alt="Logo Oléris - Agence Web" width="150">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'nos-services.php') ? 'active' : ''; ?>" href="/nos-services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'realisations.php') ? 'active' : ''; ?>" href="/realisations">Réalisations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="/contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a href="/devis" class="btn btn-gold ms-lg-3">Demander un Devis</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>