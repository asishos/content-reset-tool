# Content Reset Tool

A lightweight WordPress administration utility for resetting selected site content without reinstalling WordPress.

> **Warning:** This is a destructive tool. It is intended primarily for development, staging, testing, and rebuild environments. Always maintain and verify a working backup before use.

## Features

- **Content Only** reset mode
- **Content + Media** reset mode
- Removes standard WordPress posts and pages
- Removes custom post types
- Removes comments
- Removes taxonomy terms
- Removes navigation menus
- Cleans orphaned post/comment metadata and relationships
- Preserves WordPress core, installed plugins, themes, configuration, and users
- Optional Media Library deletion
- Administrator-only access
- WordPress nonce protection
- Explicit `DELETE CONTENT` confirmation
- No external services, telemetry, analytics, advertising, or tracking

## Reset modes

### Content Only

Removes:

- Posts
- Pages
- Custom post types
- Comments
- Taxonomy terms
- Navigation menus
- Related orphaned metadata/relationships

Media Library items and their uploaded files are preserved.

### Content + Media

Performs the Content Only reset and additionally permanently deletes Media Library attachments and their uploaded files.

## What it does not remove

The plugin does not intentionally remove:

- WordPress core
- WordPress user accounts
- Administrator accounts
- Installed plugins
- Installed themes
- `wp-config.php`
- WordPress installation settings
- Media files when using **Content Only**

## Requirements

- WordPress 6.0 or later
- PHP 7.4 or later
- Administrator-level access

## Installation

1. Download the repository.
2. Place the `content-reset-tool` directory in `wp-content/plugins/`.
3. Activate **Content Reset Tool** from **Plugins → Installed Plugins**.
4. Open **Tools → Content Reset**.

Alternatively, package the `content-reset-tool` directory as a ZIP and install it through **Plugins → Add New → Upload Plugin**.

## Safety

This plugin permanently deletes selected data.

Before using it:

1. Confirm that you are on the intended website.
2. Take a complete database and file backup.
3. Verify that the backup can be restored.
4. Select the correct reset mode.
5. Confirm the destructive action by entering `DELETE CONTENT`.

There is no undo function.

## Recommended use

This plugin is best suited to:

- WordPress development sites
- Staging environments
- QA/testing installations
- Theme development
- Plugin development
- Rebuilds where the WordPress installation itself should remain intact

**Do not use it on a production website unless you fully understand and intentionally accept the consequences.**

## Privacy

Content Reset Tool does not send site content or usage information to external services and does not include analytics, advertising, telemetry, or remote licensing.

## Repository structure

```text
content-reset-tool/
├── content-reset-tool.php
├── inc-admin.php
├── readme.txt
├── README.md
├── CHANGELOG.md
├── LICENSE.txt
└── assets/
    └── admin.css
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md).

## License

GPL-2.0-or-later. See [LICENSE.txt](LICENSE.txt).
