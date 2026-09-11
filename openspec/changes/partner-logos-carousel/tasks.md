## 1. Styles du carousel

- [x] 1.1 Ajouter la keyframe `marquee` (translation `-50%` de 0) dans `frontend/src/app/globals.css`, avec une classe `.animate-marquee` définissant `animation: marquee 30s linear infinite`, `will-change: transform`
- [x] 1.2 Ajouter la règle de pause au survol (`.group-hover` → `animation-play-state: paused`) sur l'élément animé
- [x] 1.3 Ajouter la règle `@media (prefers-reduced-motion: reduce)` désactivant l'animation et rétablissant un affichage statique (flex-wrap, tous les logos visibles)
- [x] 1.4 Ajouter un masque de fondu horizontal (`mask-image` linéaire) sur le conteneur du carousel

## 2. Refonte du composant PartnerSection

- [x] 2.1 Restructurer `frontend/src/components/PartnerSection.tsx` : convertir la grille `flex-wrap` en track horizontal (`flex`, `max-content` + class carousel) dans un conteneur `.group` avec overflow masqué
- [x] 2.2 Rendre les logos en deux copies identiques du contenu partenaire pour la boucle infinie et appliquer `gap`/espacement uniforme entre logos
- [x] 2.3 Si moins de 4 partenaires, répéter le contenu supplémentaire afin de garantir une largeur de track suffisante pour une boucle fluide
- [x] 2.4 Conserver le rendu des liens externes : `target="_blank"`, `rel="noopener noreferrer"`, `aria-label={partner.name}` et le fallback texte si `logo_url` absent
- [x] 2.5 Conserver le comportement existant : retour `null` si aucun partenaire ou erreur API, titre "Ils nous font confiance" inchangé

## 3. Vérification

- [x] 3.1 Lancer `npm run lint` dans `frontend/` et corriger les erreurs éventuelles
- [x] 3.2 Lancer un build de vérification (`npm run build` dans `frontend/`)
- [ ] 3.3 Tester manuellement sur l'accueil : défilement continu en boucle, pause au survol, fondu aux bords, et absence de la section si aucun partenaire
- [ ] 3.4 Tester le mode `prefers-reduced-motion` (DevTools → emulation) : logos statiques tous visibles, aucune animation