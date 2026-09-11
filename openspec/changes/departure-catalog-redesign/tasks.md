## 1. Backend - Migration et modeles

- [x] 1.1 Creer la migration pour ajouter les champs details_formule, encadrement, transport, inclus, non_inclus au modele Package
- [x] 1.2 Mettre a jour le modele Package avec les nouveaux fillables et casts (JSON pour encadrement, inclus, non_inclus)
- [x] 1.3 Mettre a jour le seeder PackageSeeder avec des donnees de demonstration pour les nouveaux champs

## 2. Backend - Moonshine Admin

- [x] 2.1 Mettre a jour PackageResource.php avec les nouveaux champs (WYSIWYG pour details_formule et transport, JSON pour encadrement, inclus, non_inclus)
- [x] 2.2 Ajouter les champs de tarification (supplements) dans le formulaire Moonshine

## 3. Backend - API

- [x] 3.1 Mettre a jour le controller PackageController pour exposer les nouveaux champs dans GET /api/packages et GET /api/packages/{slug}
- [x] 3.2 Mettre a jour les types TypeScript dans frontend/src/types/index.ts pour les nouveaux champs

## 4. Frontend - Composants de base

- [x] 4.1 Creer le composant DepartureCard.tsx pour afficher une carte de depart sur la page d'accueil
- [x] 4.2 Creer le composant IconList.tsx pour afficher des listes avec icones (encadrement, inclus, non inclus)
- [x] 4.3 Creer le composant TransportSection.tsx pour afficher la section transport
- [x] 4.4 Creer le composant HotelGallery.tsx pour afficher la galerie d'images des hotels

## 5. Frontend - Page d'accueil

- [x] 5.1 Modifier src/app/page.tsx pour afficher les departs au lieu des formules
- [x] 5.2 Implementer le layout responsive 3 colonnes avec ajustement dynamique
- [x] 5.3 Ajouter la navigation vers les pages de detail de depart

## 6. Frontend - Page de detail de depart

- [x] 6.1 Refondre src/app/omra/[slug]/page.tsx pour afficher le detail complet du depart
- [x] 6.2 Implementer la section header avec titre, dates, prix et CTA
- [x] 6.3 Implementer la section details formule avec contenu WYSIWYG
- [x] 6.4 Implementer la section tarifs avec supplements
- [x] 6.5 Implementer la section hotels avec galeries photos
- [x] 6.6 Implementer la section encadrement avec icones
- [x] 6.7 Implementer la section transport avec itineraire
- [x] 6.8 Implementer les sections inclus/non inclus avec icones
- [x] 6.9 Implementer le formulaire de reservation

## 7. Verification

- [x] 7.1 Tester la page d'accueil avec les cartes de departs
- [x] 7.2 Tester la page de detail avec toutes les sections
- [x] 7.3 Verifier le responsive sur mobile et desktop
- [x] 7.4 Lancer npm run build et corriger les erreurs
- [x] 7.5 Verifier l'admin Moonshine avec les nouveaux champs
