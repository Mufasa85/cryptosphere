# MicroCredit — Système de microcrédit en ligne

**Faculté des Sciences Informatiques (FASI) — Université Protestant du Congo (UPC)**
**Promotion L3 · Année académique 2025–2026**

> Application web complète de gestion de microcrédits : demande de prêt, validation par un agent, octroi via mobile money (Labyrinthe RDC), remboursement mobile, génération de reçus PDF et API REST.

---

## Technologies utilisées

| Technologie | Version |
|-------------|---------|
| PHP | ^8.3 |
| Laravel | ^13.8 |
| Base de données | MySQL (prod) / SQLite (dev/test) |
| Laravel Sanctum | ^4.0 (authentification API) |
| Spatie Laravel Permission | ^8.0 (gestion des rôles) |
| barryvdh/laravel-dompdf | ^3.1 (génération PDF) |
| ronald2wing/laravel-mailtrap | ^1.0 (envoi d'emails via API HTTP) |
| Vite + TailwindCSS | UI / assets |
| Labyrinthe RDC API | Paiement mobile money (CDF) |

---

## Architecture

```
app/
├── Http/Controllers/
│   ├── Admin/          ← Gestion admin (users, stats, logs, paramètres)
│   ├── Agent/          ← Validation, décaissement, rapports
│   ├── Client/         ← Demandes de crédit, remboursements, profil
│   ├── Api/            ← Endpoints REST Sanctum
│   ├── Auth/           ← Connexion, inscription, 2FA
│   └── Webhook/        ← Callback mobile money (Labyrinthe)
├── Models/             ← Eloquent : User, LoanApplication, Repayment...
├── Services/
│   ├── LoanService.php
│   ├── RepaymentService.php
│   └── MobileMoney/
│       ├── PaymentGatewayInterface.php
│       ├── LabPayService.php   ← vrai fournisseur Labyrinthe
│       └── MockService.php     ← simulation locale (mode démo)
└── Providers/AppServiceProvider.php  ← binding interface ↔ implémentation
```

---

## Instructions d'installation

```bash
# 1. Cloner le dépôt
git clone https://github.com/<username>/microcredit.git
cd microcredit

# 2. Installer les dépendances PHP et JS
composer install
npm install && npm run build

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
# DB_CONNECTION=mysql
# DB_DATABASE=microcredit
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Exécuter les migrations et les seeders
php artisan migrate --seed

# 6. Lier le stockage public
php artisan storage:link

# 7. Lancer le serveur de développement
php artisan serve
# (ou : composer run dev  pour server + queue + logs + vite en parallèle)
```

> **Mode mock (défaut)** : le paiement mobile est simulé localement, aucune connexion réseau requise.
> Pour passer en mode réel : mettre `LABPAY_PROVIDER=labpay` dans `.env` et renseigner `LABPAY_API_KEY`.
> N'oubliez pas `php artisan config:clear` après toute modification de `.env`.

---

## Comptes de test (créés par les Seeders)

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@exemple.com | password |
| Agent de crédit | agent@exemple.com | password |
| Client | client@exemple.com | password |

---

## Fonctionnalités implémentées

### Niveau 1 — Fondamentaux
- [x] Architecture MVC stricte, conventions Laravel respectées
- [x] Toutes les tables créées via **migrations** (aucune table manuelle)
- [x] Relations Eloquent complètes (hasMany, belongsTo, belongsToMany via Spatie)
- [x] Seeders réalistes (3 utilisateurs + rôles + produits de crédit + paramètres système)
- [x] CRUD complet sur les demandes de crédit, utilisateurs, produits
- [x] Pagination, recherche et filtrage des listes
- [x] Resource Controllers et routes nommées
- [x] Vues Blade avec layouts, composants et `@role`/`@can`
- [x] Validation via Form Requests dédiés, messages d'erreur personnalisés, protection CSRF

### Niveau 2 — Intermédiaires
- [x] **3 rôles** : `admin`, `agent`, `client` (Spatie Laravel Permission)
- [x] Redirection automatique après connexion selon le rôle
- [x] Protection des routes par middleware de rôle
- [x] **3 middleware personnalisés** : `CheckRole`, `CheckAccountActive`, `EnsureTwoFactorVerified`
- [x] Dashboard administrateur : statistiques globales, graphiques Chart.js, activité récente, gestion utilisateurs
- [x] **4 Mailables** : bienvenue, vérification email, décaissement, changement de statut
- [x] Envoi via API HTTP Mailtrap (`ronald2wing/laravel-mailtrap`)
- [x] Emails en file d'attente (Laravel Queues)
- [x] **2FA par email** : code OTP à 6 chiffres, expiration configurable, activation/désactivation depuis le profil

### Niveau 3 — Avancés
- [x] **API REST** avec Laravel Sanctum (register, login, logout, loan-applications CRUD)
- [x] **Paiement mobile** via Labyrinthe RDC — remboursement (dépôt client) ET octroi (décaissement vers client)
- [x] Mode mock local (90 % succès dépôt / 95 % succès décaissement) pour démonstration sans réseau
- [x] Webhook mobile money bidirectionnel : routing automatique remboursement ↔ décaissement par `provider_reference`
- [x] **Génération PDF** des reçus de remboursement (DomPDF)
- [x] **Logs & traçabilité** : `ActivityLog`, `LoginHistory`, log brut de chaque webhook reçu
- [x] Journalisation des connexions réussies/échouées

---

## Schéma de la base de données

Voir [`docs/database-schema.md`](docs/database-schema.md) pour le détail complet de toutes les tables, colonnes et relations.

**Tables principales :**
`users` · `loan_applications` · `loan_schedules` · `repayments` · `transactions` · `disbursements` · `loan_products` · `penalties` · `activity_logs` · `login_histories` · `system_settings`

---

## Difficultés rencontrées et solutions

### 1. Blocage réseau — API Labyrinthe et Mailtrap SMTP
Mon réseau 4G/5G bloque les connexions sortantes TCP:443 vers `payment.labyrinthe-rdc.com` et `smtp.mailtrap.io`.

**Solutions :**
- **Mailtrap** : remplacement du mailer `smtp` par le package `ronald2wing/laravel-mailtrap` qui utilise l'API HTTP Mailtrap (port 443 vers `send.api.mailtrap.io`, non bloqué).
- **Labyrinthe** : création d'un `MockService` implémentant `PaymentGatewayInterface`, activé par `LABPAY_PROVIDER=mock` dans `.env`. Le binding dans `AppServiceProvider` injecte automatiquement la bonne implémentation. Il suffit de changer la variable d'environnement pour passer en mode réel dès qu'un réseau compatible est disponible.

### 2. Endpoint de décaissement Labyrinthe non documenté
La documentation sandbox de Labyrinthe ne couvre que le dépôt (`/api/beta/mobile`). L'endpoint de retrait (`/withdrawal`) est une **hypothèse** — signalée explicitement dans `LabPayService::payout()` avec le commentaire `HYPOTHÈSE NON CONFIRMÉE`. Le webhook est conçu pour s'adapter au vrai format dès confirmation.

### 3. Architecture double-sens du webhook
Un seul endpoint webhook (`POST /api/webhooks/mobile-money`) doit traiter à la fois les confirmations de remboursement et de décaissement. Résolu par une recherche séquentielle par `provider_reference` : d'abord dans `transactions` (remboursements), puis dans `disbursements`.

---

## Lien de déploiement

*(Non déployé en ligne — démonstration en local via `php artisan serve`)*

---

*Projet développé dans le cadre du cours Laravel L3 · FASI/UPC · 2025–2026*
