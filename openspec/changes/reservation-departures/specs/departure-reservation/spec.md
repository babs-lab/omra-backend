## ADDED Requirements

### Requirement: Bouton « Réserver » sur chaque départ disponible
La page formule (OMRA EXPRESS, OMRA CONFORT) SHALL afficher un bouton « Réserver » sur chaque ligne de départ disponible dans la section « Départs disponibles ».

#### Scenario: Un bouton par départ
- **WHEN** la page formule affiche N départs disponibles
- **THEN** chaque ligne de départ affiche un bouton « Réserver » cliquable

#### Scenario: Aucun départ disponible
- **WHEN** la formule ne possède aucun départ disponible
- **THEN** aucun bouton « Réserver » n'est affiché et un message « Aucun départ disponible pour le moment » est visible

### Requirement: Affichage du formulaire au bas de la formule
Lorsqu'un utilisateur clique sur le bouton « Réserver » d'un départ, le formulaire de réservation situé en bas de la formule SHALL être mis en évidence et affiché (défilement fluide vers le formulaire et surbrillance temporaire).

#### Scenario: Clic sur le bouton d'un départ
- **WHEN** l'utilisateur clique sur « Réserver » d'un départ donné
- **THEN** la page défile en douceur jusqu'au formulaire de réservation en bas de la formule
- **THEN** le formulaire reçoit une surbrillance temporaire indiquant qu'il est sélectionné

### Requirement: Préremplissage du formulaire avec les informations de la formule
Le formulaire de réservation SHALL être prérempli avec les informations de la formule et du départ sélectionné : titre de la formule, dates du départ (format français long), badge « Vacances scolaires » si applicable et prix de base par personne.

#### Scenario: Préremplissage après sélection
- **WHEN** l'utilisateur clique sur « Réserver » du départ avec les dates D1→D2
- **THEN** le formulaire affiche le titre de la formule, les dates D1→D2 et le badge « Vacances scolaires » si le départ est en période scolaire
- **THEN** le champ départ s'affiche en lecture seule (prérempli), les autres champs (prénom, nom, email, téléphone, voyageurs, type de chambre) restent à saisir

#### Scenario: Changement de départ via un autre bouton
- **WHEN** l'utilisateur clique sur « Réserver » d'un autre départ après avoir saisi des informations personnelles
- **THEN** le résumé du départ dans le formulaire est mis à jour
- **THEN** les informations personnelles déjà saisies par l'utilisateur sont conservées

### Requirement: Tarif tenant compte du price_override
Le prix de base par personne affiché et utilisé dans le calcul du total du formulaire SHALL prendre en compte le `price_override` du départ sélectionné lorsqu'il est renseigné, sinon le prix de base de la formule.

#### Scenario: Départ avec price_override
- **WHEN** le départ sélectionné possède un `price_override`
- **THEN** le prix de base du formulaire correspond au `price_override` du départ
- **THEN** le total estimé est recalculé à partir de ce prix (suppléments en pourcentage inclus)

#### Scenario: Départ sans price_override
- **WHEN** le départ sélectionné n'a pas de `price_override`
- **THEN** le prix de base du formulaire correspond au prix de base de la formule (`base_price_quad`)

### Requirement: Enregistrement du Lead rattaché au départ sélectionné
La soumission du formulaire SHALL créer un Lead via `POST /api/leads` avec le `departure_id` du départ sélectionné et les informations fournies par l'utilisateur.

#### Scenario: Soumission réussie
- **WHEN** l'utilisateur remplit le formulaire et le soumet
- **THEN** le backend enregistre un Lead avec le `departure_id` du départ sélectionné et le statut `pending`
- **THEN** un message de confirmation est affiché à l'utilisateur

#### Scenario: Erreur de validation
- **WHEN** le backend renvoie une erreur de validation
- **THEN** le formulaire affiche le message d'erreur et les informations saisies sont conservées
