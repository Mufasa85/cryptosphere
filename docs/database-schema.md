# Schéma de la base de données — MicroCredit

Généré à partir des migrations dans `database/migrations/`.

---

## `users`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | Clé primaire |
| name | varchar(255) | non | Nom complet |
| email | varchar(255) unique | non | Email |
| email_verified_at | timestamp | oui | Date vérification email |
| phone | varchar(255) | oui | Numéro mobile money |
| password | varchar(255) | non | Hash bcrypt |
| role | varchar(255) | non | `admin` / `agent` / `client` |
| national_id | varchar(255) | oui | Numéro pièce d'identité |
| address | text | oui | Adresse |
| is_active | boolean | non | Compte actif (défaut: true) |
| two_factor_enabled | boolean | non | 2FA activé (défaut: false) |
| two_factor_code | varchar(10) | oui | Code OTP en cours |
| two_factor_expires_at | timestamp | oui | Expiration OTP |
| remember_token | varchar(100) | oui | Token "se souvenir" |
| timestamps | — | — | created_at, updated_at |

---

## `loan_applications`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | Clé primaire |
| user_id | FK → users | non | Client demandeur |
| agent_id | FK → users | oui | Agent instructeur/valideur |
| reference | varchar unique | non | Ex: `CRD-20260628-ABCDE` |
| amount_requested | decimal(12,2) | non | Montant demandé (CDF) |
| amount_approved | decimal(12,2) | oui | Montant approuvé (CDF) |
| purpose | text | oui | Motif de la demande |
| duration_months | integer | non | Durée en mois (défaut: 12) |
| interest_rate | decimal(5,2) | non | Taux mensuel (défaut: 0) |
| status | varchar | non | `submitted` / `under_review` / `approved` / `rejected` / `disbursed` / `running` / `closed` |
| submitted_at | timestamp | oui | Date soumission |
| approved_at | timestamp | oui | Date approbation |
| disbursed_at | timestamp | oui | Date décaissement mobile money initié |
| rejection_reason | text | oui | Motif du rejet |
| agent_notes | text | oui | Notes internes agent |
| timestamps | — | — | created_at, updated_at |

---

## `loan_schedules`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | |
| loan_application_id | FK → loan_applications | non | |
| installment_number | integer | non | Numéro d'échéance (1, 2, …) |
| due_date | date | non | Date limite |
| principal_amount | decimal(12,2) | non | Part capital |
| interest_amount | decimal(12,2) | non | Part intérêts |
| total_amount | decimal(12,2) | non | Total dû |
| paid_amount | decimal(12,2) | non | Déjà réglé (défaut: 0) |
| status | varchar | non | `pending` / `partial` / `paid` / `overdue` |
| timestamps | — | — | created_at, updated_at |

---

## `repayments`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | |
| loan_application_id | FK → loan_applications | non | |
| loan_schedule_id | FK → loan_schedules | oui | Échéance ciblée |
| user_id | FK → users | non | Client payeur |
| amount | decimal(12,2) | non | Montant versé |
| payment_method | varchar | non | `mobile_money` |
| mobile_number | varchar | non | Numéro utilisé |
| status | varchar | non | `pending` / `processing` / `confirmed` / `failed` |
| paid_at | timestamp | oui | Date confirmation |
| timestamps | — | — | created_at, updated_at |

---

## `transactions`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | |
| repayment_id | FK → repayments | non | Remboursement lié |
| provider | varchar | non | `labpay` / `mock` |
| provider_reference | varchar | oui | Référence externe (orderNumber) |
| request_payload | json | oui | Corps de la requête envoyée |
| response_payload | json | oui | Réponse brute reçue |
| status | varchar | non | `success` / `failed` / `timeout` |
| timestamps | — | — | created_at, updated_at |

---

