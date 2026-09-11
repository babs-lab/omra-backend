## Context

Le site dispose déjà d'un modèle `Page` basique (title, slug, content), d'une resource MoonShine associée et d'un endpoint API `GET /api/pages/{slug}`. Les pages sont actuellement affichées uniquement sous le préfixe `/legal/[slug]` avec un rendu minimal (h1 standard, prose basique).

L'agence souhaite :
- Gérer les pages de contenu de manière autonome (pas seulement les pages légales)
- Pouvoir créer des pages à URL personnalisée (ex. `/a-propos`, `/faq`, `/nos-valeurs`)
- Disposer d'un composant réutilisable pour intégrer du contenu éditable dans n'importe quelle page du site
- Un rendu soigné conforme à la charte graphique (gold, Pridi, beige, ombres douces)

## Goals / Non-Goals

**Goals:**
- Enrichir la table `pages` avec `is_published`, `cover_image`, `layout`, `meta_description`
- Mettre à jour `PageResource` MoonShine avec les nouveaux champs + éditeur WYSIWYG pour le contenu
- Ajouter un endpoint `GET /api/pages` listant les pages publiées
- Ajouter une route frontend `/pages/[slug]` pour afficher une page en standalone
- Créer un composant `<PageSection />` pour intégrer une page/section dans n'importe quelle page existante
- Styliser le rendu (H1 gold/heading, image de couverture, typographie soignée) selon la charte graphique

**Non-Goals:**
- Hiérarchie de pages (parent/enfant) ou arborescence
- Versionnage ou historique des pages
- Pages multi-langues
- Blocs de contenu avancés (colonnes, galeries, etc.) — le contenu reste en HTML libre via WYSIWYG
- Pages protégées par mot de passe ou réservées aux connectés

## Decisions

| Décision | Choix | Raison |
|---|---|---|
| Nouveaux champs | Migration additive (ALTER TABLE) | Aucune perte de données ; rétrocompatible |
| Image de couverture | Stockage local `storage/app/public/pages/` | Simple, pas besoin de CDN externe |
| Layout | `'full'` (pleine largeur) ou `'sidebar'` (avec barre latérale) | Flexibilité sans complexité |
| Publication | `is_published` boolean (défaut false) | Les pages sont draft tant qu'elles ne sont pas publiées |
| URL publique | `/pages/{slug}` plutôt que `/legal/{slug}` | Les pages ne sont pas que légales. Préservation de `legal/[slug]` par redirection ou alias |
| Composant PageSection | Props: `slug` (string), `showTitle` (boolean, default true) | Simple à utiliser : `<PageSection slug="pourquoi-nous-choisir" />` |
| WYSIWYG MoonShine | Utiliser le champ `TinyMDE` ou `Markdown` natif de MoonShine | Pas de dépendance externe supplémentaire |

## Risks / Trade-offs

- **Pages existantes** → Les pages légales (CGV, CGU, mentions) existent déjà. La migration additive ne les casse pas. Leur rendu via `legal/[slug]` est préservé, et elles seront aussi accessibles via `pages/[slug]`.
- **Sécurité** → L'API `GET /api/pages` ne doit exposer que les pages `is_published = true`. L'endpoint `GET /api/pages/{slug}` doit renvoyer une 404 si la page n'est pas publiée (sauf si authentifié admin).
- **Contenu HTML** → Le contenu en HTML libre via WYSIWYG peut contenir des scripts ou styles dangereux. MoonShine gère le nettoyage côté admin. Côté frontend, `dangerouslySetInnerHTML` est déjà utilisé pour les pages légales — même approche.
