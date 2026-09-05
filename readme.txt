=== Content Reset Tool ===
Contributors: grazingminds
Tags: reset, cleanup, content, development, staging
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Remove WordPress content quickly and safely on development or staging sites, without reinstalling WordPress.

== Description ==

Content Reset Tool gives WordPress administrators a simple way to clear a site's content layer when starting a new build, testing a theme, or preparing a staging environment.

It deliberately does **not** reinstall WordPress or remove your plugins, themes, users, or core configuration.

Choose between:

* **Content only** — removes posts, pages, custom post types, comments, taxonomies and navigation menus while keeping Media Library files.
* **Content + Media** — removes the same content and permanently deletes Media Library items and their uploaded files.

The tool works even when a plugin or theme that previously registered a custom post type has been deactivated. This makes it useful when replacing one WordPress build with another.

There are no external services, tracking, analytics, advertisements or telemetry.

**Important:** This is a destructive tool. Deleted content cannot be restored by the plugin. Always maintain a backup before using it on a site containing information you may need later.

== Installation ==

1. Upload the plugin through **Plugins → Add New → Upload Plugin**, or install it from the WordPress Plugin Directory.
2. Activate **Content Reset Tool**.
3. Go to **Tools → Content Reset**.
4. Review the content counts.
5. Select **Content only** or **Content + Media**.
6. Type `DELETE CONTENT`.
7. Confirm the reset.

The plugin does not need a separate account, license key or external service.

== What is removed? ==

When **Content only** is selected:

* Posts
* Pages
* Custom post types
* Revisions and other stored post objects
* Comments and comment metadata
* Taxonomy terms and relationships
* Navigation menus and menu items
* Orphaned post metadata and relationships

When **Content + Media** is selected, Media Library attachments and their associated uploaded files are also permanently deleted.

== What is preserved? ==

The plugin preserves:

* WordPress core files
* `wp-config.php`
* WordPress users and administrator accounts
* Installed plugins
* Installed themes
* WordPress core/site settings
* Media Library files when **Content only** is selected

== FAQ ==

= Does this reinstall WordPress? =

No. It only removes the selected content. Your WordPress installation remains intact.

= Will it delete my plugins or themes? =

No.

= Will it delete users? =

No. User accounts are preserved.

= What happens to my images? =

With **Content only**, Media Library items and their files are preserved. With **Content + Media**, they are permanently deleted.

= Does it remove custom post types? =

Yes. It also removes content belonging to custom post types that are no longer registered because their original plugin or theme has been deactivated.

= Can I undo a reset? =

No. The plugin has no undo function. Restore from a backup if you need deleted content back.

= Should I use this on a live production website? =

It is intended primarily for development, staging and testing environments. Do not use it on a production site unless you have a verified backup and deliberately intend to remove the selected content.

= Does the plugin send data anywhere? =

No. It has no external services, analytics, tracking or telemetry.

== Changelog ==

= 1.0.0 =
* Initial release.
* Content-only reset.
* Content-and-media reset.
* Support for registered and previously registered custom post types.
* Administrator confirmation and nonce protection.
