## ADDED Requirements

### Requirement: WYSIWYG editor field
The system SHALL provide a `Wysiwyg` field class for MoonShine resources that renders a TinyMCE rich text editor.

#### Scenario: Field renders TinyMCE editor
- **WHEN** a resource form contains a `Wysiwyg::make('Content', 'content')` field
- **THEN** the form SHALL display a TinyMCE WYSIWYG editor with standard formatting toolbar (bold, italic, lists, links, headings)

#### Scenario: Field stores HTML content
- **WHEN** user submits the form with formatted content
- **THEN** the system SHALL store valid HTML in the database column

### Requirement: TinyMCE package integration
The system SHALL use the `moonshine/tinymce` Composer package for WYSIWYG functionality.

#### Scenario: Package installed
- **WHEN** `composer require moonshine/tinymce` is executed
- **THEN** the package SHALL be installed without conflicts with `moonshine/moonshine` v4.18.1

### Requirement: Resources updated to use Wysiwyg field
The following resources SHALL replace `Textarea::make()` with `Wysiwyg::make()` for content fields:
- `PackageResource` (description)
- `HotelResource` (description)
- `PostResource` (content)
- `PageResource` (content)
- `TestimonialResource` (content)

#### Scenario: PackageResource description field
- **WHEN** admin edits a Package in MoonShine
- **THEN** the description field SHALL display as a TinyMCE editor instead of a plain textarea

#### Scenario: PostResource content field
- **WHEN** admin edits a Post in MoonShine
- **THEN** the content field SHALL display as a TinyMCE editor instead of a plain textarea

#### Scenario: PageResource content field
- **WHEN** admin edits a Page in MoonShine
- **THEN** the content field SHALL display as a TinyMCE editor instead of a plain textarea

#### Scenario: TestimonialResource content field
- **WHEN** admin edits a Testimonial in MoonShine
- **THEN** the content field SHALL display as a TinyMCE editor instead of a plain textarea

#### Scenario: HotelResource description field
- **WHEN** admin edits an Hotel in MoonShine
- **THEN** the description field SHALL display as a TinyMCE editor instead of a plain textarea
