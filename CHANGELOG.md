# Changelog

All notable changes to this project will be documented in this file. This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 3.4.2 - 2022-05-03

## Changed

- remove ohdear functionality ([#63](https://github.com/bernskioldmedia/bm-wp-experience/pull/63))

## 3.4.0 - 2022-03-17

## Added

- Hide plugin ads in the admin panel ([#61](https://github.com/bernskioldmedia/bm-wp-experience/pull/61))
- Add custom block editor styling for better experience ([#60](https://github.com/bernskioldmedia/bm-wp-experience/pull/60))

## Fixed

- Fatal error because of the wrong name on a function in the Comments Module ([#59](https://github.com/bernskioldmedia/bm-wp-experience/pull/59))

## Dependency Updates

- Bump nanoid from 3.1.30 to 3.2.0 ([#56](https://github.com/bernskioldmedia/bm-wp-experience/pull/56))
- Bump follow-redirects from 1.14.7 to 1.14.8 ([#58](https://github.com/bernskioldmedia/bm-wp-experience/pull/58))

## 3.3.3 - 2022-03-02

## Fixed

- Issue with search not working with special characters

## 3.3.2 - 2022-02-02

## Fixed

- Fixed issue with yoast metabox after removing it ([#57](https://github.com/bernskioldmedia/bm-wp-experience/pull/57))

## 3.3.1 - 2022-01-14

## Fixed

- Mailer integration was not loading the right Hookable class ([#55](https://github.com/bernskioldmedia/bm-wp-experience/pull/55))

## 3.3.0 - 2022-01-14

## Added

- Seriously Simple Podcasting Integration: Show all episodes in feed ([#54](https://github.com/bernskioldmedia/bm-wp-experience/pull/54))
- Add support for SMTP e-mail sending ([#52](https://github.com/bernskioldmedia/bm-wp-experience/pull/52))

## Dependency Updates

- Bump follow-redirects from 1.14.5 to 1.14.7 ([#53](https://github.com/bernskioldmedia/bm-wp-experience/pull/53))

## 3.2.1 - 2021-12-17

## Fixed

- File would be loaded twice causing error ([#51](https://github.com/bernskioldmedia/bm-wp-experience/pull/51))

## 3.2.0 - 2021-12-17

## Added

- OhDear Application Health Integration ([#49](https://github.com/bernskioldmedia/bm-wp-experience/pull/49))

## Changed

- Weaker checks for file permissions ([#50](https://github.com/bernskioldmedia/bm-wp-experience/pull/50))

## 3.1.0 - 2021-12-04

## Added

- Add security headers to .htaccess on activation ([#48](https://github.com/bernskioldmedia/bm-wp-experience/pull/48))
- Add support for two-factor authentication ([#47](https://github.com/bernskioldmedia/bm-wp-experience/pull/47))

## 3.0.2 - 2021-11-27

## Fixed

- Fix warning on block editor ([#46](https://github.com/bernskioldmedia/bm-wp-experience/pull/46))

## 3.0.1 - 2021-11-27

### Fixed

- Fixes the release action so that the auto-updater script will work properly when downloading the ZIP.

## 3.0.0 - 2021-11-27

### Added

- Site health checks for configuration file permissions.
- Opinionated WooCommerce tweaks for performance and experience.
- SearchWP Integration for opinionated tweaks.
- Possibility to disable prettifying search URL. By default search URL will be prettified but can be overridden by defining `BM_WP_PRETTIFY_SEARCH_URL` as false in the config.

### Changed

- Refactored plugin to use our Plugin Base and PSR-4 autoloading.
- Added more passwords to our weak passwords list.
- 

### Fixed

- An `is_plugin_active` check would fail on some environments.

## [2.2.0] - 2021-10-07

### Changed

- By default, custom CSS will no longer be split out to its own file. To continue doing this, set `bm_wpexp_custom_css_as_file` to true.
- If `bm_wpexp_custom_css_as_file` is set to true, we will now hook into the inline small CSS system which inlines small CSS files automatically up to a global limit per page.

## [2.1.1] - 2021-08-27

### Added

- Added filter to hide only the BM help widget.

## [2.1.0] - 2021-07-31

### Added

- Remove Yoast SEO metabox in the block editor.

### Fixed

- Fixed a few PHP warnings (isset and static function call).

## [2.0.0] - 2021-07-16

### Added

- Remove color scheme picker by default. Can be overridden via filter `bm_wpexp_remove_color_scheme_picker`.
- Disable comments by default. Can be overridden by defining `BM_WP_ENABLE_COMMENTS` as true in the config.
- Remove Yoast SEO dashboard widget.
- Feature to disable update notices when website is on maintenance plan. To use, set `BM_WP_HAS_MAINTENANCE_PLAN` to true.
- Remove the Site Health dashboard widget if on maintenance plan.
- Remove the help tab.
- Remove import/export pages unless `BM_WP_ENABLE_IMPORT_EXPORT` is set to `true`.
- Custom branded admin theme.
- Add our help widget with support docs.
- If Admin Columns Pro is active, we load a set of upgraded admin column views.
- Remove ACF settings if on production.
- Dashboard widget highlighting BM Academy posts.

### Changed

- Renamed the `Authors` class to more generic `Users`.
- On multisite users need to be super admins in order to see environment notice.

### Fixed

- Dashboard widgets are now removed on network admin too.

## [1.4.0] - 2021-03-12

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
