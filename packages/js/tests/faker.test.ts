/**
 * GENERATED FILE — do not edit.
 *
 * Emitted from provider/fixtures/ by weaver's generator.
 * A hand-edit here is destroyed by the next protocol sync, which is worse than
 * being rejected, because it works until it silently does not. Fix
 * provider/fixtures/ (or weaver's template/) and regenerate:
 *
 *     npm run provider -- google_docs
 */

/**
 * The golden fixtures.
 *
 * Deterministic on purpose: the same seed produces the same bytes in
 * TypeScript, PHP and Python, so this file and its twins in the other packages
 * assert the SAME values. That turns the faker into a parity test rather than
 * a convenience — which matters, because cross-runtime drift does not fail
 * loudly. It completes, down one path, with no error.
 */

import { test } from "node:test";
import assert from "node:assert/strict";
import { fakeRequest } from "@particle-academy/fancy-connector-core";

import { googleDocsFaker } from "../src/faker.js";

test("document_create fakes the shape Google Docs publishes", () => {
  const config = {};

  const faked = googleDocsFaker("document_create", fakeRequest("google_docs", "document_create", config));

  assert.deepEqual(faked, {
    "documentId": "1Doc_fake_b97c96715de6",
    "title": "Untitled document"
  });
});

test("an operation with no fixture throws rather than inventing a shape", () => {
  assert.throws(() => googleDocsFaker("no_such_operation", fakeRequest("google_docs", "no_such_operation", {})), /no fake response/);
});
