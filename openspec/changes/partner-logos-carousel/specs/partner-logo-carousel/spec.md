# Partner Logo Carousel

## Purpose

Display active partner logos in a horizontally auto-scrolling carousel (marquee) on the frontend, replacing the static grid. The carousel loops seamlessly, pauses on hover, and respects reduced-motion preferences. Data and API remain unchanged.

## Requirements

### Requirement: Frontend renders partner logos as an auto-scrolling carousel
The Next.js application SHALL display active partners fetched from `GET /api/partners` inside a horizontally scrolling carousel that animates continuously and loops seamlessly without a visible jump.

#### Scenario: Carousel shows all logos scrolling automatically
- **WHEN** the app renders at least one active partner
- **THEN** the partner logos SHALL scroll horizontally in an infinite loop without a visible restart point

#### Scenario: Few partners still fill the carousel
- **WHEN** the API returns fewer than 4 active partners
- **THEN** the content SHALL be duplicated enough to fill the carousel width and keep the loop smooth

### Requirement: Carousel pauses on hover
The system SHALL pause the automatic scrolling while the user hovers the carousel area.

#### Scenario: Hovering stops the animation
- **WHEN** the user moves the pointer over the carousel
- **THEN** the scrolling SHALL stop until the pointer leaves the carousel

### Requirement: Carousel respects reduced motion
The system SHALL disable the automatic scrolling when the user prefers reduced motion, showing all partner logos statically.

#### Scenario: User prefers reduced motion
- **WHEN** the user has `prefers-reduced-motion: reduce` enabled
- **THEN** the carousel SHALL NOT animate and SHALL display all logos in a static layout

### Requirement: Partner links keep external-link behavior
Each partner logo with a website URL SHALL remain a link opening in a new tab with `rel="noopener noreferrer"` and an accessible `aria-label`.

#### Scenario: Logo links to a partner website
- **WHEN** a partner has a `url`
- **THEN** its logo SHALL be wrapped in an anchor with `target="_blank"`, `rel="noopener noreferrer"` and `aria-label` equal to the partner name

#### Scenario: Partner without a URL renders without a link
- **WHEN** a partner has no `url`
- **THEN** its logo SHALL be rendered without an anchor

### Requirement: Carousel renders only when partners exist
The carousel section SHALL NOT be rendered when the API returns no active partners or fails.

#### Scenario: No partners available
- **WHEN** the API returns an empty list or an error
- **THEN** the partner carousel section SHALL NOT be rendered

### Requirement: Fallback text for partners without a logo
A partner without a `logo_url` SHALL display its name as text inside the carousel.

#### Scenario: Partner has no logo image
- **WHEN** a partner has no `logo_url`
- **THEN** the carousel SHALL display the partner name as styled text instead of an image