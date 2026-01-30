<?php
// Empêcher l'accès direct au fichier pour plus de sécurité
if (count(get_included_files()) <= 1) die("Accès direct interdit.");

/* ==========================================================================
    ANCIENNE CONNEXION (COMMENTÉE)
   ==========================================================================
$isLocal = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);

if ($isLocal) {
    $host = 'localhost'; $db = 'oleris'; $user = 'root'; $pass = '';
} else {
    $host = 'mysql.ton-hebergeur.com'; $db = 'nom_de_ta_bdd'; $user = 'user'; $pass = 'pass';
}

$conn = new mysqli($host, $user, $pass, $db);
========================================================================== */

// NOUVELLE CONNEXION (HOMESTEAD / OLERIS_DB)
$conn = new mysqli("192.168.56.56", "homestead", "secret", "oleris_db");

if ($conn->connect_error) {
    die("Erreur BDD : " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$database = $conn; 

/* ==========================================================================
   FONCTIONS SERVICES
   ========================================================================== */

function getServices($conn) {
    // Attention : Assure-toi que la table 'services' existe aussi !
    $sql = "SELECT * FROM services WHERE actif = 1 ORDER BY ordre_affichage";
    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function getServicesRand($conn) {
    $sql = "SELECT * FROM services WHERE actif = 1 ORDER BY RAND()";
    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

/* ==========================================================================
   FONCTIONS PORTFOLIO / PROJETS
   ========================================================================== */

function getPortfolioFull($conn) {
    $sql = "SELECT * FROM portfolio ORDER BY ordre_affichage ASC";
    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function getPortfolioSelection($conn) {
    $fichiers = ['yummy-nouille.png', 'soif200.png', 'subway.png'];
    $placeholders = implode(',', array_fill(0, count($fichiers), '?'));
    
    $sql = "SELECT * FROM portfolio WHERE image_url IN ($placeholders) LIMIT 3";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($fichiers)), ...$fichiers);
    
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/* ==========================================================================
   FONCTIONS STATISTIQUES
   ========================================================================== */

function getProjetsCount($conn) {
    $sql = "SELECT COUNT(*) as total FROM portfolio WHERE visible = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}

function getClientsSatisfaitsCount($conn) {
    $sql = "SELECT COUNT(DISTINCT client_id) as total FROM projets WHERE statut = 'termine'";
    $result = $conn->query($sql);
    if (!$result) return 0;
    $row = $result->fetch_assoc();
    return $row['total'] ?? 0;
}
?>