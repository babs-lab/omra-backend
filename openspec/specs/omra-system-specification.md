# Cahier des charges technique - Omra 2026-2027

## 1. Exigences fonctionnelles

Le système doit couvrir les besoins suivants :

- Catalogue de formules : gérer les formules principales "OMRA CONFORT" et "OMRA EXPRESS".
- Dates et durées : chaque séjour doit avoir une durée définie et des plages de dates de départ.
- Hébergements : associer des hôtels selon la ville sainte et définir les nuits par ville.
- Tarification : prix de base par personne en chambre quadruple et suppléments pour triple, double, bébé, et vacances scolaires.
- Génération de leads : capture des demandes de réservation via CTA et envoi au backend.
- Navigation : menu structuré avec Accueil, Omra 2026-2027, Ramadan 2027, Blog, Contact.
- Conformité : bannière de consentement cookies et pages CGV, CGU, Mentions légales.

## 2. Architecture Backend (Laravel 11 + Moonshine)

### 2.1. Modèles de données

- City
  - id
  - name

- Hotel
  - id
  - city_id
  - name
  - rating
  - distance_to_haram
  - description

- Package
  - id
  - title
  - slug
  - duration_days
  - base_price_quad
  - description

- Departure
  - id
  - package_id
  - start_date
  - end_date
  - is_school_holiday
  - price_override

- Package_Hotel
  - package_id
  - hotel_id
  - nights

- Supplement
  - id
  - type
  - amount
  - is_percentage

- Lead
  - id
  - departure_id
  - first_name
  - last_name
  - email
  - phone
  - passengers_count
  - room_type_requested
  - status

- Page
  - id
  - title
  - slug
  - content

### 2.2. Relations Eloquent

- City a plusieurs Hotels.
- Hotel appartient à une City.
- Package a plusieurs Departures.
- Package a plusieurs Hotels via Package_Hotel.
- Departure appartient à un Package.
- Lead appartient à une Departure.

### 2.3. Moonshine Admin

- Créer un MoonshineResource pour chaque modèle.
- Afficher City, Hotel, Package, Departure, Supplement, Lead, Page, Blog
- Utiliser BelongsTo et BelongsToMany pour les relations.
- Dashboard : métriques sur les leads du mois et répartition par formule.

### 2.4. Endpoints API

- GET /api/packages
  - Liste des formules avec départs et hôtels.

- GET /api/packages/{slug}
  - Détails d'une formule.

- POST /api/leads
  - Soumission du formulaire de réservation.
  - Validation via FormRequest.
  - Protection CSRF/CORS.

- GET /api/pages/{slug}
  - Récupération du contenu réglementaire et blog.

## 3. Architecture Frontend (Next.js + TailwindCSS)

### 3.1. Pages principales

- `app/page.tsx` : page d'accueil avec formules phares.
- `app/omra/[slug]/page.tsx` : détail d'une formule.
- `app/blog/page.tsx` : liste des articles.
- `app/blog/[slug]/page.tsx` : article de blog.
- `app/contact/page.tsx` : formulaire de contact.
- `app/legal/[slug]/page.tsx` : pages légales dynamiques.

### 3.2. Composants clés

- `PackageCard` : affichage du titre, durée, prix de départ et hôtels inclus.
- `PricingTable` : tableau dynamique des suppléments.
- `BookingModal` / `BookingForm` : formulaire de réservation pour envoyer un lead.
- `CookieConsentBanner` : gestion des consentements RGPD.

### 3.3. Flux principal

1. L'utilisateur consulte une formule.
2. Il sélectionne un départ et un type de chambre.
3. Il clique sur "Je veux réserver".
4. Le formulaire s'ouvre et envoie les données à `POST /api/leads`.
5. Le backend crée un lead et peut gérer le statut.

## 4. Points importants

- Les prix doivent rester dynamiques et s'ajuster en fonction du type de chambre et des vacances scolaires.
- Les pages légales doivent être gérées via un CMS simple (`Page`).
- Le frontend doit privilégier le référencement SEO avec Next.js App Router.
- Le backend doit exposer une API claire et sécurisée pour le front.

## 5. Base de données

- L'adresse de la base de données est localhost et est sur la machine
- L'utilisateur est root 
- Le mot de passe est vide
