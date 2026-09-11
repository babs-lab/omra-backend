## Context

Le site public (Next.js + TailwindCSS) affiche déjà une section partenaires (« Ils nous font confiance ») rendue au niveau du layout, juste avant le footer. Le backend Laravel expose une API RESTful avec des resources MoonShine pour chaque modèle (pattern `Partner` : modèle + migration + resource + contrôleur API + seeder). Ce change ajoute la gestion des témoignages de bout en bout en suivant les patterns existants, et ajoute un carousel frontend implémenté nativement (aucune dépendance).

La charte graphique est définie par le thème Tailwind : or `--color-gold: #BB9B2F`, or clair `--color-gold-hover: #D4AF37`, bleu nuit `--color-night: #0E2444`, fonds beige `#FCF6F0`/`#F9ECDA`, typographies Outfit (sans) et Pridi (heading). Le style « fancy » attendu reprend ces codes : titres Pridi, accents dorés, filets décoratifs dorés, badges arrondis.

Le style de témoignage de référence (manasikomra.fr) : section « Ils nous ont fait confiance » avec cartes présentant une citation entre guillemets, un avatar (photo ou placeholder), un prénom/nom, et une ville. Un carousel permet de faire défiler les témoignages.

## Goals / Non-Goals

**Goals:**
- Modèle `Testimonial` avec migration, resource MoonShine, et endpoint API `GET /api/testimonials`
- Section témoignages en grille **25/75** placée juste en dessous de « Ils nous font confiance » : titre « fancy » à gauche, carousel de cartes à droite
- Carousel natif (auto-défilement, flèches, points) activé quand la liste est longue ; grille statique sinon
- Page dédiée `/temoignages` listant tous les témoignages, accessible depuis le menu
- Activation/désactivation et ordonnancement des témoignages

