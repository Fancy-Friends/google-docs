/**
 * GENERATED FILE — do not edit.
 *
 * Emitted from provider/actions/batch-update.json by weaver's generator.
 * A hand-edit here is destroyed by the next protocol sync, which is worse than
 * being rejected, because it works until it silently does not. Fix
 * provider/actions/batch-update.json (or weaver's template/) and regenerate:
 *
 *     npm run provider -- google_docs
 */

/**
 * Apply a list of Google Doc API requests to a document, all or none.
 *
 * POST /v1/documents/{documentId}:batchUpdate —
 * https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/batchUpdate
 *
 * Notice what is NOT here: no key, no base URL, no mode check, no retry loop,
 * no fake/real branch. This describes the request; callConnector resolves the
 * connection, picks the estate, and either calls Google Docs or calls the
 * faker.
 *
 * sideEffects: unsafe-to-replay.
 */

import {
  callConnector,
  type ConnectorResult,
  type RequestedMode,
  type Transport,
} from "@particle-academy/fancy-connector-core";
import { GOOGLE_DOCS } from "../service.js";

export const BATCH_UPDATE_OPERATION = "batch_update";

export type BatchUpdateOptions = {
  /** The node's resolved config. Keys: documentId, requests, requiredRevisionId. */
  config: Record<string, unknown>;
  credentials?: Record<string, string | undefined>;
  mode?: RequestedMode;
  connectionId?: string | null;
  input?: unknown;
  attempts?: number;
  /** Override the transport. The only way to exercise this without a network. */
  transport?: Transport;
};

export async function googleDocsBatchUpdate(options: BatchUpdateOptions): Promise<ConnectorResult> {
  const config = options.config ?? {};

  if (config.documentId === undefined || config.documentId === null || config.documentId === "") {
    throw new Error(`batch_update: "documentId" is required (Document ID).`);
  }

  if (config.requests === undefined || config.requests === null || config.requests === "") {
    throw new Error(`batch_update: "requests" is required (Requests).`);
  }
  if (typeof config.requests === "string" && config.requests !== "") {
    try {
      JSON.parse(config.requests);
    } catch (error) {
      throw new Error(`batch_update: "requests" must be JSON: ${(error as Error).message}`);
    }
  }

  return callConnector(GOOGLE_DOCS, {
    operation: BATCH_UPDATE_OPERATION,
    config,
    input: options.input,
    ...(options.credentials === undefined ? {} : { credentials: options.credentials }),
    ...(options.mode === undefined ? {} : { mode: options.mode }),
    ...(options.connectionId === undefined ? {} : { connectionId: options.connectionId }),
    ...(options.attempts === undefined ? {} : { attempts: options.attempts }),
    ...(options.transport === undefined ? {} : { transport: options.transport }),
    request: {
      method: "POST",
      path: `/v1/documents/${encodeURIComponent(String(config.documentId))}:batchUpdate`,
      json: nestFields({
        ...(config.requests !== undefined && config.requests !== null && config.requests !== "" ? { "requests": typeof config.requests === "string" ? JSON.parse(config.requests) : config.requests } : {}),
        ...(config.requiredRevisionId !== undefined && config.requiredRevisionId !== null && config.requiredRevisionId !== "" ? { "writeControl.requiredRevisionId": String(config.requiredRevisionId) } : {}),
      }),
    },
  });
}

/**
 * `{"properties.email": x}` -> `{properties: {email: x}}`.
 *
 * A dotted `as` means NESTING, and only a JSON body can nest. The validator
 * refuses that spelling anywhere else, because in a form body it already means
 * something different — a literal dotted key.
 */
function nestFields(flat: Record<string, unknown>): Record<string, unknown> {
  const out: Record<string, unknown> = {};

  for (const [path, value] of Object.entries(flat)) {
    const parts = path.split(".");
    let node = out;

    while (parts.length > 1) {
      const key = parts.shift() as string;
      // A NUMERIC segment is an array index: `dateRanges.0.startDate` has to
      // become `[{startDate}]`, not `{"0": {startDate}}`. PHP produced the
      // array by accident (its integer-keyed arrays serialise as JSON lists)
      // and the other two produced an object, which the provider rejects as
      // the wrong type. The parity suite is what caught the disagreement.
      const wantsArray = /^\d+$/.test(parts[0] ?? "");

      if (typeof node[key] !== "object" || node[key] === null) node[key] = wantsArray ? [] : {};
      node = node[key] as Record<string, unknown>;
    }

    node[parts[0] as string] = value;
  }

  return out;
}
