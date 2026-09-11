## Context

Le site public (Next.js) ne dispose d'aucune brique pour afficher des partenaires. Le backend Laravel expose déjà une API RESTful (`/api/packages`, `/api/menus`, `/api/pages`, etc.) avec des resources MoonShine pour chaque modèle. Ce change ajoute la gestion des partenaires de bout en bout, en suivant les patterns existants du projet (modèle `MenuItem`/`Page` avec champ actif, resource MoonShine, contrôleur API, composant frontend).

## Goals / Non-Goals

**Goals:**
- Modèle `Partner` avec migration, resource MoonShine, et endpoint API `GET /api/partners`
- Section partenaires dans le frontend, affichée juste en dessous du footer
- Activation/désactivation individuelle des partenaires (switcher MoonShine, exclusion de l'API quand inactif)
- Ordonnancement des partenaires (colonne `position`)

**Non-Goals:**
- Lien de destination propre à chaque partenaire avec statistiques de clic / tracking
- Multi-langue des libellés
- Cache serveur avancé (le `revalidate` ISR suffit, cohérent avec le reste du site)

## Decisions

| Décision | Choix | Raison |
|---|---|---|
| Modèle de données | Table `partners` : `name` (string), `logo` (string nullable), `url` (string nullable), `position` (integer default 0), `is_active` (boolean default true) | Suit le pattern `menu_items` ; couvre les besoins fonctionnels sans sur-engineering |
| Logo | MoonShine `Image` field avec `->dir('partners')`, extensions autorisées jpg/jpeg/png/webp/svg | Pattern identique à `PageResource`/`cover_image` |
| Aperçu du logo | Champ dédié `App\MoonShine\Fields\LogoPreview` (étend `Image`, surcharge `resolvePreview()`) dans `indexFields` et `detailFields` : rend un `<img>` dimensionné (`max-height:56px`, `max-width:140px`, `object-fit:contain`, bordure, padding) | Les vignettes par défaut de MoonShine (40×40, `object-cover`) recadrent les logos ; un conteneur dimensionné avec `object-fit:contain` les affiche intacts |
| Exposition de l'URL logo | Accesseur `logo_url` sur le modèle retournant `Storage::disk('public')->url($this->logo)` | Garantit une URL absolue résolvable côté frontend (évite la résolution manuelle de `/storage/...`) |
| Activation | Booléen `is_active` + scope `active()` sur le modèle | Pattern `MenuItem` existant ; l'API filtre uniquement les actifs |
| Ordonnancement | Colonne `position` (integer) + tri par défaut via scope global | Pattern `MenuItem` (drag & drop / saisie manuelle via MoonShine) |
| Endpoint API | `GET /api/partners` retourne `name`, `logo`, `logo_url`, `url`, `position` pour les actifs triés par position | Suit le pattern `GET /api/menus` |
| Lien externe | Champ `url` optionnel ; rendu `target="_blank"` + `rel="noopener noreferrer"` si renseigné | Sécurité et ouverture en nouvel onglet pour les sites partenaires |
| Placement frontend | Composant serveur `PartnerSection` rendu dans `layout.tsx` juste après `<Footer />` | L'utilisateur veut la section "juste en dessous du footer" ; rendu dans le layout = visible sur toutes les pages |
| Revalidation | `fetch` avec `{ next: { revalidate: 300 } }` | Cache 5 minutes, cohérent avec `fetchMenus()`/`fetchPage()` |
| Absence de partenaires | La section retourne `null` si la liste est vide ou si l'API échoue | Ne bloque pas le rendu du site, rendu dégradé propre |

## Risks / Trade-offs

- **API indisponible ou vide** → La section ne s'affiche pas (graceful degradation). Mitigation : `fetch(...).catch(() => [])` et retour `null` si liste vide.
- **Logo manquant** → La carte est rendue avec le nom du partenaire en fallback texte. Mitigation : condition sur `logo`/`logo_url` dans le composant.
- **Revalidation ISR (5 min)** → Un partenaire activé/désactivé dans MoonShine peut mettre jusqu'à 5 minutes avant d'apparaître/disparaître en production. Mitigation : acceptable pour ce besoin ; possible `revalidatePath`/`revalidateTag` plus tard si besoin temps réel.
- **Chemin de logo (path stocké) exposé brut** → Évité en exposant `logo_url` via accesseur, le frontend n'a jamais à construire l'URL.

## Migration Plan

1. Créer la migration `create_partners_table`
2. Créer le modèle `Partner` (fillable, casts, scope `active()`, accesseur `logo_url`, tri par défaut)
3. Créer `PartnerResource` MoonShine et l'enregistrer dans `MoonShineServiceProvider`
4. Créer `PartnerController` et la route `GET /api/partners`
5. Créer le type `Partner`, `fetchPartners()`, et le composant `PartnerSection` côté frontend
6. L'intégrer dans `layout.tsx` sous le footer

## Open Questions

- Aucune : les besoins sont clairs (nom, logo, URL, activation, ordre, affichage sous le footer).
