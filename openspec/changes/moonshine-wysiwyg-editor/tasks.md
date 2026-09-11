## 1. Installation

- [x] 1.1 Exécuter `composer require moonshine/tinymce`
- [x] 1.2 Vérifier l'installation avec `composer show moonshine/tinymce`

## 2. Champ Wysiwyg

- [x] 2.1 Créer `app/MoonShine/Fields/Wysiwyg.php` étendant le champ TinyMCE du package
- [x] 2.2 Vérifier que le champ s'affiche correctement dans un formulaire MoonShine

## 3. Resources — Remplacement Textarea → Wysiwyg

- [x] 3.1 `PackageResource` : remplacer `Textarea::make('Description')` par `Wysiwyg::make()` (index + form)
- [x] 3.2 `HotelResource` : remplacer `Textarea::make('Description')` par `Wysiwyg::make()` (index + form)
- [x] 3.3 `PostResource` : remplacer `Textarea::make('Contenu')` par `Wysiwyg::make()` (index + form)
- [x] 3.4 `PageResource` : remplacer `Textarea::make('Contenu')` par `Wysiwyg::make()` (index + form)
- [x] 3.5 `TestimonialResource` : remplacer `Textarea::make('Contenu')` par `Wysiwyg::make()` (index + form)

## 4. Vérification

- [x] 4.1 Vérifier que l'éditeur TinyMCE s'affiche dans chaque resource modifiée
- [x] 4.2 Tester la sauvegarde et l'édition d'un contenu avec formatage riche
