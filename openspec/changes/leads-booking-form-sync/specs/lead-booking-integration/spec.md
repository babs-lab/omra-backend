## ADDED Requirements

### Requirement: Correspondance stricte entre le formulaire et la table leads
Chaque champ soumis par le formulaire de réservation SHALL correspondre à une colonne de la table `leads`, et chaque colonne remplissable via l'API publique (`departure_id`, `first_name`, `last_name`, `email`, `phone`, `passengers_count`, `room_type_requested`, `estimated_total_price`, `currency`) SHALL être alimentée par le formulaire ou déduite du contexte de réservation. Les règles de validation de `LeadRequest` SHALL refléter les contraintes des colonnes (types, bornes, valeurs autorisées).

#### Scenario: Soumission alignée sur le schéma
- **WHEN** le formulaire de réservation est soumis avec succès
- **THEN** le payload envoyé à `POST /api/leads` ne contient que des colonnes existantes de la table `leads` et chaque valeur respecte les règles de validation

#### Scenario: Cohérence type de chambre
- **WHEN** l'utilisateur sélectionne « Triple » dans le formulaire
- **THEN** la colonne `room_type_requested` enregistrée vaut exactement `triple` (une des valeurs `quadruple|triple|double|single`)

### Requirement: Instantané du total estimé et de la devise
La table `leads` SHALL disposer de colonnes `estimated_total_price` (décimal, nullable) et `currency` (chaîne courte, nullable). Le formulaire SHALL transmettre à `POST /api/leads` le total estimé affiché au client au moment de la soumission ainsi que la devise associée au prix affiché. Ces valeurs constituent un instantané informatif et MUST NOT être utilisées comme tarif contractuel.

#### Scenario: Lead avec total estimé
- **WHEN** le formulaire affiche un total estimé de 1 250 EUR et l'utilisateur soumet
- **THEN** le lead créé persiste `estimated_total_price = 1250.00` et `currency = EUR`

#### Scenario: Champ optionnel absent
- **WHEN** un client API soumet un lead sans `estimated_total_price` ni `currency`
- **THEN** le lead est créé avec ces colonnes à NULL et la requête n'est pas rejetée

### Requirement: Validation backend des champs contextuels
L'endpoint `POST /api/leads` SHALL accepter `estimated_total_price` comme numérique nullable positif ou nul et `currency` comme chaîne nullable limitée en longueur, sans casser les validations existantes des champs identitaires.

#### Scenario: Total invalide rejeté
- **WHEN** une requête envoie `estimated_total_price = -50`
- **THEN** la réponse est une erreur de validation 422 et aucun lead n'est créé

### Requirement: Contexte de réservation visible dans l'administration MoonShine
Le `LeadResource` MoonShine SHALL afficher pour chaque lead le total estimé et la devise transmis lors de la demande, en plus des champs existants (départ, voyageurs, type de chambre).

#### Scenario: Consultation d'un lead dans l'admin
- **WHEN** un administrateur ouvre le détail d'un lead issu du site
- **THEN** le total estimé, la devise, le départ, le nombre de voyageurs et le type de chambre demandés sont visibles

### Requirement: Préremplissage du formulaire via paramètres d'URL
Le formulaire de réservation SHALL accepter un préremplissage initial via les paramètres d'URL `room` (type de chambre) et `voyageurs` (nombre de passagers) sur la page de réservation d'un départ. Toute valeur absente ou invalide SHALL retomber silencieusement sur les valeurs par défaut actuelles (chambre quadruple, 1 voyageur) sans erreur bloquante.

#### Scenario: Lien partagé avec paramètres valides
- **WHEN** un utilisateur ouvre `/omra/{slug}/{date}?room=double&voyageurs=3`
- **THEN** le formulaire s'affiche avec « Double » présélectionné et 3 voyageurs

#### Scenario: Paramètres invalides ignorés
- **WHEN** un utilisateur ouvre `/omra/{slug}/{date}?room=-suite&voyageurs=99`
- **THEN** le formulaire s'affiche avec les valeurs par défaut (quadruple, 1 voyageur) et aucune erreur bloquante n'est visible

#### Scenario: Saisie utilisateur prioritaire
- **WHEN** l'utilisateur modifie manuellement le type de chambre après un préremplissage
- **THEN** la valeur soumise correspond à sa saisie et non au paramètre d'URL initial
