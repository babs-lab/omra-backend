## Why

L'interface d'administration MoonShine utilise des champs `Textarea` simples pour les contenus riches (descriptions de packages, hôtels, articles de blog, pages, témoignages). Ces champs n'offrent aucun formatage (gras, italique, liens, listes, images), ce qui oblige les administrateurs à écrire du HTML brut ou à se contenter de texte non formaté. Un éditeur WYSIWYG est indispensable pour un CMS moderne.

## What Changes

- Installation du package `moonshine/tinymce` (compatible MoonShine 4.x)
- Création d'un champ personnalisé `Wysiwyg` étendant la logique MoonShine
- Remplacement de `Textarea::make()` par `Wysiwyg::make()` dans les resources :
  - `PackageResource` (description)
  - `HotelResource` (description)
  - `PostResource` (content)
  - `PageResource` (content)
  - `TestimonialResource` (content)

## Capabilities

### New Capabilities
- `wysiwyg-editor`: Champ éditeur riche TinyMCE pour l'administration MoonShine, utilisable dans toutes les resources avec contenus textuels.

### Modified Capabilities

## Impact

- **Dépendances** : ajout de `moonshine/tinymce` via Composer
- **Backend** : nouveau fichier `app/MoonShine/Fields/Wysiwyg.php`, modifications dans 5 Resource files
- **Frontend** : aucun impact (les données restent du HTML stocké en BDD)
- **API** : aucun changement de contrat
