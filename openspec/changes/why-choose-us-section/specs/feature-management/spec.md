# Feature Management

## Purpose

Gérer les arguments de vente ("Pourquoi nous choisir") dans MoonShine, les exposer via une API publique et les afficher dynamiquement sur la homepage du frontend.

## Requirements

### Requirement: Admin can manage features via MoonShine
The system SHALL provide a MoonShine resource for CRUD operations on features. Each feature SHALL have a title, an icon (SVG path), a position for ordering, and an active status.

#### Scenario: Admin creates a feature
- **WHEN** an admin fills the MoonShine form with title "Spécialiste Omra & Hajj", icon SVG path, position 1, active true
- **THEN** a new Feature record is created with those values

#### Scenario: Admin disables a feature
- **WHEN** an admin sets `is_active` to false on a feature
- **THEN** that feature is excluded from the `GET /api/features` response

#### Scenario: Admin reorders features
- **WHEN** an admin changes the position value of features via MoonShine
- **THEN** the API response reflects the new ordering

### Requirement: API exposes active features
The system SHALL expose a `GET /api/features` endpoint returning all active features sorted by position.

#### Scenario: Frontend fetches features
- **WHEN** a GET request is made to `/api/features`
- **THEN** the response SHALL be an array of objects with `title`, `icon`, `position` fields, ordered by `position`

#### Scenario: Inactive features are excluded
- **WHEN** a GET request is made to `/api/features`
- **THEN** features with `is_active = false` SHALL NOT appear in the response

### Requirement: Frontend renders a "Pourquoi nous choisir" section on the homepage
The Next.js application SHALL fetch active features from the API and render them as a "Pourquoi nous choisir" section on the homepage, placed between the packages section and the "À propos" section.

#### Scenario: Section is displayed with features
- **WHEN** the homepage renders and the API returns at least one active feature
- **THEN** the section SHALL display a heading "Pourquoi choisir OUMRA Teranga" and a grid of feature cards, each showing the icon and title

#### Scenario: Feature cards layout
- **WHEN** the section renders on desktop (lg breakpoint)
- **THEN** features SHALL be displayed in a 4-column grid

#### Scenario: Feature cards layout on mobile
- **WHEN** the section renders on mobile
- **THEN** features SHALL be displayed in a 2-column grid

#### Scenario: No features available
- **WHEN** the API returns no active features or the API call fails
- **THEN** the section SHALL NOT be rendered
