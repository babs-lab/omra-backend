## Context

Le frontend Next.js utilise un composant `Header.tsx` avec des liens de navigation hardcodés en constantes (`leftLinks`, `rightLinks`). Le backend Laravel possède déjà :
- Une table `menu_items` avec les champs `label`, `route`, `url`, `is_external`, `is_active`, `position`
- Un endpoint `GET /api/menus` qui retourne les items actifs triés par position
- Un resource MoonShine `MenuItemResource` pour la gestion admin
- Un seeder `MenuItemSeeder` avec 6 items prédéfinis

Le frontend ne consomme pas cet endpoint. La navigation est figée dans le code.

## Goals / Non-Goals

**Goals:**
- La navbar du frontend est rendue dynamiquement à partir de l'API `GET /api/menus`
- Les items avec `is_active = false` ne sont pas affichés
- L'ordre respecte le champ `position`
- Les liens internes (`route`) et externes (`url`) sont gérés correctement
- Le menu mobile utilise les mêmes données

**Non-Goals:**
- Pas de modification de l'API backend (déjà fonctionnelle)
- Pas de modification du resource MoonShine (déjà existant)
- Pas de gestion de sous-menus ou de mega-menu
- Pas de cache côté client pour les menus (les données changent rarement, ISR suffit)

## Decisions

### D1 : Fetch des menus côté serveur dans le layout racine
**Choix** : Appeler `fetchMenus()` dans `src/app/layout.tsx` (Server Component) et passer les données au `Header` via props.

**Pourquoi** : Le layout est un Server Component, le fetch s'exécute côté serveur. Pas de flash de contenu vide, bon SEO, pas de JavaScript supplémentaire côté client.

**Alternative considérée** : Fetch dans `Header` (Client Component) — rejeté car cela nécessiterait un `useEffect` + state, avec un état vide initial visible.

### D2 : Header passe de Client Component à Server Component
**Choix** : Transformer `Header.tsx` en Server Component qui reçoit les items de menu en props. Le bouton hamburger mobile nécessite un état local — extraire la partie interactive dans un sous-composant `MobileMenu` (Client Component).

**Pourquoi** : Réduit le JavaScript côté client. Seul le menu mobile interactif reste un Client Component.

**Alternative considérée** : Garder Header comme Client Component — rejeté car inutile quand le menu est statique après le render.

### D3 : Le menu Ramadan pointe vers `/blog/ramadan-2027`
**Choix** : Dans le seeder, s'assurer que l'item « Ramadan » a `route = '/blog/ramadan-2027'`. Le frontend traite toutes les `route` comme des liens internes Next.js (`<Link>`).

**Pourquoi** : Cohérence avec la structure de routes existante. Pas de logique spéciale nécessaire.

## Risks / Trade-offs

- **[Risque] Menu vide si l'API est indisponible** → Le layout utilise `.catch(() => [])` comme le reste du site. Si le menu est vide, le Header affiche uniquement le logo. Accepté car cas rare.
- **[Trade-off] Pas de cache menu** → Les menus changent rarement mais le fetch se fait à chaque requête. L'ISR avec `revalidate: 300` dans `api.ts` couvre ce cas. Accepté.
- **[Risque] Ordre des menus cassé par un admin** → Le `position` est géré dans MoonShine. Si un admin met deux fois la même position, l'ordre est non-déterministe. Mitigé par le tri SQL sur `position`.
