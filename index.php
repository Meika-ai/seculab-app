<?php
/**
 * SecuLab CTF - Routeur Principal
 * Application volontairement vulnérable pour l'apprentissage de la cybersécurité
 */

session_start();

// Chargement de la configuration
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/helpers.php';

// Récupération de la route
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = rtrim($path, '/') ?: '/';

// Routage simple
$routes = [
    '/'         => 'pages/home.php',
    '/login'    => 'modules/auth.php',
    '/logout'   => 'modules/logout.php',
    '/profile'  => 'modules/profile.php',
    '/wall'     => 'modules/wall.php',
    '/calc'     => 'modules/calc.php',
    '/admin'    => 'modules/admin.php',
    '/debug'    => 'modules/debug.php',
    '/secubot'  => 'modules/secubot.php',
    '/sql'      => 'modules/sqlquery.php',
];

// Inclusion du header
include __DIR__ . '/includes/header.php';

// Dispatch vers le bon module
if (isset($routes[$path])) {
    $file = __DIR__ . '/' . $routes[$path];
    if (file_exists($file)) {
        include $file;
    } else {
        echo '<div class="container"><h1>Module en construction...</h1></div>';
    }
} else {
    http_response_code(404);
    echo '<div class="container"><h1>404 - Page non trouvée</h1></div>';
}

// Inclusion du footer
include __DIR__ . '/includes/footer.php';
