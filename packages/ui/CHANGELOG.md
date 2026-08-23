# Changelog

All notable changes to `@particle-academy/google-docs-ui`,
`@particle-academy/google-docs-js`, `particle-academy/google-docs-php` and
`fancy-google-docs`.

The four packages share one version, because they are generated from one
`provider/` definition and a version that meant something different in each
would be a version nobody could reason about.

## [0.1.0] — 2026-08-23

First release.

### Added

- `document_create` — create a blank Google Docs document from a title.
  `POST /v1/documents`.
- A top-level `Document` faker, so the node runs on a canvas with no Google
  account.

### Only the title is accepted

The request type is the full `Document`, but Google's discovery method says
every field other than `title` is ignored, including content. The action does
not offer fields the endpoint will silently discard.

### No sandbox, and no idempotency

Google has no Docs test estate. A test document is a real document in a real
Drive. `documents.create` also declares no idempotency key, so a retry can
create a second document and the action is honestly `unsafe-to-replay`.

[0.1.0]: https://github.com/Fancy-Friends/google-docs/releases/tag/v0.1.0
