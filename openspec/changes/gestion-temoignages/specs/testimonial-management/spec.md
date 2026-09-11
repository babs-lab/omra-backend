## ADDED Requirements

### Requirement: Admin can manage testimonials via MoonShine
The system SHALL provide a MoonShine resource for CRUD operations on testimonials. Each testimonial SHALL have an author name, an optional city, the testimonial content, an optional rating (1-5), an optional avatar image, a position for ordering, and an active status.

#### Scenario: Admin creates a testimonial
- **WHEN** an admin fills the MoonShine form with name "Sarah M.", city "Lyon", content "Organisation parfaite du début à la fin.", rating 5, position 1, active true
- **THEN** a new Testimonial record is created with those values and returned in the API response

#### Scenario: Admin uploads a testimonial avatar
- **WHEN** an admin uploads a JPG/PNG/WebP avatar image in the testimonial form
- **THEN** the image is stored in the public testimonials directory and the testimonial exposes a resolvable `avatar_url`

#### Scenario: Admin disables a testimonial
- **WHEN** an admin sets `is_active` to false on a testimonial
- **THEN** that testimonial is excluded from the `GET /api/testimonials` response

#### Scenario: Admin reorders testimonials
- **WHEN** an admin changes the position value of a testimonial via MoonShine
- **THEN** the API response reflects the new ordering

### Requirement: API exposes active testimonials
The system SHALL expose a `GET /api/testimonials` endpoint returning all active testimonials sorted by position.

#### Scenario: Frontend fetches testimonials
- **WHEN** a GET request is made to `/api/testimonials`
- **THEN** the response SHALL be an array of objects with `name`, `city`, `content`, `rating`, `avatar`, `avatar_url`, `position` fields, ordered by `position`

#### Scenario: Inactive testimonials are excluded
- **WHEN** a GET request is made to `/api/testimonials`
- **THEN** testimonials with `is_active = false` SHALL NOT appear in the response

### Requirement: Frontend renders a testimonial section below the partner section
The Next.js application SHALL fetch active testimonials and render a testimonial section directly below the "Ils nous font confiance" section, split into two grids of 25/75 (stylized title on the left, testimonials on the right).

#### Scenario: Testimonial section is displayed below partners
- **WHEN** the layout renders and the API returns at least one active testimonial
- **THEN** the section SHALL be displayed directly below the partner section with a 25/75 layout
- **THEN** the left column (25%) SHALL display a stylized title using the site design tokens (Pridi heading font, gold accents, decorative divider)
- **THEN** the right column (75%) SHALL display the testimonials as cards styled like the reference site (quotation, avatar or author initials, author name, city, optional star rating)

#### Scenario: No testimonials available
- **WHEN** the API returns no active testimonials or the API call fails
- **THEN** the testimonial section SHALL NOT be rendered

### Requirement: Testimonials use a carousel when the list is long
The testimonial section SHALL display the testimonials in a native carousel when the number of testimonials exceeds the number visible per view, and SHALL fall back to a static grid otherwise.

#### Scenario: Long list uses carousel
- **WHEN** the API returns more active testimonials than the per-view capacity of the carousel
- **THEN** the carousel SHALL display testimonials in pages with previous/next arrows and navigation dots
- **THEN** the carousel SHALL auto-advance periodically and SHALL pause on hover

#### Scenario: Short list uses static grid
- **WHEN** the API returns fewer active testimonials than or equal to the per-view capacity
- **THEN** the testimonials SHALL be displayed in a static grid without carousel controls

### Requirement: Dedicated testimonials listing page
The system SHALL provide a `/temoignages` page listing all active testimonials with a stylized presentation consistent with the graphic charter.

#### Scenario: Page displays all testimonials
- **WHEN** a user visits `/temoignages`
- **THEN** the page SHALL display a stylized header (badge, Pridi heading, gold divider) and a responsive grid of testimonial cards with quotation, avatar or initials, author name, city and optional rating
- **THEN** the page SHALL have a page title "Témoignages"

#### Scenario: No testimonials available
- **WHEN** the API returns no active testimonials
- **THEN** the page SHALL display an empty-state message instead of the grid

### Requirement: Menu entry to the testimonials page
The system SHALL add a "Témoignages" entry to the site navigation linking to `/temoignages`.

#### Scenario: Header shows the link
- **WHEN** a user views the site header
- **THEN** the header SHALL display a "Témoignages" link pointing to `/temoignages`
- **THEN** the link SHALL use the same active/hover styling as the other navigation links

#### Scenario: Menu data includes the entry
- **WHEN** a GET request is made to `/api/menus`
- **THEN** the response SHALL include a "Témoignages" item with route `/temoignages`
