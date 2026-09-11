## Why

Sur la page de chaque formule (OMRA EXPRESS, OMRA CONFORT), les départs sont listés sans action directe : l'utilisateur doit scroller jusqu'au formulaire et re-sélectionner manuellement son départ dans une liste déroulante. Ce parcours est source d'abandon et n'exploite pas les informations déjà connues (formule, dates du départ, tarif).

## What Changes

- Ajouter un bouton **« Réserver »** sur chaque ligne de départ disponible dans la section « Départs disponibles » de la page formule (`/omra/[slug]`).
- Au clic sur le bouton d'un départ, le formulaire de réservation situé en bas de la formule est affiché/mis en évidence et fait défiler la page jusqu'à lui.
- Le formulaire est **prérempli avec les informations de la formule et du départ sélectionné** :
  - la formule (titre) et le départ choisi (dates, badge vacances scolaires) affichés en résumé non modifiable ;
  - le tarif de base recalculé en tenant compte du `price_override` du départ s'il est renseigné.
- Les informations personnelles (prénom, nom, email, téléphone, voyageurs, type de chambre) restent à saisir par l'utilisateur et sont enregistrées comme Lead via `POST /api/leads`.
- Aucune modification du schéma de base de données : le modèle `Lead` existant couvre déjà le besoin (`departure_id` rattaché au départ choisi).

## Capabilities

### New Capabilities
- `departure-reservation`: parcours de réservation depuis un départ disponible — bouton « Réserver » par départ, préremplissage du formulaire avec les informations de la formule/départ, et création du Lead rattaché au départ sélectionné.

### Modified Capabilities
<!-- Aucune capacité existante n'est modifiée : l'API POST /api/leads et le modèle Lead restent inchangés. -->

## Impact

- **Frontend (Next.js + TailwindCSS)** :
  - `src/app/omra/[slug]/page.tsx` : ajout du bouton « Réserver » par ligne de départ et gestion de l'état du départ sélectionné.
  - `src/components/BookingForm.tsx` : réception du départ sélectionné, affichage du résumé prérempli (formule, dates, tarif avec `price_override`).
  - `src/types/index.ts` : éventuels types d'aide (départ sélectionné).
- **Backend (Laravel)** :
  - Aucun changement d'API requis ; le `price_override` est déjà exposé dans `GET /api/packages/{slug}` via les départs.
  - `POST /api/leads` et `LeadRequest` restent inchangés.
- **Dépendances** : aucune nouvelle bibliothèque frontend/backend.
