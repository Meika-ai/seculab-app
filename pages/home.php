<?php
/**
 * Page d'accueil SecuLab CTF
 */
?>

<div class="container">
    <div class="hero-section">
        <h1 class="hero-title">
            <span class="neon-text">🔐 SecuLab CTF</span>
        </h1>
        <p class="hero-subtitle">Plateforme d'apprentissage de la cybersécurité</p>
        <p class="hero-description">
            Bienvenue dans votre laboratoire de sécurité ! Cette application contient 
            <strong>7 vulnérabilités</strong> que vous devez exploiter puis corriger.
        </p>
    </div>
    
    <?php if (!isLoggedIn()): ?>
        <!-- Utilisateur non connecté : afficher uniquement Auth Gate -->
        <div class="modules-grid">
            <a href="/login" class="module-preview featured">
                <div class="module-icon">🔓</div>
                <h3>Auth Gate</h3>
                <span class="vuln-type">SQL Injection</span>
                <p>Contournez l'authentification pour accéder aux autres modules.</p>
                <p class="hint-small">Compte ciblé : <code>charlie</code></p>
            </a>
        </div>
        
        <div class="locked-message">
            <div class="lock-icon">🔒</div>
            <h3>6 modules verrouillés</h3>
            <p>Connectez-vous pour accéder aux autres vulnérabilités à exploiter.</p>
        </div>
        
    <?php else: ?>
        <!-- Utilisateur connecté : afficher tous les modules -->
        
        <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin'): ?>
            <div class="alert alert-success">
                <p>🏆 Bravo ! Vous êtes connecté en tant qu'administrateur !</p>
                <p><strong>FLAG SQL Injection :</strong> <?= SECRET_SQLI ?></p>
            </div>
        <?php endif; ?>
        
        <div class="modules-grid">
            <a href="/login" class="module-preview completed">
                <div class="module-icon">✅</div>
                <h3>Auth Gate</h3>
                <span class="vuln-type">SQL Injection</span>
                <p>Contournez l'authentification et extrayez des données de la base.</p>
            </a>
            
            <a href="/profile" class="module-preview">
                <div class="module-icon">👤</div>
                <h3>User Bio</h3>
                <span class="vuln-type">IDOR</span>
                <p>Accédez aux profils d'autres utilisateurs sans autorisation.</p>
            </a>
            
            <a href="/wall" class="module-preview">
                <div class="module-icon">📝</div>
                <h3>The Wall</h3>
                <span class="vuln-type">Stored XSS</span>
                <p>Injectez du code JavaScript qui s'exécute pour tous les visiteurs.</p>
            </a>
            
            <a href="/calc" class="module-preview">
                <div class="module-icon">🧮</div>
                <h3>Calc-Express</h3>
                <span class="vuln-type">RCE</span>
                <p>Exécutez du code arbitraire sur le serveur via la calculatrice.</p>
            </a>
            
            <a href="/admin" class="module-preview">
                <div class="module-icon">⚙️</div>
                <h3>Admin Panel</h3>
                <span class="vuln-type">Logic Error</span>
                <p>Trouvez la faille dans la logique de contrôle d'accès.</p>
            </a>
            
            <a href="/debug" class="module-preview">
                <div class="module-icon">🐛</div>
                <h3>Debug Info</h3>
                <span class="vuln-type">Info Disclosure</span>
                <p>Découvrez des informations sensibles exposées publiquement.</p>
            </a>
            
            <a href="/secubot" class="module-preview">
                <div class="module-icon">🤖</div>
                <h3>SecuBot</h3>
                <span class="vuln-type">Prompt Injection</span>
                <p>Manipulez l'IA pour qu'elle révèle son secret.</p>
            </a>
            
            <a href="/sql" class="module-preview">
                <div class="module-icon">🗄️</div>
                <h3>SQL Query</h3>
                <span class="vuln-type">SQL Injection</span>
                <p>Extrayez le mot de passe admin et connectez-vous avec son compte.</p>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="instructions-section">
        <h2>📋 Instructions du TP</h2>
        
        <div class="phase-card">
            <h3>🎯 Phase 1 : Attaque</h3>
            <p>Pour chaque module :</p>
            <ol>
                <li>Analysez le code et le comportement de l'application</li>
                <li>Identifiez et exploitez la vulnérabilité</li>
                <li>Récupérez le <strong>FLAG</strong> associé</li>
                <li>Notez vos flags quelque part !</li>
            </ol>
        </div>
    </div>
    
    <?php if (isLoggedIn()): ?>
        <div class="status-box success">
            <p>✅ Connecté en tant que <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
        </div>
    <?php endif; ?>
</div>
