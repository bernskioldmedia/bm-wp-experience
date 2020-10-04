# Changelog

All notable changes to this project will be documented in this file. This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
