## Why

La page d'accueil et les autres pages du site sont entièrement codées en dur dans le frontend. Pour ajouter, déplacer ou supprimer une section de contenu, un développeur doit modifier le code et redéployer. L'administrateur MoonShine ne peut pas gérer la composition des pages. Il faut un système de placement dynamique pour permettre à l'admin de créer du contenu et de choisir où l'afficher (page d'accueil, pages internes) et dans quel ordre.

## What Changes

- Nouveau modèle `Section` avec champ `target_page` (slug de la page cible, ex: `homepage`), `position` (ordre d'affichage), `title`, `content` (WYSIWYG), `style` (variant d'affichage), `is_active`
- Nouvelle table `sections` en BDD
- Nouveau controller API `SectionController` avec endpoint `GET /api/sections?target={slug}`
- Nouveau champ MoonShine `SectionResource` pour gérer les sections depuis l'admin
- Refonte du composant `PageSection` pour charger dynamiquement les sections par position
- Refonte de `page.tsx` (homepage) pour afficher les sections dynamiques au lieu du layout codé en dur
- Les sections existantes (hero, packages, pourquoi-chosir) restent des composants dédiés mais peuvent être réordonnées via `position`

## Capabilities

### New Capabilities
- `section-management`: CRUD des sections de contenu avec placement par page cible et positionnement ordonné
- `dynamic-page-composition`: Le frontend charge et affiche les sections dynamiquement selon la page demandée

### Modified Capabilities

## Impact

- **Backend** : nouvelle migration, model, controller, resource MoonShine, route API
- **Frontend** : refactor `page.tsx`, nouveau composant `DynamicSections`, modification de `PageSection`
- **BDD** : nouvelle table `sections`
- **API** : nouveau endpoint `GET /api/sections`
