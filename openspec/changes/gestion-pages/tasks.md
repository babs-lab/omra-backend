## 1. Backend — Migration enrichie

- [ ] 1.1 Créer la migration pour ajouter les colonnes à la table `pages` :
  - `is_published` (boolean, default false)
  - `cover_image` (string, nullable)
  - `layout` (string, default 'full')
  - `meta_description` (text, nullable)
- [ ] 1.2 Mettre à jour le modèle `Page` : ajouter `$fillable`, `$casts` (is_published => boolean)

## 2. Backend — MoonShine PageResource améliorée

- [ ] 2.1 Ajouter au formulaire `PageResource` :
  - `Switcher::make('Publiée', 'is_published')`
  - `Image::make('Image de couverture', 'cover_image')` (store dans `public/pages/`)
  - `Select::make('Disposition', 'layout')` avec options `['full' => 'Pleine largeur', 'sidebar' => 'Avec barre latérale']`
  - `Text::make('Meta description', 'meta_description')`
  - Remplacer `Textarea` par `TinyMDE::make('Contenu', 'content')` (éditeur WYSIWYG)
- [ ] 2.2 Ajouter les nouveaux champs aux vues `indexFields` et `detailFields`
- [ ] 2.3 Ajouter `$column = 'title'` si manquant pour les selects BelongsTo

## 3. Backend — API Pages enrichie

- [ ] 3.1 Ajouter `index()` à `PageController` : retourne toutes les pages publiées (GET /api/pages)
- [ ] 3.2 Modifier `show()` : ne retourner la page que si `is_published = true` (sinon 404)
- [ ] 3.3 Inclure les nouveaux champs (`cover_image`, `layout`, `meta_description`) dans les réponses API
- [ ] 3.4 Ajouter la route `GET /api/pages` dans `routes/api.php`

## 4. Frontend — Types et API Client

- [ ] 4.1 Mettre à jour l'interface `Page` dans `types/index.ts` :
  - `cover_image` (string | null)
  - `layout` ('full' | 'sidebar')
  - `meta_description` (string | null)
- [ ] 4.2 Ajouter la fonction `fetchPages(): Promise<Page[]>` dans `api.ts`

## 5. Frontend — Composant PageSection

- [ ] 5.1 Créer `frontend/src/components/PageSection.tsx` :
  - Props : `slug` (string), `showTitle` (boolean, default true)
  - Fetch la page par slug via `fetchPage()`
  - Affiche le H1 stylisé (Pridi, gold, tracking) si `showTitle`
  - Affiche l'image de couverture si présente
  - Affiche le contenu HTML
  - Applique la charte graphique (gold, beige, espacements, ombres)
  - Si `layout === 'sidebar'`, wrapper dans une grille 2 colonnes
  - Si page non trouvée → retourne `null` silencieusement

## 6. Frontend — Route pages/[slug]

- [ ] 6.1 Créer `frontend/src/app/pages/[slug]/page.tsx` :
  - `dynamic = 'force-dynamic'`
  - `generateMetadata` avec `meta_description` si présente
  - Affiche la page complète avec le `PageSection` composant
  - Styliser la section : fond beige/blanc, padding généreux, H1 gold/charte

## 7. Frontend — Intégration dans les pages existantes

- [ ] 7.1 Ajouter une section "Pourquoi nous choisir" (ou autre) sur la page d'accueil `page.tsx` via `<PageSection slug="pourquoi-nous-choisir" />` (en option, en dessous de la grille)
- [ ] 7.2 Mettre à jour `legal/[slug]/page.tsx` pour utiliser `PageSection` (évite la duplication de rendu)
- [ ] 7.3 Supprimer le style `prose` redondant — le composant `PageSection` gère le style

## 8. Seed

- [ ] 8.1 Créer/modifier un seeder `PageSeeder` avec les pages légales existantes (CGV, CGU, mentions légales) marquées `is_published = true`
