## Why

L'agence souhaite mettre en avant ses partenaires (agences, compagnies, organismes) pour renforcer la crédibilité du site. Aujourd'hui aucun mécanisme ne permet d'enregistrer des partenaires ni de les afficher publiquement. L'équipe marketing doit pouvoir les gérer sans intervention technique.

## What Changes

- **Nouveau modèle `Partner`** dans le backend Laravel avec un resource MoonShine pour le CRUD (nom, logo, URL du site, ordre, statut actif)
- **Nouvel endpoint API** `GET /api/partners` exposant uniquement les partenaires actifs
- **Nouveau composant `PartnerSection`** dans le frontend Next.js affichant les logos des partenaires juste en dessous du footer
- **Système d'activation/désactivation** individuel de chaque partenaire (switcher dans MoonShine, exclusion de l'API quand inactif)

## Capabilities

### New Capabilities
- `partner-management`: CRUD des partenaires via MoonShine (nom, logo, URL, ordre, statut actif) + exposition des partenaires actifs via `GET /api/partners` + rendu d'une section partenaires en bas de page dans le frontend

### Modified Capabilities
<!-- Aucune spec existante modifiée -->

## Impact

- **Backend**: Nouveau modèle + migration + resource MoonShine + contrôleur API + route + seeder éventuel
- **Frontend**: Nouveau composant `PartnerSection` + type `Partner` + fonction `fetchPartners()` + intégration dans `layout.tsx` sous le `Footer`
- **API**: Nouvelle route `GET /api/partners`
