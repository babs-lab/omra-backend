## MODIFIED Requirements

### Requirement: Préremplissage du formulaire avec les informations de la formule
Le formulaire de réservation SHALL être prérempli avec les informations de la formule et du départ sélectionné : titre de la formule, dates du départ (format français long), badge « Vacances scolaires » si applicable et prix de base par personne. Le type de chambre et le nombre de voyageurs SHALL également pouvoir être préremplis depuis les paramètres d'URL (`room`, `voyageurs`) conformément à la capacité `lead-booking-integration`.

#### Scenario: Préremplissage après sélection
- **WHEN** l'utilisateur clique sur « Réserver » du départ avec les dates D1→D2
- **THEN** le formulaire affiche le titre de la formule, les dates D1→D2 et le badge « Vacances scolaires » si le départ est en période scolaire
- **THEN** le champ départ s'affiche en lecture seule (prérempli), les autres champs (prénom, nom, email, téléphone, voyageurs, type de chambre) restent à saisir sauf préremplissage explicite via paramètres d'URL

#### Scenario: Changement de départ via un autre bouton
- **WHEN** l'utilisateur clique sur « Réserver » d'un autre départ après avoir saisi des informations personnelles
- **THEN** le résumé du départ dans le formulaire est mis à jour
- **THEN** les informations personnelles déjà saisies par l'utilisateur sont conservées

#### Scenario: Accès direct à un départ via URL préremplie
- **WHEN** l'utilisateur arrive sur `/omra/{slug}/{date}?room=triple&voyageurs=4` sans passer par un bouton « Réserver »
- **THEN** le formulaire est rattaché au départ `{date}` avec « Triple » et 4 voyageurs présélectionnés

### Requirement: Enregistrement du Lead rattaché au départ sélectionné
La soumission du formulaire SHALL créer un Lead via `POST /api/leads` avec le `departure_id` du départ sélectionné, les informations fournies par l'utilisateur et l'instantané contextuel (`estimated_total_price`, `currency`) correspondant au total estimé affiché.

#### Scenario: Soumission réussie
- **WHEN** l'utilisateur remplit le formulaire et le soumet
- **THEN** le backend enregistre un Lead avec le `departure_id` du départ sélectionné, le statut `pending`, le total estimé calculé et la devise affichée
- **THEN** un message de confirmation est affiché à l'utilisateur

#### Scenario: Erreur de validation
- **WHEN** le backend renvoie une erreur de validation
- **THEN** le formulaire affiche le message d'erreur et les informations saisies sont conservées
