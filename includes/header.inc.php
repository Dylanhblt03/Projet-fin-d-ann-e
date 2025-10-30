
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLÉRIS - Agence Web</title> <!-- Le titre qui apparaît dans l'onglet du navigateur -->
    <!-- Favicon : la petite icône dans l'onglet du navigateur -->
    <link rel="icon" type="image/x-icon" href="/images/favicon.png">
    <!-- Inclusion des feuilles de style (CSS) depuis des CDN et en local -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"> <!-- Framework CSS Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"> <!-- Bibliothèque d'icônes Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/css/aos.min.css" rel="stylesheet"> <!-- Bibliothèque pour les animations au défilement (AOS) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> <!-- Police d'écriture Google Fonts -->
    <link href="cssprojet.css" rel="stylesheet"> <!-- Votre feuille de style personnalisée -->
    <!-- Inclusion de jQuery, nécessaire pour certaines fonctionnalités comme le formulaire de contact AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
<body>

    <!-- Barre de navigation principale, fixée en haut de la page -->
    <nav class="navbar navbar-expand-lg fixed-top"> 
        <div class="container">
            <a class="navbar-brand logo-text" href="/index.php">
                <img src="/images/oleris.jpg" alt="mon logo Oléris">
            </a>
            <!-- Bouton "hamburger" pour la navigation sur mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Contenu de la navigation qui sera réduit sur mobile -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/service.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand logo-text" href="/prendrerdv.php">
                            <button class="btn btn-gold ms-3">Prendre RDV</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>