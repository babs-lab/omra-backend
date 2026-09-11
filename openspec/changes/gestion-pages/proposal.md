## Why

Le site affiche actuellement des pages légales (`/legal/cgv`, `/legal/cgu`, `/mentions-legales`) via un modèle `Page` basique (titre, slug, contenu). Il n'existe aucun moyen simple pour l'agence de :

- Créer de nouvelles pages depuis l'admin sans intervention développeur (ex. "Nos valeurs", "FAQ", "À propos")
- Afficher ces pages ailleurs que sous le préfixe `/legal/`
- Réutiliser du contenu éditable comme sections dans des pages existantes (ex. section "Pourquoi nous choisir" sur la page d'accueil)
- Personnaliser la mise en page d'une page (image de couverture, mise en avant, disposition)

L'agence a besoin d'un vrai CMS de pages pour gérer son contenu éditorial de manière autonome.

## What Changes

- **Migration et modèle `Page` enrichi** : ajout de colonnes `is_published`, `cover_image`, `layout` (full/sidebar), `meta_description`, pour des pages plus riches
- **MoonShine Resource améliorée** : formulaire complet avec preview du slug, toggle de publication, upload d'image de couverture, éditeur wysiwyg pour le contenu
- **Route frontend dynamique** : `GET /pages/{slug}` → affiche n'importe quelle page publiée sous une URL propre (pas seulement `/legal/`)
- **Composant `<PageSection />` réutilisable** : composant Next.js pour intégrer une page (ou une section) dans n'importe quelle page du site avec H1 stylisé charte graphique
- **Migration de données** : les pages légales existantes restent accessibles et gagnent les nouveaux champs

## Capabilities

- `gestion-pages` : CRUD complet des pages dans MoonShine + affichage frontend flexible

## Impact

- **Backend** : Migration pour enrichir la table `pages`. Mise à jour de `PageResource` (MoonShine). Mise à jour du `PageController` API (retourner `is_published`, `cover_image`, layout).
- **Frontend** : Nouveau composant `<PageSection />`. Nouveau dossier `app/pages/[slug]/`. Mise à jour de `Page` dans les types. Mise à jour de l'`api.ts`. Stylisation du rendu des pages (H1, couverture, contenu).
- **SEO** : `generateMetadata` pour chaque page avec `meta_description`.
