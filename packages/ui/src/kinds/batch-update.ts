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
 * Batch update a Google Doc — Apply a list of Google Doc API requests to a
 * document, all or none.
 *
 * https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/batchUpdate
 *
 * `unsafe-to-replay`.
 */

import type { NodeKindDefinition } from "@particle-academy/fancy-flow/engine";
import { defineConnectorKind, summarize, type OutputField } from "@particle-academy/fancy-flow/connectors";
import { googleDocsMeta } from "../service.js";

export const GOOGLE_DOCS_BATCH_UPDATE_KIND = "@particle-academy/google_docs_batch_update";
export const GOOGLE_DOCS_BATCH_UPDATE_OPERATION = "batch_update";

export const GOOGLE_DOCS_BATCH_UPDATE_META = googleDocsMeta("action", "batch update a document", "https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/batchUpdate");

/**
 * What this node emits — the "ingredients" a downstream node can reference.
 *
 * fancy-flow reads `outputShape` off the kind and offers it in the variable
 * picker, so declaring it is the whole of the work: an author configuring the
 * next node picks `{{ $json.data.id }}` off a list instead of typing a path
 * and hoping.
 */
export const GOOGLE_DOCS_BATCH_UPDATE_OUTPUT: OutputField[] = [
  {
    "path": "data.documentId",
    "type": "string",
    "description": "The document updated."
  },
  {
    "path": "data.replies",
    "type": "array",
    "description": "One reply per request, in order. Many kinds reply with an empty object."
  },
  {
    "path": "data.writeControl.requiredRevisionId",
    "type": "string",
    "description": "The document's revision after the update; pass it to the next batch to guard it."
  },
  {
    "path": "mode",
    "type": "string",
    "description": "Which estate this ran against. Google has no sandbox, so: fake or live."
  }
];

export const googleDocsBatchUpdateKind: NodeKindDefinition = defineConnectorKind(GOOGLE_DOCS_BATCH_UPDATE_META, {
  name: GOOGLE_DOCS_BATCH_UPDATE_KIND,
  aliases: ["google_docs_batch_update"],
  label: "Batch update a Google Doc",
  description: "Apply a list of Google Doc API requests to a document, all or none.",
  inputs: [{ id: "in" }],
  outputs: [{ id: "out" }],
  sideEffects: "unsafe-to-replay",
  outputShape: GOOGLE_DOCS_BATCH_UPDATE_OUTPUT,
  configSchema: [
    {
      "type": "text",
      "key": "documentId",
      "label": "Document ID",
      "required": true,
      "description": "From document_create's data.documentId, or the id in the document's own URL."
    },
    {
      "type": "json",
      "key": "requests",
      "label": "Requests",
      "required": true,
      "description": "Google's Request objects, in order. Example: [{\"replaceAllText\":{\"containsText\":{\"text\":\"{{name}}\",\"matchCase\":true},\"replaceText\":\"Ada\"}}]."
    },
    {
      "type": "text",
      "key": "requiredRevisionId",
      "label": "Required revision ID",
      "description": "Optional. The document's revisionId as you last read it. If the document has changed since, Google refuses the whole batch with a 400 instead of applying it to content you have not seen."
    }
  ],
  defaultConfig: {
    "mode": "auto"
  },
  renderBody: ({ config }) =>
    summarize(GOOGLE_DOCS_BATCH_UPDATE_META, config as Record<string, unknown>, "batch update a document"),
});
