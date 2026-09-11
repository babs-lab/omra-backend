## ADDED Requirements

### Requirement: Admin can manage menu items via MoonShine
The system SHALL provide a MoonShine resource for CRUD operations on menu items. Each menu item SHALL have a label, an internal route or external URL, a position for ordering, and an active status.

#### Scenario: Admin creates a menu item
- **WHEN** an admin fills the MoonShine form with label "Notre Agence", route "/about", position 3, active true
- **THEN** a new MenuItem record is created with those values and returned in the API response

#### Scenario: Admin reorders menu items
- **WHEN** an admin changes the position value of a menu item via MoonShine
- **THEN** the API response reflects the new ordering

#### Scenario: Admin disables a menu item
- **WHEN** an admin sets `is_active` to false on a menu item
- **THEN** that item is excluded from the `GET /api/menus` response

### Requirement: API exposes active menu items
The system SHALL expose a `GET /api/menus` endpoint returning all active menu items sorted by position.

#### Scenario: Frontend fetches menus
- **WHEN** a GET request is made to `/api/menus`
- **THEN** the response SHALL be an array of objects with `label`, `route`, `url`, `is_external` fields, ordered by `position`

#### Scenario: Inactive items are excluded
- **WHEN** a GET request is made to `/api/menus`
- **THEN** items with `is_active = false` SHALL NOT appear in the response

### Requirement: Frontend renders dynamic navigation
The Next.js Header SHALL fetch menus from the API and render them as navigation links.

#### Scenario: Header displays API menus
- **WHEN** the Header component mounts
- **THEN** it SHALL call `GET /api/menus` and render each item as a navigation link

#### Scenario: Fallback when API is unavailable
- **WHEN** the API call to `/api/menus` fails
- **THEN** the Header SHALL display a fallback list with at least "Accueil" (`/`) and "Contact" (`/contact`)
