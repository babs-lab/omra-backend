# Backlog des tâches OpenSpec - Omra 2026-2027

## 1. Backend Laravel + Moonshine

1. Créer les migrations pour les entités métier :
   - `cities`
   - `hotels`
   - `packages`
   - `departures`
   - `package_hotel`
   - `supplements`
   - `leads`
   - `pages`

2. Développer les modèles Eloquent correspondants et leurs relations :
   - `City` -> hasMany(`Hotel`)
   - `Hotel` -> belongsTo(`City`)
   - `Package` -> hasMany(`Departure`)
   - `Package` -> belongsToMany(`Hotel`) via pivot `package_hotel`
   - `Departure` -> belongsTo(`Package`)
   - `Lead` -> belongsTo(`Departure`)

3. Ajouter la logique de tarification :
   - prix base quadruple sur `Package`
   - suppléments pour double/triple/bébé
   - prise en compte des vacances scolaires et `price_override`

4. Créer les API controllers et routes :
   - `GET /api/packages`
   - `GET /api/packages/{slug}`
   - `GET /api/pages/{slug}`
   - `POST /api/leads`

5. Implémenter la validation et la sécurité :
   - FormRequest pour `Lead` avec règles de validation
   - Configuration CORS API
   - Protection CSRF pour les formulaires front-end

6. Ajouter des seeders / fixtures de données initiales :
   - villes : Makkah, Médine
   - hôtels : VALY HOTEL, SHERATON HOTEL, VOCO HOTEL
   - formules : OMRA EXPRESS, OMRA CONFORT
   - départs associés aux périodes de décembre 2026 et Ramadan 2027
   - suppléments de chambres et bébé

## 2. Administration Moonshine

7. Créer les `MoonshineResource` pour :
   - `City`
   - `Hotel`
   - `Package`
   - `Departure`
   - `Supplement`
   - `Lead`
   - `Page`

8. Configurer les champs relationnels dans Moonshine :
   - BelongsTo pour `Hotel.city`
   - BelongsToMany pour `Package.hotels`
   - BelongsTo pour `Departure.package`
   - BelongsTo pour `Lead.departure`

9. Ajouter des métriques sur le dashboard :
   - nombre de leads du mois
   - répartition des demandes par formule
   - leads non traités / nouveaux leads

## 3. Frontend Next.js + TailwindCSS

10. Créer l’arborescence des pages App Router :
    - `app/page.tsx`
    - `app/omra/[slug]/page.tsx`
    - `app/blog/page.tsx`
    - `app/blog/[slug]/page.tsx`
    - `app/contact/page.tsx`
    - `app/legal/[slug]/page.tsx`

11. Développer les composants clés :
    - `PackageCard`
    - `PricingTable`
    - `BookingModal`
    - `BookingForm`
    - `CookieConsentBanner`

12. Intégrer le flux de réservation :
    - affichage des dates et hôtels pour chaque formule
    - calcul dynamique du prix selon le type de chambre
    - bouton CTA "Je veux réserver"
    - soumission du lead vers `POST /api/leads`

13. Gestion du menu principal :
    - Accueil
    - Omra 2026-2027
    - Ramadan 2027
    - Blog
    - Contact

## 4. Contenu et conformité

14. Créer les pages CMS légales :
    - CGV
    - CGU
    - Mentions légales

15. Implémenter le gestionnaire de consentement cookies :
    - modes : Fonctionnels, Préférences, Statistiques, Marketing
    - sauvegarde du consentement utilisateur
    - affichage conditionnel selon le niveau accepté

16. Préparer la structure CMS pour le blog et les pages légales :
    - `Page` avec `title`, `slug`, `content`
    - rendu HTML/Markdown côté frontend

## 5. Qualité et livraison

17. Documenter les API et le schéma de données dans OpenSpec.
18. Tester les endpoints API avec des fixtures.
19. Vérifier l’intégration frontend / backend avec un scénario de réservation.
20. Valider la conformité RGPD et l’affichage du consentement cookies.
