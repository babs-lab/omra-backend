## Why

La navigation du site public (Header Next.js) est actuellement codée en dur dans `Header.tsx`. Chaque modification de menu (ajout/suppression d'un lien, changement d'URL) nécessite un déploiement frontend. En gérant le menu depuis MoonShine, l'équipe marketing peut modifier la navigation sans intervention technique.

## What Changes

- **Nouveau modèle `MenuItem`** dans le backend Laravel avec un resource MoonShine pour la gestion CRUD
- **Nouvel endpoint API** `GET /api/menus` pour exposer les éléments de navigation
- **Mise à jour du Header Next.js** pour consommer l'API et afficher les menus dynamiquement
- **Système d'ordonnancement et d'activation** des éléments de menu (position, publication)

## Capabilities

### New Capabilities
- `menu-management`: CRUD des éléments de menu via MoonShine, avec support de l'ordre d'affichage, des URLs internes/externes, et du statut de publication

### Modified Capabilities
<!-- Aucune spec existante modifiée -->

## Impact

- **Backend**: Nouveau modèle + migration + resource MoonShine + contrôleur API + route
- **Frontend**: Modification de `Header.tsx` pour appeler l'API et rendre dynamiquement
- **API**: Nouvelle route `GET /api/menus`
