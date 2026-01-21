<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> - Plateforme CTF</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            <a href="/">🔐 <?= APP_NAME ?></a>
        </div>
        <ul class="nav-links">
            <?php if (!isLoggedIn()): ?>
                <li><a href="/login" class="<?= $path === '/login' ? 'active' : '' ?>">🔓 Auth Gate</a></li>
            <?php else: ?>
                <li><a href="/login" class="<?= $path === '/login' ? 'active' : '' ?>">🔓 Auth Gate</a></li>
                <li><a href="/profile" class="<?= $path === '/profile' ? 'active' : '' ?>">👤 Profil</a></li>
                <li><a href="/wall" class="<?= $path === '/wall' ? 'active' : '' ?>">📝 Wall</a></li>
                <li><a href="/calc" class="<?= $path === '/calc' ? 'active' : '' ?>">🧮 Calc</a></li>
                <li><a href="/admin" class="<?= $path === '/admin' ? 'active' : '' ?>">⚙️ Admin</a></li>
                <li><a href="/debug" class="<?= $path === '/debug' ? 'active' : '' ?>">🐛 Debug</a></li>
                <li><a href="/secubot" class="<?= $path === '/secubot' ? 'active' : '' ?>">🤖 SecuBot</a></li>
                <li><a href="/sql" class="<?= $path === '/sql' ? 'active' : '' ?>">🗄️ SQL</a></li>
                <li><a href="/logout" class="btn-logout">Déconnexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main class="main-content">

    <?php if ($flash = getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= $flash['message'] ?>
        </div>
    <?php endif; ?>


