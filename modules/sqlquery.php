<?php
/**
 * Module SQL Query - VULNÉRABLE À L'INJECTION SQL (UNION-based)
 * 
 * 🎯 OBJECTIF : Extraire le hash MD5 du mot de passe admin
 */

$result = null;
$error = null;
$columns = [];
$rows = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $query = trim($_POST['query']);
    
    if (!empty($query)) {
        // Seulement autoriser SELECT pour éviter la destruction de la DB
        if (!preg_match('/^\s*SELECT\s+/i', $query)) {
            $error = "Seules les requêtes SELECT sont autorisées.";
        } else {
            try {
                // VULNÉRABILITÉ : Exécution directe de la requête utilisateur !
                $stmt = $db->query($query);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($rows)) {
                    $columns = array_keys($rows[0]);
                }
            } catch (PDOException $e) {
                $error = "Erreur SQL : " . $e->getMessage();
            }
        }
    }
}
?>

<div class="container">
    <div class="module-card">
        <div class="module-header">
            <h1>🗄️ SQL Query</h1>
            <span class="badge badge-warning">SQL Injection</span>
        </div>
        
        <div class="module-hint">
            <h3>💡 Objectif</h3>
            <p>Cette interface permet d'exécuter des requêtes SQL directement sur la base de données.</p>
            <p>Votre mission : Extraire le mot de passe de l'administrateur et vous connecter avec son compte.</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" class="sql-form">
            <div class="form-group">
                <label for="query">Requête SQL</label>
                <textarea id="query" name="query" class="form-control sql-input" rows="4" 
                          ><?= htmlspecialchars($_POST['query'] ?? '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Exécuter</button>
        </form>
        
        <?php if (!empty($rows)): ?>
            <div class="result-box">
                <h3>📊 Résultats (<?= count($rows) ?> ligne<?= count($rows) > 1 ? 's' : '' ?>)</h3>
                <div class="table-responsive">
                    <table class="debug-table">
                        <thead>
                            <tr>
                                <?php foreach ($columns as $col): ?>
                                    <th><?= htmlspecialchars($col) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <?php foreach ($row as $value): ?>
                                        <td><code><?= htmlspecialchars($value ?? 'NULL') ?></code></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !$error): ?>
            <div class="alert alert-info">Aucun résultat retourné.</div>
        <?php endif; ?>
    </div>
</div>
