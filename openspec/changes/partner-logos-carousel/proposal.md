## Why

La section partenaires affiche actuellement les logos sous forme de grille statique (`flex-wrap`), ce qui sature l'espace vertical dès que le nombre de partenaires augmente. Un carousel défilant permet de présenter tous les logos dans une bande compacte et élégante, plus professionnelle et cohérente avec le reste de la page d'accueil.

## What Changes

- Remplacer la grille statique de `PartnerSection` par un carousel horizontal continu (marquee) de logos.
- Le carousel défile automatiquement (boucle infinie) avec pause au survol.
- Le contenu est dupliqué en interne pour garantir une boucle fluide sans retour visible.
- Respect de l'accessibilité : `prefers-reduced-motion` désactive l'animation automatique, logos rendus accessibles via `aria-label`.
- Garde le comportement existant : liens `target="_blank"` avec `rel="noopener noreferrer"`, section masquée si aucun partenaire.
- Aucune dépendance frontend supplémentaire : implémentation CSS/JS natif (Tailwind + animation keyframes existante ou React state).

## Capabilities

### New Capabilities
- `partner-logo-carousel`: Affichage des logos partenaires dans un carousel horizontal auto-défilant, avec pause au survol, boucle infinie et respect de `prefers-reduced-motion`.

### Modified Capabilities
<!-- Aucune modification de spec existante : le backend (API `/api/partners`) et les données restent inchangés. -->

## Impact

- **Frontend** : `frontend/src/components/PartnerSection.tsx` — refonte du rendu (carousel au lieu de la grille). Aucun changement de données.
- **Backend** : aucun changement (l'API `/api/partners` est déjà en place et reste inchangée).
- **Dépendances** : aucune nouvelle bibliothèque.
- **Tests** : vérification manuelle du rendu et du comportement (défilement, pause, boucle, mode réduit).