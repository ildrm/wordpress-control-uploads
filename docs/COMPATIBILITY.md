# Compatibility

Declared minimum: WordPress 6.8, PHP 8.2, MySQL 8 or MariaDB 10.11+. Database minimum is enforced because queue claims use SKIP LOCKED. Recommended runtime: currently maintained PHP 8.3+ and HTTPS. Required PHP extensions: fileinfo, JSON, sodium; enabled features additionally need GD, DOM, ZIP, curl, mbstring and scanner tooling.

Initially exercised locally: PHP 8.5.8 unit/contract tests and WordPress 6.8.3 / PHP 8.3.28 / MariaDB 11.4 integration tests. CI specifies broader runtime/WordPress matrices; configured matrix entries are not claims of completed runs.

Subsequent real integration runs also passed on WordPress 6.9.4 and 7.0.4. Current WordPress multisite tenant tests and scoped Chrome admin/axe/RTL checks passed. The PHP CLI container is 8.3.35; the web integration container is 8.3.28. Other PHP versions remain CI targets pending execution.

WordPress Media/AJAX/REST uploads and sideloads traverse the covered prefilters. Client media transforms still reach server validation. Third-party direct filesystem writes, object-storage uploads and custom override action names can bypass the gateway and need adapters. Existing-library scanning is retrospective; already public files are not made private automatically.

Single-site records are explicitly site-scoped. Network policy snapshots override site policy; large-network provisioning is batched by CLI. Complete multisite acceptance requires the dedicated tenant tests and offload/integration fixtures.

Sources: [WordPress upload flow](https://developer.wordpress.org/reference/functions/_wp_handle_upload/), [REST attachment controller](https://developer.wordpress.org/reference/classes/wp_rest_attachments_controller/), [WordPress requirements](https://wordpress.org/about/requirements/), [plugin guidelines](https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/).
