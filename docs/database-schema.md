# Schéma de la base de données

## Tables principales

### `users`
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| name | string | Nom complet |
| email | string | Email unique |
| phone | string | Téléphone |
| password | string | Mot de passe haché |
| role | string | admin / agent / client |
| is_active | boolean | Compte actif |
| two_factor_enabled | boolean | 2FA activé |
| two_factor_code | string | Code OTP |
| two_factor_expires_at | datetime | Expiration OTP |

### `loan_applications`
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| user_id | foreign | Client demandeur |
| agent_id | foreign | Agent instructeur |
| reference | string | Référence unique |
| amount_requested | decimal | Montant demandé |
| amount_approved | decimal | Montant approuvé |
| purpose | text | Motif |
| duration_months | integer | Durée |
| interest_rate | decimal | Taux |
| status | string | Statut |
| submitted_at | datetime | Date soumission |
| approved_at | datetime | Date approbation |
| disbursed_at | datetime | Date décaissement |
| rejection_reason | text | Motif rejet |
| agent_notes | text | Notes agent |

### `loan_schedules`
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| loan_application_id | foreign | Crédit lié |
| installment_number | integer | Numéro échéance |
| due_date | date | Date d'échéance |
| principal_amount | decimal | Principal |
| interest_amount | decimal | Intérêts |
| total_amount | decimal | Total |
| paid_amount | decimal | Payé |
| status | string | pending/partial/paid/overdue |

### `repayments`
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| loan_application_id | foreign | Crédit |
| loan_schedule_id | foreign | Échéance |
| user_id | foreign | Client |
| amount | decimal | Montant payé |
| payment_method | string | Méthode |
| mobile_number | string | Numéro |
| status | string | pending/confirmed/failed |
| paid_at | datetime | Date paiement |

### `transactions`
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| repayment_id | foreign | Remboursement |
| provider | string | Fournisseur |
| provider_reference | string | Référence externe |
| request_payload | json | Requête |
| response_payload | json | Réponse |
| status | string | success/failed |

### `loan_products`
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| name | string | Nom produit |
| description | text | Description |
| min_amount | decimal | Montant min |
| max_amount | decimal | Montant max |
| interest_rate | decimal | Taux |
| duration_months | integer | Durée |
| is_active | boolean | Actif |

## Relations
- `users` 1:N `loan_applications` (user_id)
- `users` 1:N `loan_applications` (agent_id)
- `loan_applications` 1:N `loan_schedules`
- `loan_applications` 1:N `repayments`
- `loan_schedules` 1:N `repayments`
- `users` 1:N `repayments`
- `repayments` 1:N `transactions`
