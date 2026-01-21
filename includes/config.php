<?php
/**
 * Configuration SecuLab
 * Chargement du .env et connexion à la base SQLite
 */

// Chargement du fichier .env (méthode simple, pas de bibliothèque)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) continue; // Ignorer les commentaires
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
            putenv(trim($key) . '=' . trim($value));
        }
    }
}

// Connexion à la base de données SQLite
$dbPath = __DIR__ . '/../database.sqlite';
try {
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupération des secrets depuis l'environnement
define('SECRET_SQLI', getenv('SECRET_SQLI') ?: 'FLAG{DEFAULT_SQLI}');
define('SECRET_IDOR', getenv('SECRET_IDOR') ?: 'FLAG{DEFAULT_IDOR}');
define('SECRET_XSS', getenv('SECRET_XSS') ?: 'FLAG{DEFAULT_XSS}');
define('SECRET_RCE', getenv('SECRET_RCE') ?: 'FLAG{DEFAULT_RCE}');
define('SECRET_LOGIC', getenv('SECRET_LOGIC') ?: 'FLAG{DEFAULT_LOGIC}');
define('SECRET_DEBUG', getenv('SECRET_DEBUG') ?: 'FLAG{DEFAULT_DEBUG}');
define('SECRET_PROMPT_INJECTION', getenv('SECRET_PROMPT_INJECTION') ?: 'FLAG{DEFAULT_PROMPT}');
define('GEMINI_API_KEY', getenv('GEMINI_API_KEY') ?: '');

// Configuration de l'application
define('APP_NAME', 'SecuLab CTF');
define('APP_VERSION', '1.0.0');
