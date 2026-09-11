# Dynamic Navigation

## Purpose

Rendre la barre de navigation du frontend dynamique en consommant l'API `GET /api/menus` existante, permettant aux administrateurs de gérer les liens de navigation (activation, désactivation, ordre) depuis MoonShine sans modification du code source.

## Requirements

### Requirement: Frontend fetches menu items from API
The system SHALL fetch navigation menu items from the `GET /api/menus` endpoint on the server side during page rendering. The fetch SHALL use ISR revalidation (300 seconds).

#### Scenario: Menu items are fetched successfully
- **WHEN** the layout renders
- **THEN** the system SHALL call `GET /api/menus` and receive an array of menu item objects with `label`, `route`, `url`, `is_external`, `position` fields

#### Scenario: API call fails
- **WHEN** the `GET /api/menus` call fails or returns an error
- **THEN** the system SHALL fall back to an empty menu array and the Header SHALL render with only the logo

### Requirement: Header renders navigation from API data
The Header component SHALL render navigation links dynamically from the fetched menu items array instead of hardcoded constants.

#### Scenario: Desktop navigation displays active items
- **WHEN** the Header renders on a desktop viewport (lg breakpoint and above)
- **THEN** all active menu items SHALL be displayed as horizontal navigation links, ordered by their `position` value

#### Scenario: Mobile navigation displays active items
- **WHEN** the Header renders on a mobile viewport and the hamburger menu is opened
- **THEN** all active menu items SHALL be displayed as a vertical list, ordered by their `position` value

#### Scenario: Internal links use Next.js Link
- **WHEN** a menu item has a `route` value (non-null)
- **THEN** it SHALL be rendered as a Next.js `<Link>` component with `href` set to the route value

#### Scenario: External links open in new tab
- **WHEN** a menu item has `is_external = true` and a `url` value
- **THEN** it SHALL be rendered as an `<a>` tag with `href` set to the URL, `target="_blank"`, and `rel="noopener noreferrer"`

### Requirement: Active link highlighting
The Header SHALL highlight the currently active navigation link based on the current URL pathname.

#### Scenario: Home link is active on homepage
- **WHEN** the user is on the homepage (`/`)
- **THEN** the "Accueil" link SHALL have the active style (text-gold)

#### Scenario: Section link is active on subpages
- **WHEN** the user is on a page whose pathname starts with a menu item's route
- **THEN** that menu item's link SHALL have the active style (text-gold)

### Requirement: MoonShine admin controls menu visibility
Administrators SHALL be able to activate or deactivate menu items and reorder them via the existing MoonShine `MenuItemResource`.

#### Scenario: Admin deactivates a menu item
- **WHEN** an admin sets `is_active = false` on a menu item in MoonShine
- **THEN** that menu item SHALL NOT appear in the `GET /api/menus` response and consequently SHALL NOT be rendered in the frontend navigation

#### Scenario: Admin reorders menu items
- **WHEN** an admin changes the `position` value of menu items in MoonShine
- **THEN** the `GET /api/menu