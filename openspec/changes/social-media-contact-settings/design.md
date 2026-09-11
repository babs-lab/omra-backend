## Context

Le projet Omra Teranga utilise une architecture découplée : un backend Laravel avec Moonshine admin et un frontend Next.js communiquant via une API RESTful. Actuellement, aucune information de contact ou lien réseaux sociaux n'est affiché dans la navbar. Les informations de contact existantes (email, téléphone) sont hardcodées dans le footer et la page contact, rendant leur maintenance difficile.

Le frontend utilise React 19, Next.js 16, TailwindCSS v4. Le backend utilise Laravel 13 avec Moonshine admin. Les données sont communiquées via `GET /api/*` endpoints.

## Goals / Non-Goals

**Goals:**
- Créer un système de stockage des paramètres globaux du site (email, téléphone, réseaux sociaux)
- Permettre la gestion de ces paramètres via Moonshine admin
- Exposer les paramètres via une API RESTful
- Afficher dynamiquement les informations de contact et réseaux sociaux dans la navbar (desktop + mobile)
- Remplacer les valeurs hardcodées dans le footer et la page contact par des valeurs dynamiques

**Non-Goals:**
- Gestion de plusieurs langues pour les contacts
- Système de notification ou alertes
- Intégration avec des services tiers (WhatsApp Business API, etc.)
- Gestion des horaires d'ouverture

## Decisions

### 1. Table `site_settings` avec clé-valeur

**Décision**: Utiliser une table `site_settings` avec une colonne `key` (unique) et une colonne `value` (text), plutôt qu'un model dédié avec des colonnes fixes.

**Rationale**: 
- Plus flexible : ajout de nouveaux paramètres sans migration
- Pattern courant pour les settings globaux (similaire à `config` dans WordPress)
- Seul un seul enregistrement par clé, pas de relation Many-to-One

**Alternatives considérées**:
- Model avec colonnes fixes : moins flexible, nécessite une migration pour chaque nouveau champ
- Fichier de config Laravel : pas de gestion admin, pas de persistence en DB

### 2. Endpoint API unique `/api/site-settings`

**Décision**: Un seul endpoint GET qui retourne tous les paramètres publics.

**Rationale**:
- Simplicité : le frontend a besoin de tous les paramètres en une seule requête
- Pas besoin d'endpoints CRUD séparés car les settings sont gérés via Moonshine
- Le frontend peut typer la réponse facilement

**Alternatives considérées**:
- Endpoints séparés par type (`/api/site-settings/contact`, `/api/site-settings/social`) : plus de complexité, peu bénéfique vu le volume de données

### 3. Icônes SVG inline plutôt que bibliothèque d'icônes

**Décision**: Utiliser des icônes SVG inline (via un composant helper) plutôt qu'ajouter une bibliothèque comme `react-icons` ou `lucide-react`.

**Rationale**:
- Pas de dépendance supplémentaire
- Contrôle total sur le style et la taille
- Seules 5-6 icônes nécessaires (email, téléphone, Facebook, Instagram, Twitter, WhatsApp)

**Alternatives considérées**:
- `lucide-react` : ajout de ~100KB, overkill pour 5-6 icônes
- `react-icons` : similaire, ajout de dépendance inutile

### 4. Singleton pattern pour SiteSettings

**Décision**: Le model `SiteSettings` utilisera un pattern singleton (une seule ligne en base, accès via `SiteSettings::instance()`).

**Rationale**:
- Il n'y a qu'un seul ensemble de paramètres pour le site
- Simplifie l'accès : `SiteSettings::instance()->email`
- Évite les erreurs de "record not found"

## Risks / Trade-offs

- **Cache du frontend**: Sans cache, chaque requête page charge les settings → atténuer via `cache: 'no-store'` (déjà le cas) ou edge caching futur
- **Données manquantes**: Si aucun settings n'existe en base, le frontend doit gérer le cas vide → ajouter des valeurs par défaut dans le seeder
- **Performance Moonshine**: La resource Moonshine doit être simple et intuitive pour les administrateurs non-techniques
