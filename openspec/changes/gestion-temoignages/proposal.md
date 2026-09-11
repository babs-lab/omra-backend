## Why

Le site affiche des partenaires mais aucune preuve sociale : pas de témoignages de pèlerins, alors que la confiance est un levier décisif dans l'achat d'un séjour Omra. L'équipe marketing doit pouvoir publier des témoignages sans intervention technique et les mettre en avant sur la page d'accueil, juste sous la section « Ils nous font confiance », ainsi que sur une page dédiée accessible depuis le menu.

## What Changes

- **Nouveau modèle `Testimonial`** dans le backend Laravel avec un resource MoonShine pour le CRUD (auteur, ville, contenu, note, avatar optionnel, ordre, statut actif).
- **Nouvel endpoint API** `GET /api/testimonials` exposant uniquement les témoignages actifs, triés par position.
- **Nouvelle section `TestimonialSection`** sur la page d'accueil, affichée juste en dessous de la section « Ils nous font confiance », organisée en 2 grilles **25/75** :
  - partie gauche (25 %) : titre stylisé « fancy » respectant la charte graphique (accent doré, typographie heading Pridi, filet décoratif) ;
  - partie droite (75 %) : témoignages dans le style de manasikomra.fr (carte avec citation, avatar, auteur, ville) avec un **effet carousel** dès que la liste dépasse quelques témoignages.
- **Nouvelle page `/temoignages`** listant tous les témoignages avec un style « fancy » respectant la charte graphique.
- **Entrée de menu « Témoignages »** ajoutée dans le header (`Header.tsx`) et dans le seeder `MenuItemSeeder` (cohérence avec l'API `/api/menus`).
- **Composant carousel** côté frontend (défilement automatique, flèches, points de navigation) ; rendu statique en grille si la liste est courte.

## Capabilities

### New Capabilities
- `testimonial-management`: CRUD des témoignages via MoonShine (auteur, ville, contenu, note, avatar, ordre, statut actif) + exposition des témoignages actifs via `GET /api/testimonials` + section d'accueil en grille 25/75 avec carousel + page dédiée `/temoignages` accessible depuis le menu

### Modified Capabilities
<!-- Aucune spec existante modifiée -->

## Impact

- **Backend (Laravel + Moonshine)** : nouveau modèle `Testimonial` + migration `create_testimonials_table` + `TestimonialResource` MoonShine enregistré dans `MoonShineServiceProvider` + `TestimonialController` + route `GET /api/testimonials` + seeder `TestimonialSeeder` + entrée `Témoignages` dans `MenuItemSeeder`.
- **Frontend (Next.js + TailwindCSS)** :
  - `src/types/index.ts` : nouveau type `Testimonial` ;
  - `src/lib/api.ts` : nouvelle fonction `fetchTestimonials()` ;
  - `src/components/TestimonialCard.tsx` : carte témoignage (citation, avatar/initiales, auteur, ville, note) ;
  - `src/components/TestimonialCarousel.tsx` : carousel client (auto-défilement, flèches, points) ou grille statique si liste courte ;
  - `src/components/TestimonialSection.tsx` : section 25/75 (titre fancy à gauche, carousel à droite) rendue sous « Ils nous font confiance » ;
  - `src/app/page.tsx` : intégration de `TestimonialSection` ;
  - `src/app/temoignages/page.tsx` : nouvelle page de listing ;
  - `src/components/Header.tsx` : ajout du lien « Témoignages » ;
- **API** : nouvelle route `GET /api/testimonials`.
- **Dépendances** : aucune nouvelle bibliothèque (carousel implémenté nativement en React/Tailwind).
