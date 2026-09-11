## 1. Backend : données et modèle

- [x] 1.1 Créer la migration `2026_09_10_000000_create_faqs_table` : table `faqs` avec `question` (string), `answer` (text), `position` (integer, défaut 0), `is_active` (boolean, défaut true), `timestamps`
- [x] 1.2 Créer le modèle `App\Models\Faq` calqué sur `Feature` : `$fillable`, cast `is_active` en boolean, scope `active()`, global scope d'ordre par `position`
- [x] 1.3 Effectuer la migration (`php artisan migrate`) dans `backend/`

## 2. Backend : Moonshine

- [x] 2.1 Créer `app/MoonShine/Resources/FaqResource.php` : `Text` question (requis), `Textarea` réponse (requis), `Switcher` actif, `Number` position (requis), recherche sur `question`
- [x] 2.2 Enregistrer `FaqResource` dans `app/Providers/MoonShineServiceProvider.php`
- [x] 2.3 Ajouter l'entrée de menu `MenuItem::make(FaqResource::class, 'FAQ')` dans `app/MoonShine/Layouts/MoonShineLayout.php`

## 3. Backend : API

- [x] 3.1 Créer `App\Http\Controllers\Api\FaqController` avec `index()` retournant les FAQ actives triées par position (`id`, `question`, `answer`, `position`)
- [x] 3.2 Ajouter la route `Route::get('/faqs', [FaqController::class, 'index'])` dans `routes/api.php`

## 4. Frontend : type et client API

- [x] 4.1 Ajouter l'interface `Faq` (`id`, `question`, `answer`, `position`) dans `frontend/src/types/index.ts`
- [x] 4.2 Ajouter `fetchFaqs()` dans `frontend/src/lib/api.ts` (cache `no-store`, erreur si réponse non-OK)

## 5. Frontend : composant FAQSection

- [x] 5.1 Créer `frontend/src/components/FAQSection.tsx` : composant serveur async, `fetchFaqs().catch(() => [])`, retour `null` si liste vide
- [x] 5.2 Rendre chaque FAQ en `<details>`/`<summary>` (question en titre, réponse en corps) avec chevron SVG animé (`group-open:rotate-180`), chevron natif masqué (`list-none` + `[&::-webkit-details-marker]:hidden`), style cohérent (cartes blanches, `max-w-3xl mx-auto`, fond `bg-beige`)
- [x] 5.3 Ajouter `<FAQSection />` dans `frontend/src/app/page.tsx` après `<WhyChooseSection />`

## 6. Vérification

- [x] 6.1 Lancer `npm run lint` dans `frontend/` et corriger les erreurs éventuelles
- [x] 6.2 Lancer `npm run build` dans `frontend/`
- [ ] 6.3 Vérifier l'admin MOONSCHINE : CRUD FAQ (création, désactivation, réordonnancement)
- [ ] 6.4 Vérifier `GET /api/faqs` et le rendu accordéon sur l'accueil (ouvrir/fermer, navigation clavier, section masquée si aucune FAQ)