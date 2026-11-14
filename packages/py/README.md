# Google Docs

[![Fancified](art/fancified.svg)](https://particle.academy)

Google Docs for [fancy-flow][flow] — as **four imported, versioned packages**, one
per runtime. Not vendored source: a copy cannot be upgraded, and third-party APIs
change.

[flow]: https://github.com/Particle-Academy/fancy-flow

| Runtime | Package | Install |
|---|---|---|
| Authoring surface (every host) | `@particle-academy/google-docs-ui` | `npm install @particle-academy/google-docs-ui` |
| Node | `@particle-academy/google-docs-js` | `npm install @particle-academy/google-docs-js` |
| PHP 8.4+ | `particle-academy/google-docs-php` | `composer require particle-academy/google-docs-php` |
| Python 3.11+ | `fancy-google-docs` | `pip install fancy-google-docs` |

The `ui` package is the editor surface and is React on every host — a PHP or
Python project installs it *and* its own runtime package, and never the `js` one.

## What it costs you

One dependency: `@particle-academy/fancy-connector-core` (or
`particle-academy/fancy-connector-core` on Composer), which the `js` and `php`
packages pull in themselves. The Python package has **zero** runtime
dependencies.

**No Google Docs SDK.** Plain HTTP, deliberately: a vendor SDK is third-party code
subject to the kit's full approval bar, and one per provider is hundreds of
dependencies nobody is tracking.

## Setting it up

Everything below is generated from `provider/manifest.json`, so it cannot disagree with what the packages do.

### On Google Docs's side

1. **Create (or reuse) the Google Cloud project for **your app's name**** — Every Google connector shares ONE consent grant (oauth.grant "google"), so use one project and one OAuth client for all of them: one consent and one refresh token per person. ([developers.google.com](https://developers.google.com/workspace/guides/create-project))
2. **Enable the Google Docs API** — Console: APIs & Services, Library; open the Google Docs API and click Enable. ([developers.google.com](https://developers.google.com/workspace/guides/enable-apis))
3. **Configure the consent screen** — Console: Google Auth platform, Branding (app name **your app's name**, support email, contact email), then Audience: Internal for people inside your Google Workspace organisation only, or External (while it is in testing, add each tester under Test users). Then Data Access, Add or Remove Scopes, and add `https://www.googleapis.com/auth/documents` beside the scopes of any other Google connector you use. You cannot remove the consent screen once it is configured. ([developers.google.com](https://developers.google.com/workspace/guides/configure-oauth-consent))
4. **Create a Web application OAuth client** — Console: Google Auth platform, Clients, Create Client; type Web application. Under Authorized redirect URIs click Add URI and paste **your host's OAuth redirect URL**, then Create. Copy the client ID and client secret when the client is created. ([developers.google.com](https://developers.google.com/workspace/guides/create-credentials))
5. **Connect an account and check it works** — Connect one Google account through **your app's name**'s OAuth flow, then run the check below. ([developers.google.com](https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/create))

Every step in full — who does it, what to paste, which credentials it yields, and how you know it worked — is in [SETUP.md](SETUP.md).

### Credentials

A Google Docs connection holds 4 values.

**Two kinds of value, and mixing them up matters.** A `provider` credential is ONE value for the whole installation — an OAuth app's client secret serves every connected account. An `account` credential is one per connected account. A host that stores the second where it stores the first lets one account's credentials reach another's.

| Field | Scope | Secret | Where it comes from |
|---|---|---|---|
| **OAuth client ID** | per installation | not secret | From Google Cloud Console -> APIs & Services -> Credentials. ONE value for the whole installation, not per connected account. |
| **OAuth client secret** | per installation | **secret** | The client secret for the same OAuth app. One value for the whole installation. |
| **Access token** | per connected account | **secret** | Per connected Google account, and it expires after ONE HOUR. The host refreshes it with the refresh token. |
| **Refresh token** | per connected account | **secret** | Per connected Google account. Google issues one only when the consent request asks for offline access; without it the connection dies within the hour. |

### Authorising

Google Docs uses OAuth2 (authorization_code). The package DECLARES the exchange; the HOST performs it — a consent screen needs a browser, a redirect URI and somewhere to persist the result, and all three belong to the host.

- **Authorize URL** — https://accounts.google.com/o/oauth2/v2/auth
- **Token URL** — https://oauth2.googleapis.com/token
- **Scopes** — `https://www.googleapis.com/auth/documents`
- **Access token lifetime** — 3600 seconds (1 hours). A host that never refreshes works all afternoon and is broken by morning.

**One consent grant, shared** (`grant: "google"`). Every connector declaring the same grant can run on ONE OAuth client, with one consent and one refresh token per person.

- **Authorize with** `access_type=offline`, `include_granted_scopes=true`. Ask for a feature's scopes when it is first used; the new token covers every scope granted before. A refresh token comes back only on the FIRST exchange, so keep the stored one when an exchange returns none.
- **Revoke** — POST https://oauth2.googleapis.com/revoke with `token`. **It removes the WHOLE grant**: every connector sharing it, not only this one. A per-feature disconnect stops using that feature's scopes locally; only a full disconnect revokes.
- **Identify the account by `sub`**: request `openid`, then verify the token response's id_token (issuer `https://accounts.google.com` or `accounts.google.com`, keys at https://www.googleapis.com/oauth2/v3/certs, audience = `clientId`). Never key a connection by email.
- **No restricted scopes** in this connector.

The refresh tokens do **not** rotate: the same one is reusable, so a refresh may safely be retried and may run concurrently. Stated rather than assumed, because the opposite — a provider that spends the token and revokes the grant on a replay — looks identical until it happens.

### The estate

**Google Docs has no test estate, and somebody checked.** Everything this connector does is real. Use the faker to build against it.

> Google has no sandbox for Docs. A test document is a real one in a real Drive, so every create is real -- use the faker while developing and clean up any live test documents.

## What it can do

### Actions

#### `batch_update` — Batch update a Google Doc

Apply a list of Google Doc API requests to a document, all or none.

`POST /v1/documents/{documentId}:batchUpdate` · **unsafe to replay** — a retried durable run does it TWICE

| Input | Required | What it is |
|---|---|---|
| `documentId` | yes | From document_create's data.documentId, or the id in the document's own URL. |
| `requests` | yes | Google's Request objects, in order. Example: [{"replaceAllText":{"containsText":{"text":"{{name}}","matchCase":true},"replaceText":"Ada"}}]. |
| `requiredRevisionId` | no | Optional. The document's revisionId as you last read it. If the document has changed since, Google refuses the whole batch with a 400 instead of applying it to content you have not seen. |

#### `document_create` — Google Docs document

Create a blank Google Docs document.

`POST /v1/documents` · **unsafe to replay** — a retried durable run does it TWICE

| Input | Required | What it is |
|---|---|---|
| `title` | yes | The title of the new blank document. |

#### `text_insert` — Insert text into a Google Doc

Insert plain text at a position in an existing document's body.

`POST /v1/documents/{documentId}:batchUpdate` · **unsafe to replay** — a retried durable run does it TWICE

| Input | Required | What it is |
|---|---|---|
| `documentId` | yes | From document_create's data.documentId, or the id in the document's own URL. |
| `text` | yes | Inserted verbatim. A newline in it starts a new paragraph, carrying the style of whatever paragraph the insertion point sits in. |
| `index` | yes | A zero-based position in UTF-16 code units, but 0 itself is never valid -- Google's body content starts at index 1. 1 is the very beginning of a freshly created blank document. To append after existing content, read the document's own length first (not yet offered by this connector) and insert there instead. |

#### `text_replace` — Replace text in a Google Doc

Replace every occurrence of a string in a document.

`POST /v1/documents/{documentId}:batchUpdate` · **unsafe to replay** — a retried durable run does it TWICE

| Input | Required | What it is |
|---|---|---|
| `documentId` | yes | From document_create's data.documentId, or the id in the document's own URL. |
| `find` | yes | The exact text to find, e.g. {{name}}. Not a regular expression. |
| `replaceWith` | yes | Inserted in place of every match. Empty is refused: to delete text, use batch_update. |
| `matchCase` | no | Off matches case-insensitively, which is also what Google does when it is not sent. |
| `requiredRevisionId` | no | Optional. The document's revisionId as you last read it. If the document has changed since, Google refuses the whole batch with a 400 instead of applying it to content you have not seen. |

## Run it before you have credentials

Every operation ships a **faker**, whether or not Google Docs has a sandbox. Set a
node's mode to `fake` and it returns the shape Google Docs actually publishes — the
same field names, deterministically — so you can wire the downstream nodes before
touching an account, a key, or a network.

## This repository is generated

`provider/` is the source. Everything under `packages/` is emitted from it and
**must not be hand-edited** — CI regenerates and diffs on every push, and the
next protocol sync destroys anything it finds. See [`AGENTS.md`](AGENTS.md).

## Two namespaces, which do not match on purpose

The repo is `github.com/Fancy-Friends/google-docs`; the packages publish under
`particle-academy`. Nothing derives one from the other — the names come from
weaver's `friends.json` and nowhere else.

## Licence

MIT.
