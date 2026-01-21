<?php
/**
 * Script d'initialisation de la base de données SecuLab
 * À exécuter une fois pour créer la structure et les données de test
 * 
 * Usage : php init_database.php
 */

$dbPath = __DIR__ . '/database.sqlite';

// Supprimer l'ancienne base si elle existe
if (file_exists($dbPath)) {
    unlink($dbPath);
    echo "🗑️  Ancienne base supprimée\n";
}

// Créer la connexion
$db = new PDO('sqlite:' . $dbPath);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "📦 Création de la base de données...\n";

// Création des tables
$db->exec("
    -- Table des utilisateurs
    CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        bio TEXT,
        is_admin INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    -- Table de configuration (pour stocker les flags)
    CREATE TABLE config (
        key TEXT PRIMARY KEY,
        value TEXT
    );

    -- Table des posts du Wall
    CREATE TABLE wall_posts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        content TEXT NOT NULL,
        author TEXT DEFAULT 'Anonyme',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
");

echo "✅ Tables créées\n";

// Charger les variables d'environnement si disponibles
$envFile = __DIR__ . '/.env';
$secrets = [
    'SECRET_SQLI' => 'FLAG{SQL_1NJ3CT10N_M4ST3R}',
    'SECRET_IDOR' => 'FLAG{1D0R_PR0F1L3_4CC3SS}',
    'SECRET_XSS' => 'FLAG{ST0R3D_XSS_P4YL04D}',
    'SECRET_RCE' => 'FLAG{R3M0T3_C0D3_3X3CUT10N}',
    'SECRET_LOGIC' => 'FLAG{L0G1C_3RR0R_C00K13}',
    'SECRET_DEBUG' => 'FLAG{D3BUG_H34D3RS_L34K}',
    'SECRET_PROMPT_INJECTION' => 'FLAG{PR0MPT_1NJ3CT10N_41}',
];

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            if (isset($secrets[$key])) {
                $secrets[$key] = trim($value);
            }
        }
    }
    echo "📄 Secrets chargés depuis .env\n";
}

// Insertion des données
$adminPassword = md5('admin123'); // Mot de passe volontairement faible

$db->exec("
    -- Utilisateur admin (le flag IDOR est dans sa bio)
    INSERT INTO users (username, password, bio, is_admin) VALUES 
    ('admin', '$adminPassword', '🔐 Bio secrète de l''admin.\n\n🏆 Flag IDOR : {$secrets['SECRET_IDOR']}', 1);

    -- Utilisateurs de test
    INSERT INTO users (username, password, bio, is_admin) VALUES 
    ('alice', '" . md5('alice123') . "', 'Développeuse web passionnée de sécurité.', 0),
    ('bob', '" . md5('bob456') . "', 'Étudiant en cybersécurité.', 0),
    ('charlie', '" . md5('charlie789') . "', 'Amateur de CTF depuis 2020.', 0);

    -- Configuration avec le flag SQLi
    INSERT INTO config (key, value) VALUES 
    ('sqli_flag', '{$secrets['SECRET_SQLI']}'),
    ('app_version', '1.0.0'),
    ('maintenance_mode', 'false');

    -- Quelques posts sur le Wall
    INSERT INTO wall_posts (content, author) VALUES 
    ('Bienvenue sur SecuLab ! 🎉', 'admin'),
    ('Premier message de test.', 'alice'),
    ('Qui a trouvé le premier flag ?', 'bob');
");

echo "✅ Données insérées\n";

// Créer le fichier secret_rce.txt avec uniquement le flag RCE
// Cela évite que les étudiants récupèrent tous les flags via le RCE
$secretRceFile = __DIR__ . '/secret_rce.txt';
file_put_contents($secretRceFile, "🏆 FLAG RCE : " . $secrets['SECRET_RCE'] . "\n");
chmod($secretRceFile, 0644);
echo "🔐 Fichier secret_rce.txt créé\n";

// Vérification
$count = $db->query('SELECT COUNT(*) FROM users')->fetchColumn();
echo "👥 $count utilisateurs créés\n";

$flags = $db->query('SELECT COUNT(*) FROM config')->fetchColumn();
echo "🏴 $flags entrées de configuration\n";

echo "\n🎉 Base de données initialisée avec succès !\n";
echo "📝 Identifiants de test :\n";
echo "   - admin / admin123 (administrateur)\n";
echo "   - alice / alice123\n";
echo "   - bob / bob456\n";
echo "   - charlie / charlie789\n";

