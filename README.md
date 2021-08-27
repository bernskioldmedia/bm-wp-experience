# BM WP Experience

On a typical WordPress setup there are many small tweaks that we do all the time. Helping with workflow, security or performance.

We call this our WordPress Experience because it's an opinionated set of features that make sense for a majority of our builds. Whether they are on
the [Company Cloud platform](https://companycloud.io) or an install with any theme or plugins. It's simply the way we like WordPress.

For almost every feature there is a filter, constant or action allowing you to customize the behavior.

## What do we do?

### Admin & Admin Bar

- Add slight Bernskiold Media branding
- Add links to Bernskiold Media help and support
- Clean up the admin bar with less important nodes (Comments, Yoast SEO, New Draft, Customizer)
- Remove lesser used dashboard widgets.
- Remove import/export pages by default and only show them if `BM_WP_ENABLE_IMPORT_EXPORT` is set to true. Most of the time we don't need this.
- Custom branded admin theme in our colors.
- Removes ACF settings if on production environment.

### Block Editor

- Disable the block directory.
- Remove Yoast SEO metabox in the block editor.

### Cleanup

- Remove WordPress version/generator info from header.
- Rewrite the search URL to a nice url (`/search/{query}`) instead of query variable.
- Prevent empty search queries from redirecting to home page
- Disable emoji styles
- Remove links to feeds unless specified by `BM_WP_DISABLE_FEED_URLS`.

### Comments

- Disable comments on site or network. Can be overridden with `BM_WP_ENABLE_COMMENTS`.

### Customizer

- Enqueues extra CSS from the customizer to a file instead of printing inline.

### Environments

- Show environment notice in admin bar for administrators.
- Show staging environment notice publically for administrators.
- Disable indexing for non-production environments.

### Media

- Sanitize uploaded file names from non-ASCII characters.

### Multisite

- Have password resets go through the local site where the user is signing in, instead of the main site.

### Plugins

- Include a tab with suggested plugins from Bernskiold Media.
- Add a warning when disabling this plugin.

### REST API

- Restrict all API endpoints by default unless defined by `BM_WP_RESTRICT_REST_API` (all, users, none).
- Fixes a WP bug where pagination isn't working when sorting by menu order.

### Security

- Force non-local environments to use strong passwords.
- Prevent users from using explicitly defined weak passwords.
- Default to disabling the core file editor from admin.

### Updates

- Ability to hide update notices by defining `BM_WP_HAS_MAINTENANCE_PLAN` in the config.

### Users

- Prevent agency users from being indexed.
- Remove color scheme picker.

## Constants & Filters

### Admin

**Enable Import/Export Screens:** By default we hide the import/export pages. If you need these in the menu, set `BM_WP_ENABLE_IMPORT_EXPORT` to `true`.

`bm_wpexp_custom_admin_theme` - Return false to disable our custom branding.
`bm_wpexp_show_help_widget` - Return false to hide the BM help widget.
`bm_wpexp_show_admin_page_support` - Return false to hide the support admin page.


### Block Editor

**Enable Block Directory:** By default the block directory is disabled. Define and set `BM_WP_ENABLE_BLOCK_DIRECTORY` to `false` to allow it.

### Cleanup

**Allow Feed URLs:** By default we hide feed URLs from the header. If you are using feeds, set `BM_WP_DISABLE_FEED_URLS` to `false` in your configuration.

### Comments

**Allow Comments:** By default we disable comments as more often than note we don't need them. If you want comments, just set `BM_WP_ENABLE_COMMENTS` to `true` in your
configuration.

### Customizer

`bm_wpexp_custom_css_storage_directory_path` - Customize the path to the storage directory for custom CSS.
`bm_wpexp_custom_css_storage_directory_uri` - Customize the URL to the storage directory for custom CSS.
`bm_wpexp_custom_css_file_name` - Customize the name of the custom CSS file.

### Environments

`bm_wpexp_staging_environment_label` - Customize the name of the environment shown in the admin bar.
`bm_wpexp_environment_role` - Customize which role the user must have in order to see the environment notices. Defaults to `manage_options`.
`bm_wpexp_environment_show_admin_bar` - Return `false` to hide the environment in the admin bar.
`bm_wpexp_environment_show_staging_public` - Return `false` to hide the public staging environment banner.
`bm_wpexp_environment_disable_indexing_for_non_production` - Return `false` to enable indexing for non-production environments.
`bm_wpexp_environment_staging_public_label` - Customize the label shown on the public staging environment banner.

### REST API

**Choose API restriction level:** By default, the REST API requires authentication for all endpoints. By setting the `BM_WP_RESTRICT_REST_API` constant you may change this. `all` (
default) restricts all endpoints. `users` restricts only the users endpoint. `none` doesn't restrict any endpoint.

### Security

`bm_wpexp_weak_passwords` - Customize the array of passwords that are always considered weak.

### Updates

**Hide update notices:** By default all update notices are showing, however for websites on a maintenance plan it is nice if users doesn't see any updates in the admin as they are
managed anyway (just not daily). Define `BM_WP_HAS_MAINTENANCE_PLAN` to `true` in the config to disable updates.

### Users

`bm_wpexp_allow_bm_author_index` - Define as `true` to allow indexing of agency users.
`bm_wpexp_authors_allowlisted_domains` - Allows you to customize the array of domains where agency users are always allowed (our own websites).
`bm_wpexp_authors_email_domains` - Allows you to customize the array of email domains that designate agency users.

`bm_wpexp_remove_color_scheme_picker` - Return `false` to override the default behavior of hide, and instead show the color scheme picker.
