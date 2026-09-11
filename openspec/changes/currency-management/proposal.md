## Why

Tous les prix sont actuellement stockés en EUR sans indication de devise (code en dur côté frontend). Impossible de changer de devise ou d'afficher les prix dans une autre monnaie sans modification du code. L'agence peut vouloir facturer en USD, afficher en EUR, ou gérer plusieurs devises selon les marchés.

## What Changes

- Nouveau modèle `Currency` avec une resource MoonShine pour gérer les devises (code, nom, symbole, taux de change)
- Colonne `currency_id` optionnelle sur `packages`, `supplements`, `departures` pour associer une devise à chaque prix
- Endpoint API `GET /api/currencies` exposant les devises disponibles
- Mise à jour des réponses API des prix pour inclure la devise associée
- Mise à jour du frontend pour utiliser dynamiquement la devise au lieu d'EUR en dur

## Capabilities

### New Capabilities
- `currency-management`: CRUD des devises via MoonShine avec code ISO, symbole, taux de change par rapport à la devise de référence

### Modified Capabilities
- `omra-system` (specification existante) : les entités contenant des prix (Package, Departure, Supplement) exposent désormais la devise associée dans l'API

## Impact

- **Backend**: Nouveau modèle `Currency` + migration + resource MoonShine + contrôleur API + route. Ajout de `currency_id` sur les tables de prix.
- **API**: Nouvelle route `GET /api/currencies`. Modifications des réponses de `GET /api/packages`, `GET /api/supplements`.
- **Frontend**: Mise à jour de l'affichage des prix dans `PackageCard`, `PricingTable`, `BookingForm`, `PackageDetailPage` (page omra/[slug]).
