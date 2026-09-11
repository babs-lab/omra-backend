## 1. Backend — Modèle et migration

- [x] 1.1 Créer la migration `create_sections_table` (id, title, slug, content longText, target_page string, position default 0, style default 'default', is_active default true, timestamps)
- [x] 1.2 Lancer `php artisan migrate`
- [x] 1.3 Créer le modèle `Section` (app/Models/Section.php) avec fillable, scope `active()`, tri par position

## 2. Backend — API et controller

- [x] 2.1 Créer `SectionController` (app/Http/Controllers/Api/SectionController.php) avec méthode `index()` filtrant par `target` query param, retournant les sections actives triées par position
- [x] 2.2 Ajouter la route `GET /api/sections` dans `routes/api.php`

## 3. Backend — MoonShine Admin

- [x] 3.1 Créer `SectionResource` (app/MoonShine/Resources/SectionResource.php) avec indexFields (ID, titre, target_page, position, actif), formFields (titre requis, slug, contenu Wysiwyg, target_page, position, style select, actif)
- [x] 3.2 Enregistrer `SectionResource` dans `MoonShineServiceProvider`
- [x] 3.3 Ajouter le menu "Sections" dans `MoonShineLayout`

## 4. Frontend — Type et API

- [x] 4.1 Ajouter le type `Section` dans `src/types/index.ts` (title, slug, content, target_page, position, style)
- [x] 4.2 Ajouter `fetchSections(target)` dans `src/lib/api.ts` avec `cache: 'no-store'`

## 5. Frontend — Composant DynamicSections

- [x] 5.1 Créer `src/components/DynamicSections.tsx` (Server Component async) qui prend un prop `target`, fetch les sections et les affiche en ordre de position
- [x] 5.2 Chaque section est rendue comme un `<section>` avec le contenu HTML, supporte les styles 'default', 'dark', 'gold'
- [x] 5.3 Retourner null si aucune section

## 6. Frontend — Intégration homepage

- [x] 6.1 Ajouter `<DynamicSections target="homepage" />` dans `src/app/page.tsx` à la fin (après WhyChooseSection)
- [x] 6.2 Déplacer les positions existantes si nécessaire pour laisser de la place aux sections dynamiques

## 7. Vérification

- [x] 7.1 Lancer `npx tsc --noEmit` pour valider l'absence d'erreurs TypeScript
- [x] 7.2 Vérifier que la route `GET /api/sections` apparait dans `php artisan route:list --path=api`
- [x] 7.3 Créer une section de test via MoonShine et vérifier qu'elle s'affiche sur la homepage
