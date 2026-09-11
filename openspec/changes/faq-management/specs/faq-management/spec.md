# Faq Management

## Purpose

Manage FAQ question/answer pairs in MoonShine, expose active FAQs through a public API endpoint, and render them as an accessible accordion on the homepage, similar to the reference site (manasikomra.fr).

## Requirements

### Requirement: Admin can manage FAQs via MoonShine
The system SHALL provide a MoonShine resource for CRUD operations on FAQs. Each FAQ SHALL have a question, an answer, a position for ordering, and an active status.

#### Scenario: Admin creates a FAQ
- **WHEN** an admin fills the MoonShine form with question "Le visa est-il inclus dans le package ?", answer "Non, les formules n'incluent pas le visa mais on offre une assistance complète.", position 1, active true
- **THEN** a new FAQ record is created with those values and returned in the API response

#### Scenario: Admin disables a FAQ
- **WHEN** an admin sets `is_active` to false on a FAQ
- **THEN** that FAQ is excluded from the `GET /api/faqs` response

#### Scenario: Admin reorders FAQs
- **WHEN** an admin changes the position value of a FAQ via MoonShine
- **THEN** the API response reflects the new ordering

### Requirement: API exposes active FAQs
The system SHALL expose a `GET /api/faqs` endpoint returning all active FAQs sorted by position.

#### Scenario: Frontend fetches FAQs
- **WHEN** a GET request is made to `/api/faqs`
- **THEN** the response SHALL be an array of objects with `id`, `question`, `answer`, `position` fields, ordered by `position`

#### Scenario: Inactive FAQs are excluded
- **WHEN** a GET request is made to `/api/faqs`
- **THEN** FAQs with `is_active = false` SHALL NOT appear in the response

### Requirement: Frontend renders an FAQ accordion on the homepage
The Next.js application SHALL fetch active FAQs from the API and render them as an accessible accordion section on the homepage.

#### Scenario: FAQ section is displayed
- **WHEN** the homepage renders and the API returns at least one active FAQ
- **THEN** the section SHALL display each FAQ as an expandable/collapsible item with the question as header and the answer as body

#### Scenario: Clicking a question toggles the answer
- **WHEN** a user clicks or activates a FAQ question
- **THEN** the associated answer SHALL expand and be visible, and clicking again SHALL collapse it

#### Scenario: No FAQs available
- **WHEN** the API returns no active FAQs or the API call fails
- **THEN** the FAQ section SHALL NOT be rendered