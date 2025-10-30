<?php
// Fichier: includes/db.inc.php
// Centralise la connexion à la base de données
 
$host = 'localhost'; // L'adresse du serveur de base de données. 'localhost' est utilisé quand le site et la BDD sont sur le même serveur.
$db   = 'oleris';    // Le nom de votre base de données.
$user = 'root';     // Le nom d'utilisateur pour se connecter à la BDD.
$pass = '';        // Le mot de passe associé à l'utilisateur. Laissez vide si vous n'en avez pas (courant en développement local).
$charset = 'utf8mb4'; // Le jeu de caractères. 'utf8mb4' est recommandé pour supporter tous les caractères, y compris les emojis.
 
// DSN (Data Source Name) : une chaîne de caractères qui contient les informations de connexion.
$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; 
// Options pour la connexion PDO.
$options = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Demande à PDO de lever des exceptions en cas d'erreur, ce qui est plus facile à gérer.
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Demande à PDO de retourner les résultats sous forme de tableau associatif (clé => valeur).
     PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées, pour utiliser les vraies requêtes préparées du SGBD (plus sécurisé).
];
 
try {
     // Tente de créer une nouvelle instance de l'objet PDO pour se connecter à la base de données.
     $pdo = new PDO($dsn, $user, $pass, $options); 
} catch (\PDOException $e) {
     // Si la connexion échoue, une exception est attrapée.
     // On arrête le script et on affiche l'erreur. En production, il faudrait logger cette erreur dans un fichier plutôt que de l'afficher.
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>