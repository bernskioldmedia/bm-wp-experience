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
- Remove "Howdy" from the admin bar.

### Block Editor

- Disable the block directory.
- Remove Yoast SEO metabox in the block editor.

### Cleanup

- Remove WordPress version/generator info from header.
- Rewrite the search URL to a nice url (`/search/{query}`) instead of query variable unless specified by `BM_WP_PRETTIFY_SEARCH_URL`
- Prevent empty search queries from redirecting to home page
- Disable emoji styles
- Remove links to feeds unless specified by `BM_WP_DISABLE_FEED_URLS`.

### Comments

- Disable comments on site or network. Can be overridden with `BM_WP_ENABLE_COMMENTS`.

### Customizer

- Option to enqueues extra CSS from the customizer to a file instead of printing inline.

### Environments

- Show environment notice in admin bar for administrators.
- Show staging environment notice publically for administrators.
- Disable indexing for non-production environments.

### Mail

- Allows easy configuration of sending via SMTP instead of PHP Sendmail.

### Media

- Sanitize uploaded file names from non-ASCII characters.

### Multisite

- Have password resets go through the local site where the user is signing in, instead of the main site.

### Monitoring

- Added a REST API endpoint for Oh Dear that we use for monitoring client sites.

### Plugins

- Include a tab with suggested plugins from Bernskiold Media.
- Add a warning when disabling this plugin.

### REST API

- Restrict all API endpoints by default unless defined by `BM_WP_RESTRICT_REST_API` (all, users, none).
- Fixes a WP bug where pagination isn't working when sorting by menu order.

### Integration: SearchWP

The SearchWP integration automatically runs if SearchWP is active.

- Enables adding the license key via the `SEARCH_WP_LICENSE_KEY` in config.
- Disabled admin bar entry.

### Security

- Add two-factor authentication support.
- Ability to force two-factor authentication for the website.
- Force non-local environments to use strong passwords.
- Prevent users from using explicitly defined weak passwords.
- Default to disabling the core file editor from admin.
- Adds common-sense default HTTP headers to .htaccess on install.
- Adds rule to .htaccess to disable XMLRPC.

### Site Health

- Check that `wp-config.php` is secured properly.
- If an `.env` file exists in the public directory, check that it is secured.
- Check that our Company Cloud configuration files in `config/` are secured if it is placed in the web root.

### Updates

- Ability to hide update notices by defining `BM_WP_HAS_MAINTENANCE_PLAN` in the config.

### Users

- Prevent agency users from being indexed.
- Remove color scheme picker.

### WooCommerce

The WooCommerce integration automatically runs if WooCommerce is active.

- Disable startup wizard.
- Disable marketing section.
- Suppress notice about connecting store to WC.com.
- Remove suggestions from WooCommerce marketplace.
- Remove extension library from menus.
- Remove SkyVerge support dashboard.
- Hide some dashboard widgets.
- Remove WooCommerce widgets.
- Hide notice to install WC Admin.
- Remove order processing count in admin menu.
- Remove usage tracker cron event.
- Disables password strength meter.
- Removes assets on non-woocommerce pages.
- Removes fragments on non-woocommerce pages.

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

`bm_wpexp_custom_css_as_file` - Return true to split out customizer CSS to its own file.
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

### Mail

`BM_WP_SMTP_ENABLED` - Set to `true` to send e-mail via SMTP. By default this will only apply to production environments.
`BM_WP_SMTP_OUTSIDE_PRODUCTION` - Set to `true` to send e-mail via SMTP even if the environment is not set as production.
`BM_WP_SMTP_HOST` - Define the SMTP host to send through.
`BM_WP_SMTP_USERNAME` - Define the SMTP e-mail account username to send through.
`BM_WP_SMTP_PASSWORD` - Define the SMTP e-mail account password to send through.
`BM_WP_SMTP_PORT` - Set which port the connection should be made through. Should be set as an integer. Defaults to `587`.
`BM_WP_SMTP_SECURITY` - Set the sending security for the SMTP server. Defaults to `tls`.

### REST API

**Choose API restriction level:** By default, the REST API requires authentication for all endpoints. By setting the `BM_WP_RESTRICT_REST_API` constant you may change this. `all` (
default) restricts all endpoints. `users` restricts only the users endpoint. `none` doesn't restrict any endpoint.

### Security

**Enforce Two Factor Authentication:** By default two-factor authentication is an opt-in option for users. To force it, please define `BM_WP_REQUIRE_TWO_FACTOR` to true in your
config. By default all core roles with admin access are required to opt in.

`bm_wpexp_weak_passwords` - Customize the array of passwords that are always considered weak.
`bm_wpexp_roles_requiring_two_factor` - Customize the array of roles which are required to have two-factor authentication enabled.
`bm_wpexp_modify_htaccess_on_install` - Return false to stop the .htaccess file from being modified on install.

### Updates

**Hide update notices:** By default all update notices are showing, however for websites on a maintenance plan it is nice if users doesn't see any updates in the admin as they are
managed anyway (just not daily). Define `BM_WP_HAS_MAINTENANCE_PLAN` to `true` in the config to disable updates.

### Users

`bm_wpexp_allow_bm_author_index` - Define as `true` to allow indexing of agency users.
`bm_wpexp_authors_allowlisted_domains` - Allows you to customize the array of domains where agency users are always allowed (our own websites).
`bm_wpexp_authors_email_domains` - Allows you to customize the array of email domains that designate agency users.

`bm_wpexp_remove_color_scheme_picker` - Return `false` to override the default behavior of hide, and instead show the color scheme picker.

### WooCommerce

`bm_wpexp_woocommerce_widgets` - Customize the list of widgets to unregister.
`bm_wpexp_woocommerce_disable_password_strength_meter` - Return as `false` to enable the password strength meter.
`bm_wpexp_woocommerce_disable_assets_on_non_woo_pages` - Return as `false` to load assets even on non-WooCommerce pages.
`bm_wpexp_woocommerce_disable_fragments_on_non_woo_pages` - Return as `false` to load fragments even on non-WooCommerce pages. For example if you have a dynamic cart on all pages.

## Setting up Monitoring

To set up monitoring via [OhDear.app](https://ohdear.app) you need to add the REST API endpoint to the website in OhDear's application monitoring settings. The URL
is `https://yourdomain.com/wp-json/bm-wp-experience/v1/application-health`.

To run this endpoint, a secret must be configured and defined in your config:

```php
define( 'BM_WP_OH_DEAR_SECRET', 'my-secret-here' );
```

The same secret needs to be defined in OhDear's settings. It will then be sent via all requests to the API. The secrets in OhDear and the application must match for proper
authentication.
