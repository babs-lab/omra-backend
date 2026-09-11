## 1. Préparation backend

- [x] 1.1 Vérifier que le seeder `MenuItemSeeder` contient les 6 items avec les bonnes routes (`/`, `/omra`, `/blog/ramadan-2027`, `/blog`, `/temoignages`, `/contact`) et des `position` ordonnées
- [x] 1.2 Re-lancer le seeder pour s'assurer que les données sont cohérentes avec les routes du frontend (`php artisan db:seed --class=MenuItemSeeder`)

## 2. Type TypeScript et API client

- [x] 2.1 Ajouter le type `MenuItem` manquant dans `src/types/index.ts` (vérifier qu'il correspond aux champs retournés par l'API : `label`, `route`, `url`, `is_external`, `position`)
- [x] 2.2 Vérifier que la fonction `fetchMenus()` existe dans `src/lib/api.ts` et retourne `MenuItem[]`

## 3. Refonte du composant Header

- [x] 3.1 Transformer `Header.tsx` en Server Component qui reçoit `items: MenuItem[]` en props
- [x] 3.2 Extraire la partie interactive du menu mobile dans un sous-composant `MobileMenu` (Client Component) avec état `open/close`
- [x] 3.3 Rendre les liens de navigation desktop dynamiquement depuis `items` : liens internes via `<Link>`, liens externes via `<a target="_blank">`
- [x] 3.4 Implémenter la logique de highlighting : match exact pour `/`, prefix match pour les autres routes

## 4. Layout racine

- [x] 4.1 Modifier `src/app/layout.tsx` pour appeler `fetchMenus()` côté serveur
- [x] 4.2 Passer les items de menu au composant `Header` via props
- [x] 4.3 Ajouter `.catch(() => [])` sur l'appel `fetchMenus()` pour gérer les erreurs API

## 5. Menu mobile

- [x] 5.1 Créer le composant `src/components/MobileMenu.tsx` (Client Component) avec bouton hamburger et overlay
- [x] 5.2 Rendre les mêmes items de menu dynamiquement dans le menu déroulant mobile
- [x] 5.3 Fermer le menu au clic sur un lien

## 6. Vérification et cohérence

- [x] 6.1 Vérifier que le type `MenuItem` côté frontend est bien utilisé dans `src/lib/api.ts` (import)
- [x] 6.2 Tester que la navbar affiche les 6 liens sur desktop et mobile
- [x] 6.3 Vérifier que désactiver un item dans MoonShine le masque côté frontend
- [x] 6.4 Vérifier que l'ordre des liens suit le champ `position`
- [x] 6.5 Lancer `npx tsc --noEmit` pour valider l'absence d'erreurs TypeScript
