## Context

La homepage actuelle affiche un hero avec des badges de fonctionnalités (guides expérimentés, meilleurs tarifs, vols directs, hôtels proches du Haram) mais ces éléments sont hardcodés dans `page.tsx`. Il n'existe pas de section dédiée "Pourquoi nous choisir" avec une grille de caractéristiques gérables. Le site concurrent manasikomra.fr affiche une telle section avec 4 items (Spécialiste Omra & Hajj, Guide bilingue, Hébergements sélectionnés, Assistance 24/7).

Le backend possède déjà le pattern model→migration→controller→route→resource MoonShine→seeder, utilisé pour Testimonial, Partner, Post, etc.

## Goals / Non-Goals

**Goals:**
- Nouveau modèle `Feature` stockant titre, icône (SVG path), position et statut actif
- Endpoint public `GET /api/features` pour le frontend
- Resource MoonShine pour la gestion CRUD
- Composant frontend `WhyChooseSection` rendant une grille responsive
- Intégration sur la homepage entre les packages et les témoignages

**Non-Goals:**
- Pas de gestion de images uploadées pour les features (icônes SVG codées en dur dans le model ou le seeder)
- Pas de section dédiée page séparée — uniquement sur la homepage
- Pas de compteur animé (les stats comme "+4500 pèlerins" ne font pas partie de ce scope)

## Decisions

### D1 : Modèle simple sans image upload
**Choix** : Stocker les icônes comme des chemins SVG (`icon` string field) plutôt que des images uploadées.

**Pourquoi** : Les icônes de features sont des SVGs simples (check, star, shield, etc.). Les coder en dur dans le seeder est plus performant et évite la gestion de fichiers. Le field `icon` contient le path SVG.

### D2 : Composant Server Component
**Choix** : `WhyChooseSection` est un Server Component async qui fetch les features via `fetchFeatures()`.

**Pourquoi** : Cohérence avec les autres sections (TestimonialSection, PartnerSection). Pas d'interactivité nécessaire, le rendu est statique après fetch.

### D3 : Grille responsive 2 colonnes mobile, 4 colonnes desktop
**Choix** : Utiliser `grid grid-cols-2 lg:grid-cols-4` pour la grille des features.

**Pourquoi** : 4 items s'affichent parfaitement sur 4 colonnes en desktop et 2 en mobile, comme sur le site de référence.

## Risks / Trade-offs

- **[Risque] Nombre d'items limité par la grille** → Si un admin ajoute 8 items, la grille devient surchargée. Mitigé : le composant affiche tous les items, le design s'adapte avec `grid-cols-2 lg:grid-cols-4` et le wraping automatique.
- **[Trade-off] Icônes en dur** → Si un admin veut une icône personnalisée, il faudra modifier le seeder ou ajouter un champ. Accepté pour ce scope.