**Non-Goals:**
- Modération / workflow de validation avancé (le champ actif suffit)
- Multi-langue des contenus
- Ajout d'une bibliothèque de carousel (Swiper/Embla) : implémentation React/Tailwind native
- Note moyenne calculée ou agrégats (uniquement affichage d'une note par témoignage, optionnelle)

## Decisions

| Décision | Choix | Raison |
|---|---|---|
| Modèle de données | Table `testimonials` : `name` (string), `city` (string nullable), `content` (text), `rating` (tinyint nullable 1-5), `avatar` (string nullable), `position` (integer default 0), `is_active` (boolean default true) | Suit le pattern `partners` ; couvre le style manasikomra (citation + auteur + ville) et ajoute une note optionnelle |
| Avatar | MoonShine `Image` field avec `->dir('testimonials')`, extensions jpg/jpeg/png/webp ; accesseur `avatar_url` (`Storage::disk('public')->url()`). Fallback frontend : initiales de l'auteur dans un cercle doré | Cohérent avec `PartnerResource`/`LogoPreview` ; évite d'exiger une photo pour chaque témoignage |
| Note | Champ `rating` optionnel (1-5) ; rendu d'étoiles dorées (`★`) ou masquées si absent | Preuve sociale renforcée, sans complexité de calcul |
| Activation / ordre | Booléen `is_active` + scope `active()` et colonne `position` + tri global, identiques au pattern `Partner` | L'API filtre les actifs, le tri est déterministe |
| Endpoint API | `GET /api/testimonials` retourne `name`, `city`, `content`, `rating`, `avatar`, `avatar_url`, `position` pour les actifs triés par position | Suit le pattern `GET /api/partners` |
| Placement section | `TestimonialSection` rendue dans `layout.tsx` juste après `<PartnerSection />` (et avant `<Footer />`) | Garantit « juste en dessous de la section Ils nous font confiance » sur la page d'accueil, cohérent avec le pattern partenaires (brique de confiance du layout). Alternative écartée : placement uniquement dans `page.tsx` → la section apparaîtrait au-dessus des partenaires, contrairement à l'exigence |
| Grille 25/75 | Conteneur `grid md:grid-cols-4` : colonne gauche `md:col-span-1` (titre fancy : badge, titre Pridi, filet doré, ornement SVG), colonne droite `md:col-span-3` (carousel) | Répond à l'exigence visuelle 25/75 avec la charte existante |
| Carousel | Composant client `TestimonialCarousel` : piste `flex` avec `transform: translateX(-index * (100/perView)%)`, `perView` responsive (1 mobile / 2 md / 3 lg), auto-défilement ~5 s en pause au survol, flèches et points de navigation | Aucune dépendance, léger et maîtrisé ; seuil : si `total <= perView` → grille statique sans contrôles |
| Page `/temoignages` | Composant serveur `src/app/temoignages/page.tsx` : hero fancy (badge, titre Pridi, filet doré), grille de cartes `columns-1 md:columns-2 lg:columns-3`, `metadata` titre « Témoignages » | Cohérent avec `blog/page.tsx` et `omra/[slug]` (fetch serveur + revalidate) |
| Menu | Ajout `{ label: "Témoignages", href: "/temoignages" }` dans `Header.tsx` (liste codée en dur `rightLinks`) + entrée `MenuItem` dans `MenuItemSeeder` (position 5, « Blog » passe en 6, « Contact » en 7) | Le header n'utilise pas encore `/api/menus` ; on garde la source unique actuelle et la cohérence avec le seeder/API |
| Revalidation | `fetch` avec `{ next: { revalidate: 300 } }` | Cache 5 minutes, cohérent avec `fetchPartners()`/`fetchMenus()` |
| Seeder | `TestimonialSeeder` avec 5-6 témoignages d'exemple (noms, villes françaises, citations) appelé depuis `DatabaseSeeder` | Permet de tester immédiatement le carousel (liste longue) |

## Risks / Trade-offs

- **API indisponible ou vide** → La section ne s'affiche pas (graceful degradation). Mitigation : `fetch(...).catch(() => [])` et retour `null` si liste vide (pattern `PartnerSection`).
- **Avatar manquant** → Carte rendue avec un avatar « initiales » (2 premières lettres du nom) dans un cercle or. Mitigation : condition sur `avatar_url` dans `TestimonialCard`.
- **Revalidation ISR (5 min)** → Un témoignage activé/désactivé peut mettre 5 minutes à apparaître/disparaître. Mitigation : acceptable ; `revalidatePath`/`revalidateTag` envisageable plus tard.
- **Carousel natif vs bibliothèque** → Comportement plus simple (pas de swipe tactile, pas d'a11y poussée). Mitigation : gère flèches + points + pause au survol ; évoluer vers Swiper/Embla si besoin de swipe tactile.
- **Header codé en dur** → Le menu frontend et le seeder peuvent diverger. Mitigation : documenté, entrée ajoutée aux deux endroits ; bascule sur `/api/menus` hors périmètre.
- **Encodage des accents/guillemets dans les témoignages** → Les citations avec guillemets français et accents doivent rester en UTF-8. Mitigation : colonnes `text` MySQL utf8mb4 et API JSON UTF-8 (pattern existant).

## Migration Plan

1. Créer la migration `create_testimonials_table`
2. Créer le modèle `Testimonial` (fillable, casts, scope `active()`, accesseur `avatar_url`, tri global par position)
3. Créer `TestimonialResource` MoonShine et l'enregistrer dans `MoonShineServiceProvider`
4. Créer `TestimonialController` + route `GET /api/testimonials`
5. Créer `TestimonialSeeder` et l'appeler dans `DatabaseSeeder` ; ajouter l'entrée menu dans `MenuItemSeeder`
6. Côté frontend : type `Testimonial`, `fetchTestimonials()`, `TestimonialCard`, `TestimonialCarousel`, `TestimonialSection` (intégrée dans `layout.tsx`)
7. Créer la page `app/temoignages/page.tsx` et ajouter le lien dans `Header.tsx`
8. Exécuter `php artisan migrate --seed` et vérifier `GET /api/testimonials` + rendu frontend

## Open Questions

- Placement : la section témoignages apparaîtra sur **toutes** les pages (layout) et pas uniquement sur la page d'accueil. Si un placement exclusif à l'accueil est souhaité, il faudra le préciser avant implémentation.
- Note : le champ `rating` (étoiles) est optionnel ; à retirer si non souhaité.
