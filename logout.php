<?php
// 1. Démarrer la session pour pouvoir la manipuler.
session_start();

// 2. Détruire toutes les variables de session.
$_SESSION = [];

// 3. Détruire la session elle-même.
session_destroy();

// 4. Rediriger l'utilisateur vers la page de connexion.
header('Location: login.php');
exit; // Important pour s'assurer que le script s'arrête après la redirection.
?>