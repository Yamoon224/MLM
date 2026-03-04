# Matrix MLM Platform

Application Laravel implémentant un système MLM (Multi-Level Marketing) basé sur une structure Matrix avec gestion hiérarchique via Closure Table.

## 🚀 Fonctionnalités

### 👤 Authentification
- Inscription via email ou téléphone
- Connexion avec email ou téléphone
- Authentification sécurisée (Laravel Auth)

### 🧬 Structure Matrix (Closure Table)
- Gestion hiérarchique illimitée
- Support multi-niveaux
- Relation Ancestor / Descendant optimisée
- Requêtes performantes avec indexation

### 💰 Wallet System
- Wallet automatique à la création d’un utilisateur
- Transactions (REFERRAL_BONUS, etc.)
- Calcul dynamique du solde
- Historique des transactions

### 🎯 Parrainage
- Lien sponsor / filleul
- Bonus automatique de parrainage
- Calcul des gains par niveau

### 📊 Dashboard API
Endpoint permettant de récupérer :
- Wallet + transactions
- Filleuls directs
- Descendants par niveau (1 → 5)

### 📦 Seeders avancés
- Génération massive d’utilisateurs
- Simulation de structure Matrix complète
- Données de test réalistes

---

## 🏗 Architecture

- Laravel
- MySQL
- Closure Table pour hiérarchie
- Service Layer Pattern
- API REST

---

## 🔑 Endpoints API principaux

### Auth
- `POST /api/register`
- `POST /api/login`

### Dashboard
- `GET /api/dashboard`

Retourne :
```json
{
  "wallet": {...},
  "direct_filleuls": [],
  "matrix": {
    "1": [],
    "2": [],
    "3": [],
    "4": [],
    "5": []
  }
}# mlm
