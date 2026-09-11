# Partner Management

## Purpose

Manage partner records (name, logo, website URL, ordering position, active status) in MoonShine, expose active partners through the public API, and render them on the frontend below the footer.

## Requirements

### Requirement: Admin can manage partners via MoonShine
The system SHALL provide a MoonShine resource for CRUD operations on partners. Each partner SHALL have a name, an optional logo image, an optional website URL, a position for ordering, and an active status.

#### Scenario: Admin creates a partner
- **WHEN** an admin fills the MoonShine form with name "Agence Al Baraka", logo image, URL "https://albarka.example", position 1, active true
- **THEN** a new Partner record is created with those values and returned in the API response

#### Scenario: Admin uploads a partner logo
- **WHEN** an admin uploads a JPG/PNG/SVG logo image in the partner form
- **THEN** the image is stored in the public partners directory and the partner exposes a resolvable `logo_url`

#### Scenario: Admin disables a partner
- **WHEN** an admin sets `is_active` to false on a partner
- **THEN** that partner is excluded from the `GET /api/partners` response

#### Scenario: Admin reorders partners
- **WHEN** an admin changes the position value of a partner via MoonShine
- **THEN** the API response reflects the new ordering

### Requirement: API exposes active partners
The system SHALL expose a `GET /api/partners` endpoint returning all active partners sorted by position.

#### Scenario: Frontend fetches partners
- **WHEN** a GET request is made to `/api/partners`
- **THEN** the response SHALL be an array of objects with `name`, `logo`, `logo_url`, `url`, `position` fields, ordered by `position`

#### Scenario: Inactive partners are excluded
- **WHEN** a GET request is made to `/api/partners`
- **THEN** partners with `is_active = false` SHALL NOT appear in the response

### Requirement: Frontend renders a partner section below the footer
The Next.js application SHALL fetch active partners from the API and render them as a partner section placed directly below the footer on every page.

#### Scenario: Partner section is displayed
- **WHEN** the layout renders and the API returns at least one active partner
- **THEN** the section SHALL display the partner logos below the footer

#### Scenario: Partner logos link to partner websites
- **WHEN** a partner has a website URL
- **THEN** its logo SHALL be wrapped in a link opening in a new tab with `rel="noopener noreferrer"`

#### Scenario: No partners available
- **WHEN** the API returns no active partners or the API call fails
- **THEN** the partner section SHALL NOT be rendered
