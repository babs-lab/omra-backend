## Why

Le site actuellement n'affiche aucune information de contact (email, téléphone) ni liens vers les réseaux sociaux dans la navbar. Ces informations sont cruciales pour la crédibilité d'une agence de voyage et permettent aux clients potentiels de contacter facilement l'entreprise. De plus, les informations de contact sont actuellement hardcodées dans le footer et la page contact, ce qui les rend difficiles à maintenir.

## What Changes

- Ajout d'un model `SiteSettings` pour stocker les paramètres globaux du site (email, téléphone, réseaux sociaux)
- Création d'une migration et d'une table `site_settings` en base de données
- Création d'un resource Moonshine pour gérer ces paramètres depuis l'admin
- Ajout d'un endpoint API `/api/site-settings` pour exposer les données au frontend
- Intégration des icônes de réseaux sociaux + email + téléphone dans la navbar (Desktop et Mobile)
- Les informations hardcodées dans le Footer et la page Contact seront remplacées par les valeurs dynamiques

## Capabilities

### New Capabilities
- `site-settings-management`: Système de gestion des paramètres globaux du site (email, téléphone, réseaux sociaux) avec stockage en base, resource Moonshine et endpoint API
- `navbar-contact-display`: Affichage dynamique des informations de contact et réseaux sociaux dans la navbar (desktop et mobile)

### Modified Capabilities

## Impact

- **Backend**: Nouvelle migration, model, controller API, resource Moonshine
- **Frontend**: Composants `Header`, `DesktopNav`, `MobileMenu` modifiés pour inclure les icônes et liens de contact
- **Footer**: Rendu dynamique au lieu de valeurs hardcodées
- **Page Contact**: Rendu dynamique au lieu de valeurs hardcodées
- **API**: Nouvel endpoint GET `/api/site-settings`
- **Base de données**: Nouvelle table `site_settings`
