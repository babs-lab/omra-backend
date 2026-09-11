## 1. Composant client de réservation

- [x] 1.1 Créer `src/components/ReservationSection.tsx` (client) qui possède l'état `selectedDepartureId` (initialisé au premier départ) et un `formRef`
- [x] 1.2 Rendre dans `ReservationSection` la colonne droite (carte « Départs disponibles » avec bouton « Réserver » par ligne + carte `PricingTable`) et la carte « Réserver » du bas via un wrapper `display: contents` (`md:col-span-2` pour le formulaire)
- [x] 1.3 Gérer le cas sans départ disponible : message « Aucun départ disponible pour le moment » et non-rendu du formulaire
- [x] 1.4 Implémenter le clic sur un bouton « Réserver » : mettre à jour `selectedDepartureId`, `scrollIntoView({ behavior: 'smooth' })` vers le formulaire et surbrillance temporaire (~1,5 s)

## 2. Préremplissage du formulaire

- [x] 2.1 Modifier `BookingForm.tsx` : recevoir `departureId`, `onDepartureChange` et le départ résolu en props (champ départ contrôlé par le parent)
- [x] 2.2 Remplacer le `<select>` de départ par un résumé prérempli en lecture seule : titre de la formule, dates `fr-FR` long, badge « Vacances scolaires »
- [x] 2.3 Utiliser `departure.price_override ?? pkg.base_price_quad` comme base de calcul du total et des suppléments en pourcentage
- [x] 2.4 Conserver les champs utilisateur (prénom, nom, email, téléphone, voyageurs, type de chambre) et leur comportement de soumission `POST /api/leads` inchangé

## 3. Intégration dans la page formule

- [x] 3.1 Dans `src/app/omra/[slug]/page.tsx`, remplacer la colonne droite « Départs disponibles »/`PricingTable` et la carte « Réserver » par `<ReservationSection pkg={pkg} supplements={supplements} />`
- [x] 3.2 Vérifier que la grille `md:grid-cols-2` conserve la mise en page actuelle (colonne gauche à gauche, départs/tarifs à droite, formulaire en bas pleine largeur)

## 4. Vérification

- [x] 4.1 Vérifier l'absence de changements backend (API `POST /api/leads`, `LeadRequest`, modèle `Lead` inchangés)
- [x] 4.2 Tester le parcours sur `/omra/omra-express` et `/omra/omra-confort` : clic sur « Réserver » d'un départ → scroll + surbrillance, résumé prérempli, total avec `price_override`, Lead créé avec le bon `departure_id`
- [x] 4.3 Lancer `npm run lint` (ou la commande équivalente du frontend) et corriger les éventuelles erreurs
