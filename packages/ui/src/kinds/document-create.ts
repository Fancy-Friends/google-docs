/**
 * GENERATED FILE — do not edit.
 *
 * Emitted from provider/actions/document-create.json by weaver's generator.
 * A hand-edit here is destroyed by the next protocol sync, which is worse than
 * being rejected, because it works until it silently does not. Fix
 * provider/actions/document-create.json (or weaver's template/) and regenerate:
 *
 *     npm run provider -- google_docs
 */

/**
 * Google Docs document — Create a blank Google Docs document.
 *
 * https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/create
 *
 * `unsafe-to-replay`.
 */

import type { NodeKindDefinition } from "@particle-academy/fancy-flow/engine";
import { defineConnectorKind, summarize, type OutputField } from "@particle-academy/fancy-flow/connectors";
import { googleDocsMeta } from "../service.js";

export const GOOGLE_DOCS_DOCUMENT_KIND = "@particle-academy/google_docs_document";
export const GOOGLE_DOCS_DOCUMENT_OPERATION = "document_create";

export const GOOGLE_DOCS_DOCUMENT_META = googleDocsMeta("action", "create a blank document", "https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/create");

/**
 * What this node emits — the "ingredients" a downstream node can reference.
 *
 * fancy-flow reads `outputShape` off the kind and offers it in the variable
 * picker, so declaring it is the whole of the work: an author configuring the
 * next node picks `{{ $json.data.id }}` off a list instead of typing a path
 * and hoping.
 */
export const GOOGLE_DOCS_DOCUMENT_OUTPUT: OutputField[] = [
  {
    "path": "data.documentId",
    "type": "string",
    "description": "The id of the created document."
  },
  {
    "path": "data.title",
    "type": "string",
    "description": "The title Google stored."
  }
];

export const googleDocsDocumentKind: NodeKindDefinition = defineConnectorKind(GOOGLE_DOCS_DOCUMENT_META, {
  name: GOOGLE_DOCS_DOCUMENT_KIND,
  aliases: ["google_docs_document"],
  label: "Google Docs document",
  description: "Create a blank Google Docs document.",
  inputs: [{ id: "in" }],
  outputs: [{ id: "out" }],
  sideEffects: "unsafe-to-replay",
  outputShape: GOOGLE_DOCS_DOCUMENT_OUTPUT,
  configSchema: [
    {
      "type": "text",
      "key": "title",
      "label": "Title",
      "required": true,
      "description": "The title of the new blank document."
    }
  ],
  defaultConfig: {
    "mode": "auto"
  },
  renderBody: ({ config }) =>
    summarize(GOOGLE_DOCS_DOCUMENT_META, config as Record<string, unknown>, "create a blank document"),
});
