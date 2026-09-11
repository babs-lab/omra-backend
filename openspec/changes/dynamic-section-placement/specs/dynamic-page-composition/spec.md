## ADDED Requirements

### Requirement: DynamicSections component
The system SHALL provide a `DynamicSections` async Server Component that fetches sections for a given target page via `GET /api/sections?target={slug}` and renders them as ordered HTML sections.

#### Scenario: Render sections for homepage
- **WHEN** `DynamicSections target="homepage"` is rendered
- **THEN** it SHALL fetch sections from `GET /api/sections?target=homepage` and render each as a `<section>` with the section's HTML content

#### Scenario: Empty sections
- **WHEN** no sections exist for the target page
- **THEN** the component SHALL return null (render nothing)

### Requirement: Homepage dynamic content integration
The homepage (`page.tsx`) SHALL render `DynamicSections target="homepage"` to display admin-managed sections between existing hardcoded sections.

#### Scenario: Homepage shows dynamic sections
- **WHEN** admin creates sections with target_page="homepage" and positions 5, 15, 25
- **THEN** the homepage SHALL render these sections in position order, integrated between the existing hero, packages, and why-choose sections

### Requirement: Section styles
Each section MAY have a `style` field that controls its visual presentation. Supported styles: 'default' (white background), 'dark' (dark background), 'gold' (gold accent background).

#### Scenario: Default style section
- **WHEN** a section has `style=default`
- **THEN** it SHALL render with a white background and standard padding

#### Scenario: Dark style section
- **WHEN** a section has `style=dark`
- **THEN** it SHALL render with a dark background and light text

### Requirement: Section rendering by target page
Any page component MAY use `DynamicSections target="{slug}"` to display sections placed on that page.

#### Scenario: Dynamic sections on internal page
- **WHEN** the "a-propos" page component includes `<DynamicSections target="a-propos" />`
- **THEN** sections with `target_page=a-propos` SHALL be rendered on that page
