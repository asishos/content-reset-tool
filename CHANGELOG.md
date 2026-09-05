# Changelog

All notable changes to Content Reset Tool are documented here.

## 1.1.0 — Safety & UX Update

- Added visible WordPress environment indicator.
- Added stronger warning when a production environment is detected.
- Added required verified-backup acknowledgement before reset.
- Reset button remains disabled until safety acknowledgement and exact confirmation are supplied.
- Added server-side validation of the safety acknowledgement.
- Protected WordPress system post types such as block templates, template parts and global styles from broad content deletion.
- Refined the admin interface and responsive layout.

## 1.0.0 — Initial Release

- Content-only reset.
- Content + Media reset.
- Standard and custom post type cleanup.
- Comment, taxonomy and navigation menu cleanup.
- Orphaned metadata/relationship cleanup.
- Administrator capability checks.
- WordPress nonce protection.
- Explicit `DELETE CONTENT` confirmation.
