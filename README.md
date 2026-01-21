# SecuLab CTF - Application Vulnérable

> 🎓 **Objectif pédagogique** : Apprendre la cybersécurité en exploitant puis en corrigeant des vulnérabilités réelles.

## 📋 Prérequis

- PHP 8.x avec SQLite3
- Serveur web (Apache/Nginx)
- Clé API Google Gemini (pour le module SecuBot)

## 🚀 Installation locale

```bash
# Cloner le dépôt
git clone https://github.com/votre-org/seculab-app.git
cd seculab-app

# Copier et configurer l'environnement
cp .env.example .env
# Éditer .env pour ajouter votre clé Gemini

# Initialiser la base de données
php init_database.php

# Lancer le serveur de développement
php -S localhost:8000
```

## 🎯 Modules vulnérables

| Module       | Vulnérabilité    | Difficulté |
| ------------ | ---------------- | ---------- |
| Auth Gate    | SQL Injection    | ⭐⭐       |
| User Bio     | IDOR             | ⭐         |
| The Wall     | Stored XSS       | ⭐⭐       |
| Calc-Express | RCE (eval)       | ⭐⭐⭐     |
| Admin Panel  | Logic Error      | ⭐         |
| Debug Info   | Info Disclosure  | ⭐         |
| SecuBot      | Prompt Injection | ⭐⭐⭐     |

## 📝 Instructions du TP

### Phase 1 : Attaque

1. Explorez chaque module
2. Lisez les indices fournis
3. Exploitez les vulnérabilités
4. Récupérez les 6 flags

### Phase 2 : Défense

1. Forkez ce dépôt
2. Lancez une analyse CodeQL
3. Corrigez chaque vulnérabilité
4. Renforcez le `.htaccess`
5. Déployez vos corrections

## 🛡️ Corrections attendues

- **SQLi** : Utiliser PDO avec requêtes préparées
- **IDOR** : Vérifier l'autorisation côté serveur
- **XSS** : Échapper avec `htmlspecialchars()`
- **RCE** : Supprimer `eval()`, utiliser une lib de parsing
- **Logic** : Vérifier via `$_SESSION`, pas les cookies
- **Info Disc.** : Protéger `.env` dans `.htaccess`

## ⚠️ Avertissement

Cette application est **volontairement vulnérable**. Ne jamais déployer en production sur un réseau ouvert !

---

_SecuLab CTF - IUT BUT3 Cybersécurité_
