## MODIFIED Requirements

### Requirement: Package model (2.1)
The system SHALL manage packages with a title, slug, duration, base price in quadruple room, description, and an optional currency association.

#### Scenario: Package includes currency
- **WHEN** a GET request is made to `/api/packages`
- **THEN** each package SHALL include a `currency` object with `code` and `symbol` fields (or null if no currency set)

### Requirement: Package endpoint (2.4)
The system SHALL expose a `GET /api/packages` endpoint that includes currency information with each package.

#### Scenario: API response includes currency
- **WHEN** a GET request is made to `/api/packages/{slug}`
- **THEN** the response SHALL include a `currency` field with `code` and `symbol` (or null)

### Requirement: Frontend pricing display (3.2)
The frontend SHALL use the package's associated currency when formatting prices, falling back to EUR if no currency is set.

#### Scenario: PackageCard displays dynamic currency
- **WHEN** a PackageCard renders a price with a package that has currency "USD"
- **THEN** the price SHALL be formatted as "$7 500" instead of "7 500 €"

#### Scenario: Fallback to EUR
- **WHEN** a PackageCard renders a price with a package that has no currency set (null)
- **THEN** the price SHALL be formatted as "7 500 €"
