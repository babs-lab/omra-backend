## 1. Backend — Modèle et migration

- [x] 1.1 Créer le modèle `Feature` (`app/Models/Feature.php`) avec fillable `title`, `icon`, `position`, `is_active`, scope `active()`, global scope tri par `position`
- [x] 1.2 Créer la migration `create_features_table` (id, title, icon nullable, position default 0, is_active default true, timestamps)
- [x] 1.3 Lancer `php artisan migrate`

## 2. Backend — API et controller

- [x] 2.1 Créer `FeatureController` (`app/Http/Controllers/Api/FeatureController.php`) avec méthode `index()` retournant les features actives triées par position
- [x] 2.2 Ajouter la route `GET /api/features` dans `routes/api.php`

## 3. Backend — Seeder

- [x] 3.1 Créer `FeatureSeeder` (`database/seeders/FeatureSeeder.php`) avec 4 items par défaut : Spécialiste Omra & Hajj, Guide bilingue, Hébergements sélectionnés, Assistance 24/7
- [x] 3.2 Ajouter l'appel `FeatureSeeder` dans `DatabaseSeeder`
- [x] 3.3 Lancer `php artisan db:seed --class=FeatureSeeder`

## 4. Backend — MoonShine Admin

- [x] 4.1 Créer `FeatureResource` (`app/MoonShine/Resources/FeatureResource.php`) avec indexFields (ID, titre, icône, actif, position), formFields (titre requis, icône, actif, position), detailFields
- [x] 4.2 Enregistrer `FeatureResource` dans `MoonShineServiceProvider`
- [x] 4.3 Ajouter le menu "Arguments" dans `MoonShineLayout`

## 5. Frontend — Type et API

- [x] 5.1 Ajouter le type `Feature` dans `src/types/index.ts` (title, icon, position)
- [x] 5.2 Ajouter `fetchFeatures()` dans `src/lib/api.ts` avec revalidate 300

## 6. Frontend — Composant WhyChooseSection

- [x] 6.1 Créer `src/components/WhyChooseSection.tsx` (Server Component async) qui fetch les features et affiche une section avec heading + grille responsive (2 cols mobile, 4 cols desktop)
- [x] 6.2 Chaque carte affiche l'icône SVG (via dangerouslySetInnerHTML sur le path) et le titre
- [x] 6.3 Retourner null si aucune feature ou erreur API

## 7. Frontend — Intégration homepage

- [x] 7.1 Ajouter `<WhyChooseSection />` dans `src/app/page.tsx` en dessous de `<PageSection slug="a-propos" />`

## 8. Vérification

- [x] 8.1 Lancer `npx tsc --noEmit` pour valider l'absence d'erreurs TypeScript
- [x] 8.2 Vérifier que la route `GET /api/features` apparait dans `php artisan route:list --path=api`
