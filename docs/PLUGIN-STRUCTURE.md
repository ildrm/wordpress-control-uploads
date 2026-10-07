# Plugin files and structure

The installable directory and main file use the slug `content-firewall`: **`content-firewall/content-firewall.php`**. WordPress recognizes plugins by their header, so the earlier generic filename could load, but a slug-named root entry follows the [Plugin Handbook's file-organization guidance](https://developer.wordpress.org/plugins/plugin-basics/best-practices/#file-organization). The latest project instruction supersedes the filename in the archived source requirements; its original statement and ID are preserved in the ledger.

## Layout

```text
content-firewall/
├── content-firewall.php   # Single plugin header, direct-access guard, lifecycle hooks
├── uninstall.php          # WordPress uninstall entry, guarded by WP_UNINSTALL_PLUGIN
├── readme.txt             # WordPress plugin readme and external-service disclosure
├── LICENSE
├── includes/
│   └── autoload.php        # Composer in development; equivalent fallback in releases
├── src/                   # Namespaced PSR-4 PHP modules, grouped by responsibility
├── assets/
│   ├── css/admin.css       # Human-readable administration stylesheet
│   ├── js/admin.js         # Compiled administration script
│   └── src/                # Corresponding TypeScript/TSX source
├── languages/             # Text domain catalogs
├── docs/                  # Deployment, API, architecture and review guides
├── tools/                 # Build/release tooling; ZIP includes build.mjs
├── tests/                 # Source-checkout tests, excluded from ZIP
├── composer.json / composer.lock
├── package.json / package-lock.json
└── tsconfig.json
```

Repository-only CI, test/configuration files, installed `vendor`/`node_modules`, test results and generated `dist` artifacts are separate from the installable runtime. The checkout's directory name may differ from the installed slug; packaging always creates one top-level `content-firewall/` directory. Composer metadata supplies `extra.installer-name=content-firewall` for consumers using [composer/installers](https://github.com/composer/installers#custom-install-names), preserving the existing package identifier without changing the installation slug. It adds no PHP runtime dependency. The handbook's folder example is a recommendation, not a requirement to split every class between `admin`, `public` and `includes`. The existing namespaced `src/` modules keep PSR-4 autoloading and domain boundaries consistent; administration hooks load conditionally.

## Metadata and lifecycle

The main file contains one [plugin header](https://developer.wordpress.org/plugins/plugin-basics/header-requirements/) with the name **Content Firewall**, version 0.1.0, the supported WordPress/PHP minima, a single preserved author/author URL, GPL license and license URL, and `content-firewall` text domain with `/languages`. The readme name matches and its `Tested up to` field records the exercised WordPress major/minor version. The display name removes the leading WordPress trademark; directory naming/trademark rules are described in [guideline 17](https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/#17-plugins-must-respect-trademarks-copyrights-and-project-names).

Activation and deactivation callbacks are registered at top level against the main file. Runtime hooks are registered on `plugins_loaded`; the uninstall entry remains at the root. The main file refuses direct requests without WordPress. The autoloader refuses web requests without WordPress while allowing the documented standalone CLI fixtures. PHP module files contain declarations rather than executable endpoints; they do not need redundant entry headers or duplicate bootstrap files.

**Updating an installed earlier engineering build:** deactivate it before replacing its files, then activate Content Firewall again. WordPress tracks the main-file basename, which changed from the earlier build. Update any deployment script that explicitly names that old basename. Existing policy/table identifiers are not renamed by this file-layout change. No compatibility entry with a second plugin header is shipped.

## Distribution and corresponding source

The ZIP includes the minified script **and** its corresponding TypeScript source, `tools/build.mjs`, `package.json`, `package-lock.json` and `tsconfig.json`. This implements the source-availability option in [directory guideline 4](https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/#4-code-must-be-mostly-human-readable). From the extracted plugin directory, rebuild with:

```sh
npm ci
npm run build
npm run typecheck
```

Tests and general verification tools require the source checkout. Build dependencies are development inputs and are not bundled runtime dependencies; WordPress supplies React and its own component packages. Explicit packaging file types keep caches/local exports out of the ZIP. No vendor directory, native executable, credentials, test fixture or nested duplicate plugin root is included. Directory artwork, if later added, belongs to WordPress.org's separate SVN assets location rather than being confused with installed CSS/JS.

`tools/verify-release.py` checks deterministic output, one slug-named header/root PHP entry plus uninstall, runtime/source/build files and checksums, loads the package without Composer/vendor, and rebuilds the extracted JavaScript to compare bytes. `tests/Integration/structure.php` uses WordPress itself to check discovery, metadata, active basename, lifecycle registration, scheduled hooks and enqueued asset URLs/dependencies. CI runs this fixture immediately after activation. [TESTING.md](TESTING.md) contains the rest of the validation sequence.

These corrections address file organization and packaging. They do not establish directory approval, verify the contributor account or reserve a public slug. Complete-product and submission acceptance remain in [RELEASE-STATUS.md](RELEASE-STATUS.md).
