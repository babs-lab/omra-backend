## 1. Backend — Modèle de données

- [x] 1.1 Créer la migration `add_context_to_leads_table` : colonnes `estimated_total_price` (decimal 10:2, nullable, après `room_type_requested`) et `currency` (string 10, nullable), avec `down()` réversible
- [x] 1.2 Exécuter `php artisan migrate` et vérifier le schéma de la table `leads`
- [x] 1.3 Mettre à jour `app/Models/Lead.php` : ajouter les nouvelles colonnes à `$fillable` et au `$casts` (`estimated_total_price` → decimal)

## 2. Backend — Validation et API

- [x] 2.1 Mettre à jour `app/Http/Requests/LeadRequest.php` : règles `estimated_total_price` (`nullable|numeric|min:0`) et `currency` (`nullable|string|max:10`)
- [x] 2.2 Vérifier que `POST /api/leads` persiste les nouveaux champs (payload complet) et reste rétrocompatible sans ces champs (réponse 201, colonnes NULL)

## 3. Backend — Administration MoonShine

- [x] 3.1 Ajouter `estimated_total_price` et `currency` aux champs de `LeadResource.php` (index, form, detail) avec libellé « estimation »

## 4. Frontend — Types et client API

- [x] 4.1 Mettre à jour `src/types/index.ts` : enrichir l'interface `Lead` avec `estimated_total_price?: number | null` et `currency?: string | null`

## 5. Frontend — Formulaire de réservation

- [x] 5.1 Ajouter des props d'initialisation à `BookingForm.tsx` (`initialRoomType?`, `initialPassengers?`) utilisées comme état initial
- [x] 5.2 Inclure `estimated_total_price: totalPrice()` et la devise affichée dans le payload de `submitLead`
- [x] 5.3 Valider les valeurs initiales (type de chambre dans la liste autorisée, voyageurs entre 1 et 10) avec repli sur les défauts

## 6. Frontend — Préremplissage via URL et boutons « Réserver »

- [x] 6.1 Dans `ReservationSection.tsx`, lire les paramètres `room` et `voyageurs` (via `useSearchParams`) et les transmettre à `BookingForm` en props d'initialisation
- [x] 6.2 Faire du bouton « Réserver » de chaque départ un lien vers `#reservation` porteur du contexte prérempli (`?room=...&voyageurs=...` ou mise à jour d'URL), en conservant scroll fluide + surbrillance
- [x] 6.3 Sur la page `/omra/[slug]/[departure]/page.tsx`, propager proprement les searchParams vers `ReservationSection` (respecter les conventions Next.js 16 de `node_modules/next/dist/docs/`)
- [x] 6.4 S'assurer que la saisie utilisateur prime sur le préremplissage initial après interaction

## 7. Vérification

- [x] 7.1 Parcours manuel : clic « Réserver » sur un départ → formulaire rattaché au bon départ → soumission → lead visible dans MoonShine avec total estimé et devise
- [x] 7.2 Tester les cas limites d'URL (`room=-suite`, `voyageurs=99`, absence de params) → défauts appliqués sans erreur
- [x] 7.3 Lancer `php artisan test` (backend) et `npm run lint` + `npm run build` (frontend) sans erreur
