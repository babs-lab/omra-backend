## 1. Backend — Modèle & Migration

- [x] 1.1 Créer la migration `create_menu_items_table` avec colonnes : `label` (string), `route` (string, nullable), `url` (string, nullable), `is_external` (boolean, default false), `is_active` (boolean, default true), `position` (integer, default 0)
- [x] 1.2 Créer le modèle `App\Models\MenuItem` avec `$fillable`, scope `active()`, et ordre par défaut `position`

## 2. Backend — MoonShine Resource

- [x] 2.1 Créer `App\MoonShine\Resources\MenuItemResource` avec `ModelResource`, champs `ID`, `Text` (label, route, url), `Switcher` (is_external, is_active), `Number` (position, sortable)
- [x] 2.2 Enregistrer le resource dans `MoonShineServiceProvider`
- [x] 2.3 Ajouter le menu item au sidebar admin dans `MoonShineLayout`

## 3. Backend — API Endpoint

- [x] 3.1 Créer `App\Http\Controllers\Api\MenuController` avec méthode `index()` retournant les menus actifs triés par position
- [x] 3.2 Ajouter la route `GET /api/menus` dans `routes/api.php`

## 4. Frontend — Type & API Client

- [x] 4.1 Ajouter l'interface `MenuItem` dans `frontend/src/types/index.ts`
- [x] 4.2 Ajouter la fonction `fetchMenus()` dans `frontend/src/lib/api.ts`

## 5. Frontend — Header Dynamique

- [x] 5.1 Modifier `Header.tsx` pour appeler `fetchMenus()` au chargement, rendre les items dynamiquement, et afficher un fallback statique si l'API échoue

## 6. Seeds & Tests

- [x] 6.1 Créer un seeder `MenuItemSeeder` avec les 5 liens actuels (Accueil, Omra, Ramadan, Blog, Contact)
- [x] 6.2 Tester l'endpoint avec `GET /api/menus` et vérifier le tri et l'exclusion des inactifs
