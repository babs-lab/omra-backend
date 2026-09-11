## Context

La page formule (`src/app/omra/[slug]/page.tsx`, rendue en Server Component avec `force-dynamic`) affiche :
- une colonne gauche : « Détails du séjour » et « Hébergements » ;
- une colonne droite : « Départs disponibles » (une carte par départ avec dates et badge vacances scolaires, **sans bouton d'action**) et le tableau de tarification `PricingTable` ;
- en bas, une carte « Réserver » contenant le formulaire `BookingForm` (client), qui possède une liste déroulante de départ et envoie le Lead via `submitLead` → `POST /api/leads`.

Le modèle `Lead` existant couvre déjà le besoin (champ `departure_id` rattaché au départ). Le `price_override` d'un départ est disponible dans l'API mais n'est pas affiché ni utilisé côté frontend.

## Goals / Non-Goals

**Goals:**
- Un bouton « Réserver » sur chaque ligne de départ disponible de la page formule.
- Au clic, le formulaire situé en bas de la formule s'affiche/mis en évidence (scroll fluide + surbrillance) et est **prérempli** avec les informations de la formule et du départ : titre de la formule, dates du départ, badge vacances scolaires, tarif de base tenant compte du `price_override`.
- Les informations personnelles (prénom, nom, email, téléphone, voyageurs, type de chambre) restent saisies par l'utilisateur et sont enregistrées comme Lead rattaché au départ sélectionné.
- Conserver l'apparence et la structure actuelles de la page.

**Non-Goals:**
- Aucun changement du schéma de base de données ni de l'API (`POST /api/leads`, `LeadRequest`, modèle `Lead` inchangés).
- Pas de réservation ferme / paiement : le flux reste une génération de Lead.
- Pas d'introduction de bibliothèque de formulaires (react-hook-form, zod…) ni de nouvelle dépendance.
- Pas de modification du tableau `PricingTable`.

## Decisions

### 1. Un composant client unique gère l'état du départ sélectionné
Les boutons (colonne droite) et le formulaire (bas de page) doivent partager l'état `selectedDepartureId`. En Server Component, deux composants distincts ne peuvent pas partager d'état. **Décision :** créer `src/components/ReservationSection.tsx` (client) qui :
- possède `selectedDepartureId` (initialisé au premier départ) ;
- rend, via un wrapper `display: contents` (`className="contents"`), les deux zones de la grille : la colonne droite (départs + `PricingTable`) **et** la carte « Réserver » du bas (`md:col-span-2`) ;
- fournit au clic : mise à jour du départ sélectionné, `scrollIntoView({ behavior: 'smooth' })` vers le formulaire et une surbrillance temporaire.

*Alternatives écartées :* (a) `Context`/`EventBus` global — surdimensionné pour un seul état ; (b) paramètre d'URL `?departure=id` — plus complexe pour le scroll et le cache ; (c) remonter l'état dans un composant englobant toute la page — déplace inutilement la colonne gauche (détails/hébergements) côté client et dégrade le SSR.

### 2. `BookingForm` devient contrôlé par le départ sélectionné
`BookingForm.tsx` reçoit les props `departureId`, `onDepartureChange` et `departure` (objet résolu) depuis `ReservationSection`. Le `<select>` de départ est remplacé par un **résumé prérempli en lecture seule** : titre de la formule, dates (format `fr-FR` long), badge « Vacances scolaires » si applicable, et prix de base.

*Alternative écartée :* garder le `<select>` — redondant avec le bouton par départ et contraire au « préremplir » demandé.

### 3. Tarif basé sur `price_override` si renseigné
Dans `BookingForm`, la base de calcul devient `departure.price_override ?? pkg.base_price_quad` (pour le total et pour les suppléments en pourcentage). Le `price_override` est déjà exposé par `GET /api/packages/{slug}`.

### 4. Cas sans départ disponible
Si `pkg.departures.length === 0` : la section « Réserver » (carte + formulaire) n'est pas rendue et un message « Aucun départ disponible pour le moment » est affiché dans la carte des départs.

### 5. Aucune modification backend
`LeadRequest` valide déjà `departure_id` (exists), et le message de succès est déjà géré par le frontend.

## Risks / Trade-offs

- **`display: contents` avec grille CSS** → supporté par tous les navigateurs modernes ; en cas de comportement inattendu, repli simple : restructurer la mise en page pour placer la carte « Réserver » sous la colonne droite dans le même conteneur. À vérifier en développement.
- **Perte des champs utilisateur si on change de départ** → évitée : le champ départ est contrôlé par le parent, les champs personnels restent dans `BookingForm` et ne sont pas remontés/écrasés.
- **Sémantique de `price_override`** → hypothèse : il remplace le prix de base par personne. À confirmer ; si c'est un ajustement différent, seule la fonction `totalPrice()` du formulaire change.
- **Initialisation avec le premier départ** → le formulaire est prérempli dès l'arrivée sur la page ; cohérent avec le comportement actuel du `<select>`.

## Open Questions

- Confirmer la sémantique exacte de `price_override` (remplacement du prix de base par personne) avant l'implémentation de `totalPrice()`.
