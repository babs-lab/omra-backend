# Design — leads-booking-form-sync

## Context

- **Backend (Laravel + MoonShine)** : la table `leads` contient `departure_id`, `first_name`, `last_name`, `email`, `phone`, `passengers_count`, `room_type_requested`, `status`, `notes`. `POST /api/leads` est validé par `LeadRequest` et crée le lead via `Lead::create($request->validated())`.
- **Frontend (Next.js App Router)** : `BookingForm` envoie exactement les champs ci-dessus mais avec des valeurs par défaut codées en dur (`quadruple`, 1 voyageur). Le total estimé est calculé côté client (`totalPrice()`) mais jamais transmis.
- **Boutons « Réserver »** : dans `ReservationSection` (liste des départs), le clic change l'état local et scrolle vers le formulaire — aucun contexte prérempli ne circule. Les cartes de départ (`DepartureCard`) renvoient vers `/omra/{slug}/{date}` sans paramètres.
- Contrainte : backend et frontend restent découplés, communiquant uniquement via l'API RESTful.

## Goals / Non-Goals

**Goals:**

- Correspondance 1:1 entre les champs du formulaire de réservation et les colonnes de `leads`.
- Persister le contexte commercial vu par le client : total estimé + devise au moment de la demande.
- Permettre à tout bouton « Réserver » d'un départ d'ouvrir le formulaire prérempli (départ sélectionné, type de chambre, nombre de voyageurs) via une URL partageable.

**Non-Goals:**

- Authentification ou comptes clients (le lead reste anonyme).
- Paiement en ligne ou confirmation automatisée du séjour.
- Refonte visuelle du formulaire ou de la page détail.
- Modification des autres endpoints de l'API.

## Decisions

### D1 — Enrichir `leads` plutôt que créer une table liée

Ajouter deux colonnes nullables `estimated_total_price` (decimal 10:2) et `currency` (string 3) directement sur `leads`.

- *Pourquoi* : ces valeurs sont des instantanés figés au moment de la demande (les tarifs évoluent) ; une table séparée ajouterait une jointure inutile pour un usage purement informatif dans MoonShine.
- *Alternative rejetée* : recalculer le prix côté serveur depuis `Departure`/`Supplement` — fragile car les suppléments sont globaux et le prix affiché dépend de l'état au moment T ; on privilégie la trace fidèle de ce que le client a vu.

### D2 — Validation backend permissive sur le contexte, stricte sur l'identité

Dans `LeadRequest` : `estimated_total_price` → `nullable|numeric|min:0` ; `currency` → `nullable|string|max:10` (ex. EUR, USD, XOF). Les champs identitaires restent inchangés. Le payload reste rétrocompatible : les anciens clients qui n'envoient pas ces champs continuent de fonctionner.

### D3 — Préremplissage par query params (URL = source de vérité)

La page `/omra/[slug]/[departure]` accepte `?room=triple&voyageurs=4` ; `ReservationSection` lit `useSearchParams()` pour initialiser `selectedDepartureId`, puis passe des props d'initialisation à `BookingForm` (`initialRoomType`, `initialPassengers`). Les valeurs invalides retombent silencieusement sur les défauts actuels.

- *Pourquoi* : URL partageable, bookmarkable, compatible SSR/App Router, aucun state global à introduire.
- *Alternatives rejetées* : sessionStorage (non partageable, désynchronisé), Context provider global (sur-ingénierie pour un flux à une page).

### D4 — Boutons « Réserver » = liens ancrés avec query params

Le bouton « Réserver » de chaque départ devient un lien vers `#reservation?room=...&voyageurs=...` (ou met à jour `router.replace` quand il est déjà sur la page), garantissant que le formulaire reflète toujours explicitement le départ cliqué. Le comportement existant (scroll + highlight) est conservé.

### D5 — Envoi du total calculé tel quel

`BookingForm` inclut `estimated_total_price: totalPrice()` et `currency: baseCurrency.code ?? baseCurrency` dans `submitLead`. Aucun recalcul backend : la valeur est un constat, pas une promesse tarifaire (libellé « estimation » dans l'admin).

## Risks / Trade-offs

- [Prix manipulable côté client] → champ nullable non utilisé pour la facturation ; affiché comme « estimation » dans MoonShine ; validation min:0 uniquement.
- [Query params invalides ou incohérents] → fallback systématique sur les défauts (`quadruple`, 1) sans erreur bloquante.
- [Migration sur données existantes] → colonnes ajoutées nullable donc zéro backfill requis ; rollback simple (`dropColumn`).
- [`useSearchParams` force le rendu dynamique] → la page détail est déjà `force-dynamic`, aucun impact SEO additionnel ; lecture enveloppée dans `<Suspense>` si nécessaire selon les conventions Next.js 16 (cf. `node_modules/next/dist/docs/`).

## Migration Plan

1. Créer et exécuter la migration `add_context_to_leads_table` (colonnes après `room_type_requested`).
2. Déployer le backend (validation + admin), puis le frontend (formulaire enrichi).
3. Rollback : `php artisan migrate:rollback --step=1` ; le front tolère l'absence des champs (payload optionnel).

## Open Questions

- Faut-il historiser aussi le prix unitaire de base ? Décision : non, le total estimé suffit (le détail est recalculable depuis le départ).
