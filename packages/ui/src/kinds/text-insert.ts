/**
 * GENERATED FILE — do not edit.
 *
 * Emitted from provider/actions/text-insert.json by weaver's generator.
 * A hand-edit here is destroyed by the next protocol sync, which is worse than
 * being rejected, because it works until it silently does not. Fix
 * provider/actions/text-insert.json (or weaver's template/) and regenerate:
 *
 *     npm run provider -- google_docs
 */

/**
 * Insert text into a Google Doc — Insert plain text at a position in an
 * existing document's body.
 *
 * https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/batchUpdate
 *
 * `unsafe-to-replay`.
 */

import type { NodeKindDefinition } from "@particle-academy/fancy-flow/engine";
import { defineConnectorKind, summarize, type OutputField } from "@particle-academy/fancy-flow/connectors";
import { googleDocsMeta } from "../service.js";

export const GOOGLE_DOCS_TEXT_INSERT_KIND = "@particle-academy/google_docs_text_insert";
export const GOOGLE_DOCS_TEXT_INSERT_OPERATION = "text_insert";

export const GOOGLE_DOCS_TEXT_INSERT_META = googleDocsMeta("action", "insert text", "https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/batchUpdate");

/**
 * What this node emits — the "ingredients" a downstream node can reference.
 *
 * fancy-flow reads `outputShape` off the kind and offers it in the variable
 * picker, so declaring it is the whole of the work: an author configuring the
 * next node picks `{{ $json.data.id }}` off a list instead of typing a path
 * and hoping.
 */
export const GOOGLE_DOCS_TEXT_INSERT_OUTPUT: OutputField[] = [
  {
    "path": "data.documentId",
    "type": "string",
    "description": "Echoes what was sent."
  },
  {
    "path": "data.replies",
    "type": "array",
    "description": "One entry per request sent -- one here. insertText's own reply carries nothing; the array is present and empty-shaped rather than a usable result."
  },
  {
    "path": "mode",
    "type": "string",
    "description": "Which estate this ran against. Google has no sandbox, so: fake or live."
  }
];

export const googleDocsTextInsertKind: NodeKindDefinition = defineConnectorKind(GOOGLE_DOCS_TEXT_INSERT_META, {
  name: GOOGLE_DOCS_TEXT_INSERT_KIND,
  aliases: ["google_docs_text_insert"],
  label: "Insert text into a Google Doc",
  description: "Insert plain text at a position in an existing document's body.",
  inputs: [{ id: "in" }],
  outputs: [{ id: "out" }],
  sideEffects: "unsafe-to-replay",
  outputShape: GOOGLE_DOCS_TEXT_INSERT_OUTPUT,
  configSchema: [
    {
      "type": "text",
      "key": "documentId",
      "label": "Document ID",
      "required": true,
      "description": "From document_create's data.documentId, or the id in the document's own URL."
    },
    {
      "type": "textarea",
      "key": "text",
      "label": "Text",
      "required": true,
      "description": "Inserted verbatim. A newline in it starts a new paragraph, carrying the style of whatever paragraph the insertion point sits in."
    },
    {
      "type": "number",
      "key": "index",
      "label": "Insert at index",
      "required": true,
      "default": 1,
      "min": 1,
      "description": "A zero-based position in UTF-16 code units, but 0 itself is never valid -- Google's body content starts at index 1. 1 is the very beginning of a freshly created blank document. To append after existing content, read the document's own length first (not yet offered by this connector) and insert there instead."
    }
  ],
  defaultConfig: {
    "mode": "auto"
  },
  renderBody: ({ config }) =>
    summarize(GOOGLE_DOCS_TEXT_INSERT_META, config as Record<string, unknown>, "insert text"),
});
