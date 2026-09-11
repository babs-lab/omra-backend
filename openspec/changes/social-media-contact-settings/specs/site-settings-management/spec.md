## ADDED Requirements

### Requirement: Site settings storage
The system SHALL store global site settings (email, phone, social media URLs) in a `site_settings` database table with `key` (unique string) and `value` (text) columns.

#### Scenario: Store a setting
- **WHEN** a setting is saved with key `email` and value `contact@omra.fr`
- **THEN** the record exists in `site_settings` with that key-value pair

#### Scenario: Prevent duplicate keys
- **WHEN** a setting is saved with a key that already exists
- **THEN** the system SHALL update the existing record's value

### Requirement: Moonshine admin resource
The system SHALL provide a Moonshine admin resource to manage site settings (email, phone, Facebook, Instagram, Twitter, WhatsApp URLs).

#### Scenario: Admin accesses site settings
- **WHEN** the admin navigates to the Site Settings resource in Moonshine
- **THEN** the form displays fields for email, phone, and each social media platform

#### Scenario: Admin updates settings
- **WHEN** the admin submits the form with new values
- **THEN** the settings are persisted in the database and the admin sees a success message

### Requirement: Public API endpoint
The system SHALL expose a `GET /api/site-settings` endpoint returning all site settings as JSON.

#### Scenario: Fetch site settings
- **WHEN** a client requests `GET /api/site-settings`
- **THEN** the response contains `email`, `phone`, `facebook`, `instagram`, `twitter`, `whatsapp` fields (nullable strings)

#### Scenario: No settings configured
- **WHEN** no settings exist in the database
- **THEN** the response contains all fields as `null`

### Requirement: Default seed data
The system SHALL provide a seeder that populates default site settings values.

#### Scenario: Seeder runs
- **WHEN** `php artisan db:seed` is executed
- **THEN** the `site_settings` table contains default entries for email, phone, and social media fields
