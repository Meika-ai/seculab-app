<?php
/**
 * Fonctions utilitaires SecuLab
 * ATTENTION : Ces fonctions sont VOLONTAIREMENT non sécurisées pour le TP
 */

/**
 * Vérifie si l'utilisateur est connecté
 */
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Récupère l'utilisateur connecté
 */
function getCurrentUser(): ?array {
    global $db;
    if (!isLoggedIn()) return null;
    
    $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Affiche un message flash
 */
function flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Récupère et supprime le message flash
 */
function getFlash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Redirige vers une URL
 */
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

/**
 * Échappe le HTML - DÉSACTIVÉ VOLONTAIREMENT pour le module XSS
 * Les étudiants devront corriger en utilisant htmlspecialchars()
 */
function escapeHtml(string $text): string {
    // VULNÉRABILITÉ : Pas d'échappement !
    return $text;
}

/**
 * Génère un hash de mot de passe simple
 * VULNÉRABILITÉ : MD5 sans sel, facile à casser
 */
function hashPassword(string $password): string {
    return md5($password);
}

/**
 * Vérifie un mot de passe
 */
function verifyPassword(string $password, string $hash): bool {
    return md5($password) === $hash;
}
