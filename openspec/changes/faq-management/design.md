## Context

Le site référence (manasikomra.fr) présente une section « Questions fréquentes » en accordéon. Le projet OUMRA TERANGA suit un pattern éprouvé pour ce type de contenu CMS : un modèle (Feature/Testimonial/Partner) + migration + resource Moonshine + controller API + composant serveur Next.js qui fetch via `src/lib/api.ts`.

Contraintes du code existant :
- Moonshine : modèle `Feature` → `FeatureResource` enregistré dans `MoonShineServiceProvider` + entrée de menu dans `MoonShineLayout`. Champs : titre, icône, position, `is_active` avec scope `active()` et ordre global par position.
- API : `GET /api/features` → `FeatureController::index` renvoie les actifs triés par position.
- Frontend : composant serveur async, `fetch...()` dans `src/lib/api.ts`, types dans `src/types/index.ts`, section rendue sur `src/app/page.tsx`, retour `null` si vide.

## Goals / Non-Goals

**Goals:**
- CRUD complet des FAQ (question + réponse) dans l'admin Moonshine, avec ordre et activation.
- Endpoint public `GET /api/faqs` retournant les FAQ actives triées par position.
- Rendu en accordéon sur la page d'accueil, fidèle à la section « Questions fréquentes » du site de référence.
- Accessibilité native (navigation clavier, lecteurs d'écran) sans JavaScript.

**Non-Goals:**
- Aucune gestion de visibilité par page (la section est sur l'accueil uniquement pour l'instant).
- Pas de recherche/filtre dans la FAQ (contenu court, hors périmètre).
- Pas de traduction/multilingue.

## Decisions

### D1. Données : table `faqs` calquée sur le pattern Feature
`id`, `question` (string), `answer` (text), `position` (int, défaut 0), `is_active` (bool, défaut true), `timestamps`. Modèle `Faq` avec `$fillable`, cast booléen, scope `active()` et global scope d'ordre par `position`, identique à `Feature.php`.

**Alternative écartée** : champs JSON groupés dans une table `site_settings` — complexe pour une liste éditable ; la table dédiée est plus lisible dans Moonshine (Resource par ligne).

### D2. Accordéon natif `<details>` / `<summary>` (zéro JS)
Le composant serveur rend chaque FAQ dans un `<details>` avec `<summary>` (la question) et le contenu (la réponse). Le comportement ouvrir/fermer est natif au navigateur : accessible au clavier, compatible lecteurs d'écran, sans état client.

- Chevron : icône SVG tournée via le variant Tailwind `group-open:` (rotation `180deg`) quand le `<details>` est `open`.
- **Alternative écartée** : état `useState` client + composant `'use client'` — nécessaire seulement pour ne garder qu'une réponse ouverte à la fois ; ici chaque item s'ouvre/ferme indépendamment, le comportement natif suffit.

### D3. API `GET /api/faqs`
`FaqController::index` retourne `{ id, question, answer, position }` pour les FAQ actives, triées par position. Route déclarée dans `routes/api.php` comme `FeatureController`. Aucune pagination (liste courte).

### D4. Composant frontend `FAQSection`
Composant serveur async calquant `WhyChooseSection` :
- `fetchFaqs()` + `catch(() => [])`, retour `null` si vide.
- Section avec badge « Questions fréquentes », titre « Vos questions, nos réponses » sur fond `bg-beige`.
- Rendu en liste d'accordéons `<details>` dans une colonne centrée (`max-w-3xl mx-auto`).
- Style : cartes blanches arrondies, question en `font-heading` gras, réponse en `text-gray-500`.
- Type `Faq` ajouté dans `src/types/index.ts`.

### D5. Emplacement sur l'accueil
Ajout de `<FAQSection />` dans `src/app/page.tsx` après `<WhyChooseSection />`, comme sur le site de référence (section FAQ en bas de page). Ordre ajustable ultérieurement via la gestion de sections dynamiques existante.

## Risks / Trade-offs

- [Le `<details>` natif n'ouvre qu'un item à la fois par interaction utilisateur, pas de close automatique des autres] → Comportement accepté, standard pour une FAQ ; garde l'accessibilité maximale. Un agree accordéon fermerait les autres automatiquement mais exigerait un composant client.
- [Contenu `answer` potentiellement long (paragraphes)] → Champ `Textarea` dans Moonshine pour saisie multi-lignes confortable.
- [Apparence du `<details>` par défaut incohérente avec le design] → Le chevron natif est masqué (`[&::-webkit-details-marker]:hidden` + `list-none`) et remplacé par une icône SVG personnalisée.

## Migration Plan

1. Migration `create_faqs_table` + modèle `Faq`.
2. `FaqController` + route `GET /api/faqs` ; `FaqResource` Moonshine + enregistrement provider + menu.
3. Côté frontend : type, `fetchFaqs`, `FAQSection`, insertion dans `page.tsx`.
4. `php artisan migrate` + validation manuelle (admin, API, accordéon).
5. Rollback : suppression de l'entrée de menu/resource et de la section (aucune donnée métier existante affectée).

## Open Questions

- Nombre de FAQ initiales à insérer en seed (facultatif) : 5–6 paires inspirées du site de référence (visa, paiement en plusieurs fois, villes de départ, femmes seules, documents, accompagnement religieux).