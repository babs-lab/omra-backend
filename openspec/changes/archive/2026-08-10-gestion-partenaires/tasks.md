## 1. Backend — Modèle & Migration

- [x] 1.1 Créer la migration `create_partners_table` avec colonnes : `name` (string), `logo` (string, nullable), `url` (string, nullable), `position` (integer, default 0), `is_active` (boolean, default true)
- [x] 1.2 Créer le modèle `App\Models\Partner` avec `$fillable`, casts booléens, scope `active()`, accesseur `logo_url` (via `Storage::disk('public')->url()`), et tri par défaut sur `position`

## 2. Backend — MoonShine Resource

- [x] 2.1 Créer `App\MoonShine\Resources\PartnerResource` avec `ModelResource`, champs `ID`, `Text` (name), `Image` (logo, dir `partners`, extensions jpg/jpeg/png/webp/svg), `Url` (url), `Switcher` (is_active), `Number` (position, sortable)
- [x] 2.1b Créer `App\MoonShine\Fields\LogoPreview` (étend `Image`, surcharge `resolvePreview()` pour un aperçu logo dimensionné) et l'utiliser dans `indexFields`/`detailFields` du `PartnerResource`
- [x] 2.2 Enregistrer le resource dans `MoonShineServiceProvider`
- [x] 2.3 Ajouter le partenaire au sidebar admin dans `MoonShineLayout` (si le layout liste les resources explicitement)

## 3. Backend — API Endpoint

- [x] 3.1 Créer `App\Http\Controllers\Api\PartnerController` avec méthode `index()` retournant les partenaires actifs triés par position (champs : `name`, `logo`, `logo_url`, `url`, `position`)
- [x] 3.2 Ajouter la route `GET /api/partners` dans `routes/api.php`

## 4. Frontend — Type & API Client

- [x] 4.1 Ajouter l'interface `Partner` dans `frontend/src/types/index.ts` (`name`, `logo`, `logo_url`, `url`, `position`)
- [x] 4.2 Ajouter la fonction `fetchPartners()` dans `frontend/src/lib/api.ts`

## 5. Frontend — Section Partenaires

- [x] 5.1 Créer `frontend/src/components/PartnerSection.tsx` : composant serveur qui appelle `fetchPartners()`, retourne `null` si vide ou en erreur, et affiche les logos en grille (lien externe `target="_blank"` + `rel="noopener noreferrer"` si `url` renseigné, fallback texte sur le nom si pas de logo)
- [x] 5.2 Intégrer `<PartnerSection />` dans `frontend/src/app/layout.tsx` juste après `<Footer />`
- [x] 5.3 Styliser la section selon la charte graphique (fond beige/blanc, espacement, logos en hauteur uniforme)

## 6. Seeds & Tests

- [x] 6.1 Créer un seeder `PartnerSeeder` avec quelques partenaires (dont un inactif) pour valider le comportement
- [x] 6.2 Tester l'endpoint avec `GET /api/partners` et vérifier le tri, l'exclusion des inactifs, et la présence de `logo_url`
- [x] 6.3 Vérifier le rendu frontend (section visible sous le footer uniquement avec des partenaires actifs) et lancer lint + build Next.js
- [x] 6.4 Vérifier le rendu de `LogoPreview` (aperçu dimensionné avec URL complète) via un test script temporaire, puis le supprimer
