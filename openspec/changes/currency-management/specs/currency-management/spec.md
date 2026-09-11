## ADDED Requirements

### Requirement: Admin can manage currencies via MoonShine
The system SHALL provide a MoonShine resource for CRUD operations on currencies. Each currency SHALL have a name, ISO code, symbol, and exchange rate relative to EUR.

#### Scenario: Admin creates a currency
- **WHEN** an admin fills the MoonShine form with code "USD", name "Dollar américain", symbol "$", exchange_rate 1.08
- **THEN** a new Currency record is created and returned in the API

#### Scenario: Admin deactivates a currency
- **WHEN** an admin sets `is_active` to false on a currency
- **THEN** that currency is excluded from the `GET /api/currencies` response

### Requirement: API exposes active currencies
The system SHALL expose a `GET /api/currencies` endpoint returning all active currencies.

#### Scenario: Frontend fetches currencies
- **WHEN** a GET request is made to `/api/currencies`
- **THEN** the response SHALL be an array of objects with `id`, `code`, `name`, `symbol`, `exchange_rate` fields
