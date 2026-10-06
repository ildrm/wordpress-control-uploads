# WP-CLI reference

`wp content-firewall` commands return JSON and use WordPress CLI error exit behavior. Run with the appropriate `--url` for each multisite tenant.

```sh
wp content-firewall health
wp content-firewall diagnostics
wp content-firewall queue status
wp content-firewall worker run --limit=20 --seconds=25
wp content-firewall scan attachment 123
wp content-firewall scan library
wp content-firewall rescan policy --after=0
wp content-firewall policy export
wp content-firewall policy import policy.json
wp content-firewall database status
wp content-firewall database migrate
wp content-firewall network provision
wp content-firewall provider test
```

Library work is batched and resumes through cursor jobs. Policy rescan is bounded to 100 records per command; continue with the returned cursor. Network provisioning handles 100 sites per call. `provider test` reports configuration/capabilities only; it makes no live request and does not claim authentication success. Full provider diagnostics require the credential-enabled contract suite.
