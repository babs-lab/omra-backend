## Context

Le Header Next.js affiche actuellement 5 liens de navigation codés en dur dans `frontend/src/components/Header.tsx`. Le backend MoonShine ne possède pas de modèle ni d'interface pour gérer ces menus. L'objectif est d'ajouter un système de gestion de menus dans MoonShine et de les exposer via l'API REST pour le frontend.

## Goals / Non-Goals

**Goals:**
- Modèle `MenuItem` avec migration, resource MoonShine, et endpoint API
- Header Next.js dynamique consommant `GET /api/menus`
- Ordonnancement manuel des éléments (drag & drop dans MoonShine)
- Activation/désactivation individuelle des éléments

**Non-Goals:**
- Menu multi-niveaux (sous-menus) dans cette version
- Traduction multi-langue des libellés
- Cache serveur avancé (le revalidate ISR suffit)

## Decisions

| Décision | Choix | Raison |
|---|---|---|
| Ordonnancement | Colonne `position` (integer) + trait `Sortable` MoonShine | MoonShine supporte nativement le tri via `ModelResource` avec `Sortable` trait |
| URLs internes | Champ `route` (VARCHAR) stockant le chemin relatif (`/omra`, `/contact`) | Simple, pas de transformation frontend ; les URLs externes utilisent un champ `url` séparé |
| Activation | Booléen `is_active` avec scope globale sur le modèle | Évite de requêter les éléments inactifs côté API |
| Endpoint API | `GET /api/menus` retourne la liste ordonnée des éléments actifs | Suit le pattern existant des autres endpoints |
| Revalidation | `fetch` avec `{ next: { revalidate: 300 } }` côté Next.js | Cache les menus 5 minutes, cohérent avec le pattern `fetchPage` |
| Type d'élément | Un booléen `is_external` distingue lien interne (`route`) vs externe (`url`) | Évite une colonne polymorphique complexe |

## Risks / Trade-offs

- **Changement de structure** → Le Header passe d'un tableau statique à un appel asynchrone. Si l'API est down au premier render, le menu est vide. Mitigation : fallback avec un tableau statique des liens essentiels (Accueil, Contact).
- **Revalidation ISR** → En cas de changement de menu dans MoonShine, le frontend peut mettre jusqu'à 5 minutes à voir le changement. Mitigation : acceptable pour ce besoin (pas temps réel), ou utiliser `revalidateTag` plus tard si nécessaire.