## `disbursements`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | |
| loan_application_id | FK → loan_applications | non | Crédit décaissé |
| agent_id | FK → users | non | Agent déclencheur |
| amount | decimal(15,2) | non | Montant envoyé (CDF) |
| mobile_number | varchar | non | Téléphone client destinataire |
| provider_reference | varchar | oui | Référence retournée par le gateway |
| provider | varchar | oui | `labpay` / `mock` |
| status | enum | non | `pending` / `processing` / `confirmed` / `failed` |
| disbursed_at | timestamp | oui | Date de confirmation effective |
| timestamps | — | — | created_at, updated_at |

---

## `loan_products`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | |
| name | varchar | non | Nom du produit |
| description | text | oui | |
| min_amount | decimal(12,2) | non | Montant min autorisé |
| max_amount | decimal(12,2) | non | Montant max autorisé |
| interest_rate | decimal(5,2) | non | Taux mensuel |
| duration_months | integer | non | Durée standard |
| is_active | boolean | non | Produit disponible |
| timestamps | — | — | created_at, updated_at |

---

## `penalties`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | |
| loan_application_id | FK → loan_applications | non | |
| loan_schedule_id | FK → loan_schedules | oui | |
| repayment_id | FK → repayments | oui | |
| user_id | FK → users | oui | |
| amount | decimal(15,2) | non | Montant de la pénalité |
| reason | varchar | oui | Motif |
| status | varchar(20) | non | `pending` / `paid` |
| paid_at | timestamp | oui | |
| timestamps | — | — | created_at, updated_at |

---

## `activity_logs`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | |
| user_id | FK → users | oui | Auteur de l'action |
| action | varchar(100) | non | Ex: `loan.approved`, `repayment.confirmed` |
| entity_type | varchar(100) | oui | Classe du modèle concerné |
| entity_id | bigint | oui | ID de l'entité |
| description | text | oui | Description lisible |
| ip_address | varchar(45) | oui | |
| user_agent | text | oui | |
| timestamps | — | — | created_at, updated_at |

---

## `login_histories`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | |
| user_id | FK → users | non | |
| ip_address | varchar(45) | oui | |
| user_agent | text | oui | |
| success | boolean | non | Succès ou échec |
| timestamps | — | — | created_at, updated_at |

---

## `system_settings`
| Colonne | Type | Nullable | Description |
|---------|------|----------|-------------|
| id | bigint PK | non | |
| key | varchar unique | non | Clé du paramètre |
| value | text | oui | Valeur |
| group | varchar(50) | non | Groupe (défaut: `general`) |
| label | varchar | oui | Libellé lisible |
| timestamps | — | — | created_at, updated_at |

---

## Tables système Laravel (Sanctum / Cache / Jobs / Permissions)

- `personal_access_tokens` — tokens API Sanctum
- `cache` / `cache_locks` — cache base de données
- `jobs` / `job_batches` / `failed_jobs` — queue Laravel
- `roles` / `permissions` / `model_has_roles` / `model_has_permissions` / `role_has_permissions` — Spatie Laravel Permission

---

## Relations Eloquent

```
users ──────────────────── 1:N ── loan_applications (user_id)
users ──────────────────── 1:N ── loan_applications (agent_id)
users ──────────────────── 1:N ── repayments
users ──────────────────── 1:N ── disbursements (agent_id)
users ──────────────────── 1:N ── login_histories

loan_applications ─────── 1:N ── loan_schedules
loan_applications ─────── 1:N ── repayments
loan_applications ─────── 1:N ── disbursements
loan_applications ─────── 1:N ── penalties

loan_schedules ─────────── 1:N ── repayments

repayments ─────────────── 1:N ── transactions
repayments ─────────────── 1:N ── penalties
```

---

## Workflow de statuts — `loan_applications.status`

```
submitted → under_review → approved → disbursed → running → closed
                        ↘ rejected
```

- **`disbursed`** : décaissement mobile money initié (en attente webhook)
- **`running`** : webhook de confirmation reçu, échéancier actif
- **`closed`** : toutes les échéances payées
