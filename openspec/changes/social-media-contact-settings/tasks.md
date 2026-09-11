## 1. Backend - Base de données

- [x] 1.1 Créer la migration `site_settings` (colonnes `key` unique, `value` nullable text, timestamps)
- [x] 1.2 Créer le model `SiteSettings` avec method `instance()` singleton et casts appropriés
- [x] 1.3 Créer le seeder `SiteSettingsSeeder` avec des valeurs par défaut (email, téléphone, réseaux sociaux)

## 2. Backend - API

- [x] 2.1 Créer le controller `SiteSettingsController` avec méthode `index()` retournant les settings en JSON
- [x] 2.2 Enregistrer la route `GET /api/site-settings` dans `routes/api.php`

## 3. Backend - Moonshine Admin

- [x] 3.1 Créer la resource `SiteSettingsResource` dans `app/MoonShine/Resources/`
- [x] 3.2 Ajouter les fields : email, phone, facebook, instagram, twitter, whatsapp
- [x] 3.3 Enregistrer la resource dans `MoonShineLayout` dans la section appropriée

## 4. Frontend - Types et API

- [x] 4.1 Ajouter le type `SiteSettings` dans `frontend/src/types/index.ts`
- [x] 4.2 Créer la fonction `fetchSiteSettings()` dans `frontend/src/lib/api.ts`

## 5. Frontend - Navbar

- [x] 5.1 Créer le composant helper `Icon.tsx` pour les icônes SVG (email, phone, facebook, instagram, twitter, whatsapp)
- [x] 5.2 Modifier `Header.tsx` pour fetcher les site settings et les passer aux composants enfants
- [x] 5.3 Modifier `DesktopNav.tsx` pour afficher les icônes de contact et réseaux sociaux à droite
- [x] 5.4 Modifier `MobileMenu.tsx` pour afficher les icônes de contact et réseaux sociaux

## 6. Frontend - Footer et Contact

- [x] 6.1 Modifier `Footer.tsx` pour remplacer les valeurs hardcodées par les données de l'API
- [x] 6.2 Modifier `contact/page.tsx` pour remplacer les valeurs hardcodées par les données de l'API

## 7. Vérification

- [x] 7.1 Exécuter les migrations et le seeder
- [x] 7.2 Tester l'endpoint API `GET /api/site-settings`
- [x] 7.3 Vérifier l'affichage dans la navbar (desktop et mobile)
- [x] 7.4 Vérifier le rendu dynamique du footer et de la page contact
- [x] 7.5 Tester la mise à jour via Moonshine admin
