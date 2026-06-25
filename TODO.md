# TODO - UI/UX FinTech MicroCredit (Neon + Mobile Money)

## Étape 1 — Préparation
- [x] Comprendre l’existant: landing + dashboard client + pages remboursements
- [x] Vérifier `layouts/dashboard.blade.php` et la cohérence des styles (sidebar, variables CSS)

## Étape 2 — Landing premium (route /)
- [ ] Mettre à jour `resources/views/landing.blade.php` avec :
  - [ ] Section HERO exacte (FINANCEZ VOS PROJETS…)
  - [ ] Section “Remboursez Votre Crédit En Quelques Secondes”
  - [ ] Card payment glass + CTA neon glow
  - [ ] Modal de remboursement (tel, montant, méthode)
  - [ ] Diagramme workflow (1→7)
  - [ ] Historique transactions premium (table + filtres + pagination)
  - [ ] Section Reçus (PDF/email/print)
  - [ ] Animations: Glow Pulse, Fade In, Slide Up, Floating Cards

## Étape 3 — Espace client (premium UI)
- [ ] Mettre à jour `resources/views/client/dashboard.blade.php` : cartes (crédit restant / montant remboursé / prochaine échéance / statut) + bouton “Rembourser maintenant”
- [ ] Mettre à jour `resources/views/client/repayments/index.blade.php` : table premium + filtres/recherche + statuts neon
- [ ] Mettre à jour `resources/views/client/repayments/create.blade.php` : remplacer la forme simple par l’UX premium (et réutiliser la logique actuelle de `RepaymentController@store`)

## Étape 4 — Backend LabPay (si nécessaire)
- [ ] Vérifier que `RepaymentController@store` + `LabPayService@initiate` + `MobileMoneyWebhookController` couvrent le flux complet
- [ ] Ajouter/ajuster routes API seulement si manquant (initiate/callback/status)
- [ ] Harmoniser `Transaction`/`Repayment` status et génération du reçu

## Étape 5 — Tests
- [ ] Contrôler visuellement : landing + modal + pages client
- [ ] Vérifier route: `/client/dashboard`, `/client/repayments`, création remboursement, téléchargement reçu PDF

