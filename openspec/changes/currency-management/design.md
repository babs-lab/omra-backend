## Context

Actuellement, tous les prix (Package.base_price_quad, Supplement.amount, Departure.price_override) sont stockés sans information de devise. Le frontend affiche systématiquement "EUR" en dur via `toLocaleString`. Aucun modèle Currency n'existe dans le système.

## Goals / Non-Goals

**Goals:**
- Modèle `Currency` avec code ISO, nom, symbole, taux de change
- Resource MoonShine pour la gestion CRUD des devises
- Association optionnelle d'une devise à un package (`currency_id` sur `packages`)
- API `GET /api/currencies` listant les devises actives
- Inclure la devise dans les réponses API (`GET /api/packages`, `GET /api/supplements`)
- Frontend dynamique : utiliser la devise du package au lieu d'EUR en dur

**Non-Goals:**
- Conversion automatique entre devises côté serveur (le taux de change est indicatif)
- Association devise par departure ou supplement (héritent du package)
- Multi-devise au sein d'un même panier/lead
- Taux de change historiques ou auto-mise à jour

## Decisions

| Décision | Choix | Raison |
|---|---|---|
| Association devise | `currency_id` seulement sur `packages` (nullable) | Supplements et départs héritent de la devise du package. Évite 3 migrations. |
| Devise par défaut | Si `currency_id` est null, considérer EUR | Rétrocompatible avec les données existantes |
| Taux de change | `exchange_rate` (decimal) relatif à l'EUR (EUR = 1.0) | Base de référence naturelle pour une agence européenne |
| Frontend | Props `currency` (code + symbole) passées aux composants d'affichage de prix | Pas de breaking change sur la structure des composants |
| API devises | `GET /api/currencies` avec cache ISR 300s | Cohérent avec les autres endpoints |

## Risks / Trade-offs

- **Données existantes** → Les packages existants n'ont pas de `currency_id`. Migration avec valeur par défaut = null → interprété comme EUR. Mitigation : seeder Currency avec EUR comme devise de référence.
- **Frontend** → 4 composants à modifier pour utiliser la devise dynamique. Risque d'oublier un affichage. Mitigation : chercher toutes les occurrences de `currency: "EUR"` et `toLocaleString`.
