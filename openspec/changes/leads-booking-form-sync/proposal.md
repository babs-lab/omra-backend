## Why

La table `leads` et le formulaire de réservation du site ne sont pas parfaitement alignés : le formulaire envoie bien les champs principaux, mais aucune donnée contextuelle calculée côté client (total estimé, devise) n'est persistée, et les boutons « Réserver » associés à un départ ne transmettent pas de valeurs préremplies au formulaire. Le personnel de l'agence ne voit donc pas dans MoonShine ce que le client avait réellement sous les yeux au moment de sa demande.

## What Changes

- Alignement strict entre le schéma `leads` (backend) et le formulaire de réservation (frontend) : correspondance 1:1 des champs, validation cohérente.
- Ajout de colonnes contextuelles à `leads` : `estimated_total_price` et `currency`, remplies automatiquement à la soumission depuis le total estimé affiché au client.
- Préremplissage du formulaire via paramètres d'URL (`?room=double&voyageurs=2`) sur la page de détail d'un départ, avec ancrage vers la section réservation.
- Chaque bouton « Réserver » d'un départ génère un lien/contexte prérempli : départ sélectionné, type de chambre et nombre de voyageurs transmis au formulaire.
- Mise à jour de la validation `LeadRequest` et du `LeadResource` MoonShine pour refléter les nouvelles colonnes.

## Capabilities

### New Capabilities

- `lead-booking-integration`: harmonisation table `leads` ↔ formulaire de réservation et préremplissage du formulaire depuis les boutons « Réserver » des départs.

### Modified Capabilities

- `departure-reservation`: le flux de réservation existant évolue — les CTA « Réserver » pointent désormais vers le formulaire avec un contexte prérempli (départ, chambre, voyageurs) au lieu d'un formulaire à état par défaut uniquement.

## Impact

- **Backend** : nouvelle migration `add_context_to_leads_table` (`estimated_total_price`, `currency`), mise à jour `Lead.php` (fillables/casts), `LeadRequest.php` (règles de validation), `LeadController` inchangé dans son principe, `LeadResource.php` (affichage admin).
- **Frontend** : `BookingForm.tsx` (props d'initialisation + envoi du total/devise), `ReservationSection.tsx` (lecture des query params, boutons Réserver), page `/omra/[slug]/[departure]` (transmission des searchParams), `types/index.ts` (type `Lead`), `lib/api.ts` inchangé.
- **API** : payload `POST /api/leads` enrichi de deux champs optionnels — rétrocompatible.
- Aucune dépendance externe ajoutée ; migration simple et réversible.
