<?php

declare(strict_types=1);

namespace ParticleAcademy\GoogleDocs\Flow;

use FancyFlow\Attributes\FlowNode;
use FancyFlow\Contracts\NodeExecutor;
use FancyFlow\Runtime\ExecutionContext;
use FancyFlow\Runtime\Port;
use FancyFlow\Runtime\RunEvent;
use ParticleAcademy\Connectors\ConnectorClient;
use ParticleAcademy\GoogleDocs\Actions\BatchUpdate;
use ParticleAcademy\GoogleDocs\GoogleDocs;

/*
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
 * Batch update a Google Doc, run on a fancy-flow-php host.
 *
 * The PHP twin of `googleDocsBatchUpdateExecutor` in
 * @particle-academy/google-docs-js: the same request, built from the node's
 * config by the same `Actions\BatchUpdate` a host would call directly, and the
 * same value on `out` — the client's `{data, mode, connection}`.
 *
 * The client resolves the connection and the estate from the config. With
 * nothing configured that is FAKE, so a node dropped on a canvas runs against
 * the faker rather than Google Docs. To reach a real estate, pass a
 * `ConnectorClient` that knows the host's connections — or bind one in the
 * container, which resolves the constructor by type.
 */
#[FlowNode(
    name: '@particle-academy/google_docs_batch_update',
    aliases: [
        'google_docs_batch_update',
    ],
    category: 'io',
    label: 'Batch update a Google Doc',
    description: 'Apply a list of Google Doc API requests to a document, all or none.',
    inputs: [
        [
            'id' => 'in',
        ],
    ],
    outputs: [
        [
            'id' => 'out',
        ],
    ],
    sideEffects: 'unsafe-to-replay',
    outputShape: [
        [
            'path' => 'data.documentId',
            'type' => 'string',
            'description' => 'The document updated.',
        ],
        [
            'path' => 'data.replies',
            'type' => 'array',
            'description' => 'One reply per request, in order. Many kinds reply with an empty object.',
        ],
        [
            'path' => 'data.writeControl.requiredRevisionId',
            'type' => 'string',
            'description' => 'The document\'s revision after the update; pass it to the next batch to guard it.',
        ],
        [
            'path' => 'mode',
            'type' => 'string',
            'description' => 'Which estate this ran against. Google has no sandbox, so: fake or live.',
        ],
    ],
)]
final class BatchUpdateExecutor implements NodeExecutor
{
    public function __construct(private readonly ?ConnectorClient $client = null) {}

    public function execute(ExecutionContext $ctx): mixed
    {
        $config = $ctx->config();

        $result = ($this->client ?? new ConnectorClient)->call(
            GoogleDocs::descriptor(),
            BatchUpdate::OPERATION,
            $config,
            [
                'method' => BatchUpdate::METHOD,
                'path' => BatchUpdate::path($config),
                'json' => BatchUpdate::body($config),
            ],
            $ctx->input('in'),
        );

        $id = is_array($result->data) ? ($result->data['id'] ?? null) : null;
        $ctx->emit(RunEvent::log(
            'info',
            'google_docs batch_update'.(is_scalar($id) ? ' '.$id : '').' ('.$result->mode->value.')',
            $ctx->node->id,
        ));

        return Port::only('out', $result->toArray());
    }
}
