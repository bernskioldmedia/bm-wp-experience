# Changelog

All notable changes to this project will be documented in this file. This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Public notice for logged in admins to clearly show when on a staging environment. (#34)
- Notice in the admin bar showing environment for admins. (#34)
- Prevent non-production environments from being indexed. (#35)
- Multisite: Make password resets use the local blog and not the main blog. (#33)

### Changed
- Renamed the `bm_wpexp_authors_whitelisted_domains` to `bm_wpexp_authors_allowlisted_domains`.
- Environment control of when weak passwords are allowed is now done via `wp_get_environment_type` instead of via TLD.

### Removed
- `bm_wpexp_test_tlds` no longer exists as it is not necessary.

## [1.3.0] - 2021-01-30

### Added
- Fix for REST API pagination with pages that caused duplicates in Gutenberg, until WordPress fixes this in core.

### Changed
- Hook custom stylesheet much later to try and override most other loaded styles.
- Updated the BM logo. We've got a new one.

### Fixed
- Custom styles weren't loaded in the editor.

## [1.2.0] - 2020-10-17

### Added
- Sanitization of upload filenames. No more bad characters that cause problems.

### Changed
- No longer whitelist BM dev domains for author indexing.

### Fixed
- Added missing namespaces to some files.

### Removed
- Support beacon because of low usage.
- Non-working ACF license management.

## [1.1.1] - 2020-10-04

### Added
- A constant `BM_WP_DISABLE_FEED_URLS` that controls whether the feed URLs will be cleaned or not. Defaults to current behavior which is true.

### Changed
- Updated the composer.json for proper formatting.
- Removing dev scripts from the committed composer vendor folder.

### Fixed
- An issue where the extra CSS file saving would overrite on multisite.

### Removed
- Unused folders that were left as placeholders.

## [1.1.0] - 2020-08-12

### Added
- Custom CSS added via the customizer now saves to a local file instead of being loaded inline.
- Disables the block directory added in WP 5.5. Define `BM_WP_ENABLE_BLOCK_DIRECTORY` as true in your config to re-enable.

### Changed
- Upgrade the Github Plugin Update Checker to the latest version. The new version has a different classname, reflected in `bm-wp-experience.php`.
