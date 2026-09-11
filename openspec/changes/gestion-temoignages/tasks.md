## 1. Backend — Modèle et migration

- [x] 1.1 Créer la migration `create_testimonials_table` : colonnes `name` (string), `city` (string nullable), `content` (text), `rating` (tinyint nullable), `avatar` (string nullable), `position` (integer default 0), `is_active` (boolean default true)
- [x] 1.2 Créer le modèle `App\Models\Testimonial` : `$fillable`, casts (`is_active` boolean, `rating` integer), scope `active()`, accesseur `avatar_url` via `Storage::disk('public')->url()`, tri global par `position` (pattern `Partner`)
- [x] 1.3 Lancer `php artisan migrate` et vérifier la table `testimonials`

## 2. Backend — Resource MoonShine et admin

- [x] 2.1 Créer `App\MoonShine\Resources\TestimonialResource` (pattern `PartnerResource`) : `indexFields` (ID, Nom, Ville, aperçu avatar, Actif, Position), `formFields` (ID, Nom requis, Ville, Contenu `Textarea` requis, Note `Number` 1-5, Avatar `Image` `->dir('testimonials')`, Actif, Position), `detailFields`, `search()` sur `name`/`city`/`content`
- [x] 2.2 Réutiliser `LogoPreview` pour l'aperçu de l'avatar ou adapter un champ équivalent dans `indexFields`/`detailFields`
- [x] 2.3 Enregistrer `TestimonialResource` dans `MoonShineServiceProvider`
- [x] 2.4 Vérifier l'interface admin (création, édition, upload avatar, switch actif, position)

## 3. Backend — API et seeders

- [x] 3.1 Créer `App\Http\Controllers\Api\TestimonialController::index()` retournant les témoignages actifs triés par position (`name`, `city`, `content`, `rating`, `avatar`, `position`, `append('avatar_url')`)
- [x] 3.2 Ajouter la route `Route::get('/testimonials', ...)` dans `routes/api.php`
- [x] 3.3 Créer `TestimonialSeeder` (5-6 témoignages d'exemple, pattern manasikomra) et l'appeler dans `DatabaseSeeder`
- [x] 3.4 Ajouter l'entrée menu `Témoignages` (`/temoignages`) dans `MenuItemSeeder` (réordonner les positions existantes)
- [x] 3.5 Exécuter `php artisan db:seed --class=TestimonialSeeder` (ou `migrate --seed`) et vérifier `GET /api/testimonials`

## 4. Frontend — Données et composants

- [x] 4.1 Ajouter le type `Testimonial` dans `src/types/index.ts` (name, city, content, rating, avatar, avatar_url, position)
- [x] 4.2 Ajouter `fetchTestimonials()` dans `src/lib/api.ts` avec `{ next: { revalidate: 300 } }`
- [x] 4.3 Créer `src/components/TestimonialCard.tsx` : citation entre guillemets, avatar (image ou initiales dans un cercle or), auteur, ville, note en étoiles dorées, style charte (Pridi, or, beige)
- [x] 4.4 Créer `src/components/TestimonialCarousel.tsx` (composant client) : piste `flex` + `translateX`, `perView` responsive (1/2/3), auto-défilement ~5 s en pause au survol, flèches et points ; grille statique si `total <= perView`
- [x] 4.5 Créer `src/components/TestimonialSection.tsx` (composant serveur) : fetch témoignages, grille 25/75 (gauche : titre fancy badge + Pridi + filet doré ; droite : `TestimonialCarousel`), rendu `null` si liste vide

## 5. Frontend — Intégration section et page

- [x] 5.1 Intégrer `TestimonialSection` dans `src/app/layout.tsx` juste après `<PartnerSection />` (et avant `<Footer />`)
- [x] 5.2 Créer `src/app/temoignages/page.tsx` : `metadata` titre « Témoignages », hero fancy (badge, titre Pridi, filet doré), grille responsive de `TestimonialCard` (`columns-1 md:columns-2 lg:columns-3`), état vide si aucun témoignage
- [x] 5.3 Ajouter le lien « Témoignages » (`/temoignages`) dans `Header.tsx` (`rightLinks`)
- [x] 5.4 Vérifier le rendu sur la page d'accueil (section sous « Ils nous font confiance », carousel si liste longue) et sur `/temoignages`

## 6. Vérification finale

- [x] 6.1 Vérifier `GET /api/testimonials` : seuls les actifs, triés par position, `avatar_url` résoluble
- [x] 6.2 Vérifier `GET /api/menus` : entrée « Témoignages » présente avec route `/temoignages`
- [x] 6.3 Vérifier la page d'accueil : section 25/75, titre fancy, carousel (flèches, points, auto-défilement, pause au survol), pas de section si aucun témoignage
- [x] 6.4 Vérifier `/temoignages` : hero fancy, grille de cartes, état vide
- [x] 6.5 Exécuter `npm run lint` et `npx tsc --noEmit` côté frontend
