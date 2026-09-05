# Content Reset Tool

A lightweight WordPress administration utility for safely resetting selected site content without reinstalling WordPress.

> **Warning:** This is a destructive tool. It is intended primarily for development, staging, testing, and rebuild environments. Always maintain and verify a working backup before use.

## What's new in 1.1.0

- Visible WordPress environment indicator
- Stronger warning when a production environment is detected
- Required verified-backup acknowledgement
- Reset button stays disabled until the safety acknowledgement and exact confirmation are supplied
- Server-side validation of the safety acknowledgement
- Protection for WordPress system post types such as block templates, template parts and global styles
- Refined responsive admin interface

## Features

- **Content Only** reset mode
- **Content + Media** reset mode
- Standard posts and pages cleanup
- Custom post type cleanup, including previously registered custom post types
- Comment cleanup
- Taxonomy cleanup
- Navigation menu cleanup
- Orphaned metadata and relationship cleanup
- Administrator-only access
- WordPress nonce protection
- Explicit `DELETE CONTENT` confirmation
- No external services, tracking, analytics, advertising, telemetry, or license server

## Reset modes

### Content Only

Removes selected content while preserving Media Library items and their uploaded files.

### Content + Media

Removes the same content and additionally permanently deletes Media Library attachments and their uploaded files.

## Protected system data

The broad content reset does **not** intentionally delete WordPress system objects such as:

- WordPress core files
- User accounts
- Installed plugins
- Installed themes
- `wp-config.php`
- Block theme templates and template parts
- Global styles
- Customizer changesets
- Other protected WordPress system post types

Revisions are removed as part of deleting their parent content where WordPress handles them as associated data.

## Requirements

- WordPress 6.0+
- PHP 7.4+
- Administrator-level access

## Installation

1. Download the plugin ZIP from the GitHub release.
2. In WordPress, open **Plugins → Add New → Upload Plugin**.
3. Upload the ZIP.
4. Activate **Content Reset Tool**.
5. Open **Tools → Content Reset**.

## Safety

Before using the tool:

1. Confirm that you are on the intended website.
2. Take a complete database and file backup.
3. Verify that the backup can be restored.
4. Review the selected reset mode.
5. Acknowledge the verified backup requirement.
6. Type `DELETE CONTENT`.
7. Confirm the final browser warning.

There is no undo function.

## Recommended use

Content Reset Tool is best suited to:

- Development sites
- Staging environments
- QA/testing installations
- Theme development
- Plugin development
- Website rebuilds

Production use is discouraged. If you intentionally use it on production, understand that the selected data is permanently deleted.

## Privacy

The plugin does not send site content or usage information to external services and does not include analytics, advertising, telemetry, or remote licensing.

## License

GPL-2.0-or-later. See [LICENSE.txt](LICENSE.txt).

## Changelog

See [CHANGELOG.md](CHANGELOG.md).
