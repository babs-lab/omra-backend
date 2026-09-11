## Why

Le site de référence (manasikomra.fr) dispose d'une section « Questions fréquentes » (FAQ) en accordéon qui rassure les visiteurs sur les points clés (visa, paiement, documents, accompagnement). Le site OUMRA TERANGA n'a pas encore cette section, pourtant très attendue dans le domaine de l'Omra. L'objectif : l'ajouter, avec un contenu gérable directement depuis Moonshine sans toucher au code.

## What Changes

- **Backend** :
  - Nouveau modèle et migration `faqs` (question, réponse, position, actif).
  - Nouvelle resource Moonshine `FaqResource` (CRUD dans l'admin, menu « FAQ »).
  - Nouvel endpoint public `GET /api/faqs` renvoyant les FAQ actives triées par position.
- **Frontend** :
  - Nouvelle fonction `fetchFaqs()` dans `src/lib/api.ts` et type `Faq` dans `src/types/index.ts`.
  - Nouveau composant serveur `FAQSection` (accordéon accessible : ouvrir/fermer une réponse, chevron animé) affiché sur la page d'accueil, comme sur le site de référence.
  - Section masquée si aucune FAQ ou erreur API.

## Capabilities

### New Capabilities
- `faq-management`: gestion des paires question/réponse via Moonshine, exposition via `GET /api/faqs` et rendu en accordéon sur la page d'accueil.

### Modified Capabilities
<!-- Aucune spec existante n'est modifiée : ajout d'une nouvelle capacité isolée. -->

## Impact

- **Backend** : migration `create_faqs_table`, modèle `Faq`, controller API `FaqController`, resource Moonshine `FaqResource` + enregistrement dans `MoonShineServiceProvider` et menu dans `MoonShineLayout`.
- **Frontend** : `src/types/index.ts`, `src/lib/api.ts`, `src/components/FAQSection.tsx`, ajout de la section sur `src/app/page.tsx`.
- **Dépendances** : aucune nouvelle bibliothèque.
- **Tests** : vérification manuelle (CRUD Moonshine, endpoint API, accordéon frontend + accessibilité).