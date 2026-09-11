## Context

L'admin MoonShine (v4.18.1) utilise des champs `Textarea` natifs pour les contenus textuels (descriptions, articles, pages). Ces champs ne supportent aucun formatage riche. Le package officiel `moonshine/tinymce` (v2.x) est disponible et compatible avec MoonShine 4.x.

5 resources sont concernées : `PackageResource`, `HotelResource`, `PostResource`, `PageResource`, `TestimonialResource`.

## Goals / Non-Goals

**Goals:**
- Fournir un éditeur WYSIWYG TinyMCE dans l'admin pour les champs de contenu
- Utiliser le package officiel `moonshine/tinymce` pour garantir la compatibilité
- Créer un champ `Wysiwyg` réutilisable dans toutes les resources

**Non-Goals:**
- Modifier le frontend Next.js (le contenu HTML est déjà géré côté affichage)
- Ajouter des fonctionnalités d'édition avancée (galerie d'images, gestion de médias)
- Changer le schéma de BDD (les colonnes `text` suffisent pour le HTML)

## Decisions

### Utiliser `moonshine/tinymce` plutôt qu'un éditeur custom

**Alternatives considérées:**
- `moonshine/trix` : plus léger mais moins de fonctionnalités (pas de gestion des tableaux,较少 d'options de formatage)
- Éditeur custom avec Tiptap/ProseMirror : trop complexe pour ce besoin
- Intégrer TinyMCE manuellement : risque de incompatibilité avec MoonShine

**Rationale:** `moonshine/tinymce` est le package officiel, maintenu par l'équipe MoonShine, compatible v4.x, et TinyMCE est l'éditeur WYSIWYG le plus complet disponible.

### Champ `Wysiwyg` comme wrapper

Le champ `Wysiwyg` étendra la configuration de TinyMCE fournie par le package pour offrir une API simple : `Wysiwyg::make('Label', 'column')`. Cela permet de changer facilement d'éditeur à l'avenir.

## Risks / Trade-offs

- **[Taille]** TinyMCE est un bundle JS volumineux (~1.5MB) → impact mineur sur l'admin, pas sur le frontend
- **[Sécurité]** Le HTML généré peut contenir du XSS → TinyMCE nettoie le HTML par défaut, à vérifier côté MoonShine
- **[Compatibilité]** Mise à jour MoonShine future → le package officiel suit les versions
