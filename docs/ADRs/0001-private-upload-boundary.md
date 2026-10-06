# ADR 0001: Private upload boundary

Context: WordPress normally moves media into publicly served uploads before creating its attachment record. Metadata flags cannot protect direct file URLs.

Decision: Intercept upload/sideload prefilters; retain asynchronous inputs outside public roots; return a private case reference and create attachments only after acceptance.

Alternatives considered: public placeholder attachments; relying on post status; web-server rules for an uploads subdirectory.

Trade-offs: asynchronous uploads do not immediately return a normal attachment ID; integrations need a status/appeal flow. Private storage is a deployment requirement.

Consequences: robust confidentiality for covered gateway paths; bypass integrations must be explicitly documented and tested.
