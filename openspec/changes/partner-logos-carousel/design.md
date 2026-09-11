## Context

La section partenaires (`frontend/src/components/PartnerSection.tsx`) est un composant serveur Next.js qui récupère les partenaires actifs via `GET /api/partners` et les affiche en grille `flex-wrap`. Comportement actuel : logos statiques, wrap sur plusieurs lignes si nombreux.

Le frontend utilise Next.js 16 (App Router, React 19) + Tailwind CSS 4 via PostCSS (`@import "tailwindcss"`). Le CSS global (`globals.css`) contient déjà des keyframes (`fade-up`) : le projet privilégie les animations CSS natives, sans bibliothèque UI. Aucune dépendance de carousel n'est installée.

## Goals / Non-Goals

**Goals:**
- Afficher les logos partenaires dans une bande horizontale qui défile automatiquement en boucle (marquee).
- Boucle fluide et infinie, sans retour visible (saut de position).
- Pause de l'animation au survol d'un logo (coursor) pour permettre la lecture des libellés.
- Respecter `prefers-reduced-motion` : pas d'animation, tous les logos visibles statiquement.
- Conserver les exigences existantes : liens `target="_blank"` + `rel="noopener noreferrer"`, section masquée si aucun partenaire, affichage du nom texte si pas de logo.

**Non-Goals:**
- Remplacer le jeu de données ou l'API (back/front restent découplés via `/api/partners`, inchangé).
- Ajouter une navigation manuelle (flèches/pagination) — hors périmètre, le marquee est auto-défilant.
- Charger une bibliothèque de carousel ou d'animations (l'approche CSS natif est suffisante et plus légère).

## Decisions

### D1. Marquee CSS natif (animation + duplication) plutôt qu'une librairie JS
Le carousel est un simple défilement horizontal sans interaction de navigation. Une animation CSS `@keyframes` sur un track contenant les logos **dupliqués** (2 copies) et une translation de `-50%` produit une boucle infinie parfaitement fluide, sans JavaScript ni état.

- **Alternative écartée** : `embla-carousel`, `swiper` ou `react-slick` — ajoutent une dépendance pour une fonctionnalité purement décorative ; le composant serveur ne nécessite aucune logique client.
- **Alternative écartée** : scroll auto via `setInterval` + `scrollBy` — plus lourd, moins fluide, et le composant devrait devenir client.
- **Alternative écartée** : relever `README` d'un bloc pré-existant — concept de marquee éprouvé : duplication à `-50%` garantit une boucle sans saut.

Le composant reste un **Server Component** : il suffit de rendre les logos deux fois à l'intérieur du track animé.

### D2. Ordre et alignement du track
- Le track est un conteneur `flex` avec `width: max-content` et une animation `translateX(-50%)`. Les deux copies occupent chacune 50 % de la largeur totale → boucle parfaite.
- Gaps uniformes entre logos via `gap` sur le conteneur interne partagé par chaque copie.

### D3. Pause au survol
Sur `.group:hover`, aplicar `animation-play-state: paused` sur l'élément animé. Le survol se fait sur la section entière (`group`) pour une pause prévisible.

### D4. Accessibilité et réduction de mouvement
- `@media (prefers-reduced-motion: reduce)` : `animation: none`, le track passe en `flex-wrap` pour afficher tous les logos statiquement.
- Logos : `aria-label={partner.name}` (déjà en place sur les liens) ; le texte du titre "Ils nous font confiance" est conservé.
- La duplication du contenu est purement visuelle (même contenu rendu deux fois) — sans impact sémantique notable pour des images décoratives ; chaque logo reste un lien unique.

### D5. Masque de fondu aux bords (optionnel, retenu)
Appliquer un `mask-image` linéaire (transparent → opaque → transparent) horizontal pour un fondu élégant des bords du carousel. Dégradé via CSS, aucune image requise.

## Risks / Trade-offs

- [Track trop court si peu de logos → la boucle défile vite] → Dupliquer le contenu jusqu'à une largeur minimale (rendre la liste 2× puis répéter une 3e/4e copie si < 4 logos) ; ou accepter une vitesse lente constante. Décision : si moins de 4 partenaires, on duplique le track supplémentaire afin de garantir un remplissage fluide.
- [Animation continue distrayante / saccades sur basse charge] → `animation-play-state: paused` au survol + `prefers-reduced-motion` désactive tout ; utiliser `will-change: transform` uniquement sur l'élément animé pour limiter la re-composition.
- [Réduction du SEO : contenu rendu 2×] → Les partenaires sont des liens décoratifs externes ; la duplication est un artefact visuel standard des marquees. La preuve : les logos n'ont pas de texte d'indexation critique.

## Migration Plan

1. Mettre à jour `PartnerSection.tsx` (structure du marquee).
2. Ajouter la keyframe `marquee` + règles de pause/réduction de mouvement dans `globals.css`.
3. Vérification manuelle : rendu accueil, boucle fluide, pause au survol, absence de carousel si aucun partenaire, `prefers-reduced-motion`.
4. Rollback : `git revert` du composant — aucun changement de données ne rend le rollback risqué.

## Open Questions

- Vitesse du défilement cible (s pour un cycle complet) : 30 s retenu par défaut, ajustable via la durée de `animation-duration`.