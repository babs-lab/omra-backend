## Why

La homepage affiche actuellement un bloc "À propos" et des badges de fonctionnalités dans le hero, mais il manque une section dédiée "Pourquoi nous choisir" qui met en avant les arguments de vente clés de l'agence (spécialiste Omra, guide bilingue, hébergements sélectionnés, assistance 24/7). Cette section est présente sur le site concurrent manasikomra.fr et constitue un élément de confiance important pour convertir les visiteurs. Son contenu doit être gérable depuis MoonShine pour permettre des ajustements sans intervention technique.

## What Changes

- Nouveau modèle `Feature` (backend Laravel) avec : `title`, `icon`, `position`, `is_active`
- Nouvel endpoint `GET /api/features` retournant les features actives triées par position
- Nouveau resource MoonShine `FeatureResource` pour la gestion admin (CRUD, activation/désactivation, réordre)
- Nouveau seeder `FeatureSeeder` avec 4 items par défaut
- Nouveau composant frontend `WhyChooseSection` (Server Component) affichant une grille de features
- Intégration de `WhyChooseSection` dans la homepage (`page.tsx`)

## Capabilities

### New Capabilities
- `feature-management`: CRUD des arguments de vente (features) dans MoonShine, exposition via API, affichage dynamique sur la homepage.

### Modified Capabilities

## Impact

- **Backend** : Nouveau modèle `Feature`, migration, controller `FeatureController`, route `GET /api/features`, resource MoonShine `FeatureResource`, seeder `FeatureSeeder`
- **Frontend** : Nouveau type `Feature` dans `types/index.ts`, nouvelle fonction `fetchFeatures()` dans `api.ts`, nouveau composant `WhyChooseSection.tsx`, modification de `page.tsx` (homepage)
- **Admin** : Nouveau menu "Arguments" dans MoonShine
- **Dépendances** : Aucune nouvelle dépendance
