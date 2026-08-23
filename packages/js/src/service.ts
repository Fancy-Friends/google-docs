/**
 * GENERATED FILE — do not edit.
 *
 * Emitted from provider/manifest.json by weaver's generator.
 * A hand-edit here is destroyed by the next protocol sync, which is worse than
 * being rejected, because it works until it silently does not. Fix
 * provider/manifest.json (or weaver's template/) and regenerate:
 *
 *     npm run provider -- google_docs
 */

/**
 * Google Docs, as one service descriptor shared by every Google Docs
 * operation.
 *
 * @particle-academy/fancy-connector-core carries what is true of ALL
 * connectors. This carries what is true of Google Docs: its base URL, its auth
 * scheme, its idempotency header, and its faker.
 *
 * ## The sandbox trap, written down where it is used
 *
 * Google has no sandbox for Docs. A test document is a real one in a real
 * Drive, so every create is real -- use the faker while developing and clean
 * up any live test documents.
 */

import type { ConnectorMode, PreparedRequest, ServiceDescriptor } from "@particle-academy/fancy-connector-core";

import { googleDocsFaker } from "./faker.js";

/**
 * The connector API version this package was GENERATED against.
 *
 * A literal, never imported. An imported constant lets an upgrade rewrite the
 * very claim it exists to detect, after which the copy agrees with itself
 * forever.
 */
export const CONNECTOR_API_VERSION = 1;

export const GOOGLE_DOCS_BASE_URLS = {
  "live": "https://docs.googleapis.com"
} as const;

/** Credential keys a remote call cannot proceed without. */
export const GOOGLE_DOCS_REQUIRES = [
  "accessToken",
  "refreshToken",
  "clientId",
  "clientSecret"
] as const;

/**
 * Apply Google Docs's auth scheme to an outgoing request.
 *
 *
 *
 * The mode is passed in because for some providers auth and estate are the
 * same decision expressed in the URL; here it is unused, and saying so is
 * cheaper than wondering later whether it was forgotten.
 */
export function googleDocsAuthorize(
  credentials: Record<string, string | undefined>,
  request: PreparedRequest,
  _mode: ConnectorMode,
): void {
  request.headers.Authorization = `Bearer ${credentials.accessToken ?? ""}`;
}

/** The Google Docs service, for the TypeScript runtime. */
export const GOOGLE_DOCS: ServiceDescriptor = {
  service: "google_docs",
  title: "Google Docs",
  sandbox: "none",
  baseUrls: { ...GOOGLE_DOCS_BASE_URLS },
  requires: [...GOOGLE_DOCS_REQUIRES],
  authorize: googleDocsAuthorize,
  faker: googleDocsFaker,
};
