## Context

Le site Omra Teranga utilise Next.js App Router avec un layout homepage codé en dur (`page.tsx`). Chaque section (hero, packages, à propos, pourquoi-chosir) est un composant fixe dans l'arborescence JSX. L'admin MoonShine gère le contenu des pages via le modèle `Page` (title, slug, content HTML), mais ne peut pas contrôler l'ordre ou la présence des sections sur une page.

Le frontend fetch les données via `cache: 'no-store'` pour des mises à jour instantanées depuis MoonShine.

## Goals / Non-Goals

**Goals:**
- Permettre à l'admin de créer des sections de contenu et de les placer sur n'importe quelle page
- Contrôler l'ordre d'affichage via un champ `position`
- Maintenir les composants dédiés existants (hero, packages) tout en permettant des sections dynamiques
- Affichage instantané des changements (cache: no-store)

**Non-Goals:**
- Pas de glisser-déposer pour réordonner (l'admin utilise le champ numérique `position`)
- Pas de gestion de templates ou de layouts complexes
- Pas de système de permissions par section

## Decisions

### Modèle Section avec target_page + position

**Alternative :** un modèle Page avec des "slots" nommés (ex: `homepage_hero`, `homepage_after_packages`)
**Rationale :** le système `target_page` + `position` est plus flexible — n'importe quelle page peut recevoir des sections, sans limitations de slots prédéfinis.

### Les sections dynamiques complètent les composants existants

**Décision :** la homepage affiche les composants dédiés (hero, packages) ET les sections dynamiques (ciblées sur `homepage`). Les sections dynamiques sont insérées entre les composants existants selon leur `position`.

**Rationale :** préserver la spec visuelle actuelle (hero avec image Kaaba, grille packages) tout en ajoutant la flexibilité CMS.

### API unique avec filtre target

**Décision :** un seul endpoint `GET /api/sections?target={slug}` retourne les sections actives d'une page, triées par position.

**Rationale :** simplicité, une seule requête API par page, compatible avec le pattern `cache: 'no-store'` du frontend.

## Risks / Trade-offs

- **[Position manuelle]** L'admin doit saisir un numéro de position → atténuer avec des indices visuels dans MoonShine (position actuelle, suggestions)
- **[Contenu double]** Certaines sections (packages) ont un rendu spécifique → les sections dynamiques sont pour du contenu HTML brut, pas pour des composants complexes
- **[Migration]** Les pages existantes n'ont pas de sections → créer des sections par défaut pour "a-propos" via un seeder
