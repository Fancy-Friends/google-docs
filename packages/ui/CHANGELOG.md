# Changelog

All notable changes to `@particle-academy/google-docs-ui`,
`@particle-academy/google-docs-js`, `particle-academy/google-docs-php` and
`fancy-google-docs`.

The four packages share one version, because they are generated from one
`provider/` definition and a version that meant something different in each
would be a version nobody could reason about.

## [0.2.0] — 2026-08-24

### Changed

- **`@particle-academy/google-docs-ui` is now an OPTIONAL PEER dependency of `@particle-academy/google-docs-js`, not a hard one.**

`./flow` needs it; nothing else does. It was a hard dependency, and because
`@particle-academy/google-docs-ui` itself peer-depends on `fancy-flow` — which npm 7+ installs
automatically — `npm install @particle-academy/google-docs-js` pulled the **entire flow engine**
onto disk for a consumer who only wanted to call the API. Roughly **18 MB
became 874 KB**, and the package works exactly as before:

```js
import { googleDocs… } from "@particle-academy/google-docs-js";
// an injected transport, no flow engine anywhere
```

**This is breaking if you use `@particle-academy/google-docs-js/flow`.** Add `@particle-academy/google-docs-ui` to your own
dependencies — it was always being installed for you, and now it is declared.
Everything importing only the main entry point is unaffected.

The fix is on this edge rather than on `@particle-academy/google-docs-ui` → `fancy-flow`: the ui package
genuinely requires fancy-flow, since it calls `defineConnectorKind`, and marking
that peer optional would be a lie about what it needs.

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
[0.2.0]: https://github.com/Fancy-Friends/google-docs/releases/tag/v0.2.0
