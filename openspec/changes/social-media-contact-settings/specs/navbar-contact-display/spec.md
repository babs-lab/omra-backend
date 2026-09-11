## ADDED Requirements

### Requirement: Navbar contact display
The system SHALL display contact information (email, phone) and social media icons in the navbar, aligned to the right side.

#### Scenario: Desktop navbar display
- **WHEN** the page is rendered on desktop (lg breakpoint and above)
- **THEN** the navbar shows email icon, phone icon, and social media icons (Facebook, Instagram, Twitter, WhatsApp) to the right of the navigation links

#### Scenario: Mobile navbar display
- **WHEN** the page is rendered on mobile (below lg breakpoint)
- **THEN** the mobile menu includes email, phone, and social media icons

#### Scenario: Settings fetched from API
- **WHEN** the page loads
- **THEN** site settings are fetched from `GET /api/site-settings` and icons are rendered with correct links

### Requirement: Contact icons are clickable
Each contact icon in the navbar SHALL be a clickable link.

#### Scenario: Email icon click
- **WHEN** the user clicks the email icon
- **THEN** the browser opens `mailto:<email>` in a new tab

#### Scenario: Phone icon click
- **WHEN** the user clicks the phone icon
- **THEN** the browser opens `tel:<phone>` in a new tab

#### Scenario: Social media icon click
- **WHEN** the user clicks a social media icon
- **THEN** the browser opens the corresponding social media URL in a new tab

### Requirement: Dynamic footer contact
The Footer component SHALL display contact information fetched from site settings instead of hardcoded values.

#### Scenario: Footer displays email
- **WHEN** the footer renders
- **THEN** the email address is fetched from site settings API

#### Scenario: Footer displays phone
- **WHEN** the footer renders
- **THEN** the phone number is fetched from site settings API

### Requirement: Dynamic contact page
The contact page SHALL display contact information fetched from site settings instead of hardcoded values.

#### Scenario: Contact page displays info
- **WHEN** the contact page renders
- **THEN** email, phone, and social media links are fetched from site settings API
