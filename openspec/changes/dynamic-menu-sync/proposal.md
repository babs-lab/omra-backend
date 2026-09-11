## Why

La barre de navigation du frontend est entièrement hardcodée dans `Header.tsx` : les liens, leur ordre et leur visibilité ne peuvent être modifiés que par une mise à jour du code. Le backend possède déjà une table `menu_items` et un resource MoonShine `MenuItemResource`, mais celle-ci n'est pas exploitée par le frontend. Il est impossible pour un administrateur d'activer/désactiver un lien, de réordonner le menu ou de masquer temporairement une page sans intervenir manuellement sur le code source.

## What Changes

- Le composant `Header` du frontend lit la navigation depuis l'API `GET /api/menus` au lieu de constants hardcodées.
- Les items de menu inactifs (`is_active = false`) ne sont plus affichés côté frontend.
- L'ordre des liens dans la navbar respecte le champ `position` défini dans MoonShine.
- Les liens internes (`route`) et externes (`url`) sont gérés dynamiquement.
- Les pages désactivées dans MoonShine (pages CMS avec `is_published = false`) ne reçoivent plus de lien dans le menu.
- Le menu mobile utilise les mêmes données dynamiques.

## Capabilities

### New Capabilities
- `dynamic-navigation`: Lecture des items de menu depuis l'API et rendu dynamique de la navbar côté frontend.

### Modified Capabilities

## Impact

- **Frontend** : `src/components/Header.tsx` — refonte du composant pour consommer l'API menus. Ajout d'un appel serveur ou d'un fetch dans le layout racine.
- **Backend** : Aucune modification de l'API existante nécessaire — `GET /api/menus` est déjà fonctionnel. Potentiel nettoyage du seeder `MenuItemSeeder` pour s'assurer que les slugs correspondent aux routes réelles du frontend.
- **Admin** : Le resource `MenuItemResource` dans MoonShine existe déjà — pas de changement requis côté admin.
- **Dépendances** : Aucune nouvelle dépendance ajoutée.
