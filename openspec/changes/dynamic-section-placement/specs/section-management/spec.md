## ADDED Requirements

### Requirement: Section model with placement fields
The system SHALL provide a `Section` model with fields: `title`, `slug`, `content` (longText), `target_page` (string, slug of target page), `position` (integer, default 0), `style` (string, default 'default'), `is_active` (boolean, default true), `timestamps`.

#### Scenario: Create a section for homepage
- **WHEN** admin creates a section with `target_page=homepage`, `position=10`, `title="Welcome"`, `content="<p>Hello</p>"`
- **THEN** the section SHALL be stored with `is_active=true` and retrievable via API

#### Scenario: Section ordering by position
- **WHEN** multiple sections exist for `target_page=homepage` with positions 10, 20, 30
- **THEN** the API SHALL return them in order: position 10, 20, 30

### Requirement: Active sections only
The system SHALL only return sections where `is_active=true` via the public API.

#### Scenario: Inactive section hidden from API
- **WHEN** a section has `is_active=false`
- **THEN** the `GET /api/sections` endpoint SHALL NOT include it in the response

### Requirement: API endpoint for sections by target page
The system SHALL provide `GET /api/sections?target={slug}` returning active sections for a given target page, sorted by position.

#### Scenario: Fetch homepage sections
- **WHEN** client requests `GET /api/sections?target=homepage`
- **THEN** the system SHALL return all active sections where `target_page=homepage`, sorted by `position` ascending

#### Scenario: No sections for target
- **WHEN** client requests `GET /api/sections?target=nonexistent`
- **THEN** the system SHALL return an empty array `[]`

### Requirement: MoonShine admin resource
The system SHALL provide a `SectionResource` in MoonShine for managing sections with fields: title, slug, content (Wysiwyg), target_page (Select/Text), position, style, is_active.

#### Scenario: Admin creates section via MoonShine
- **WHEN** admin fills the section form with title, content, target_page="homepage", position=5
- **THEN** the section SHALL be saved and visible in the sections list
