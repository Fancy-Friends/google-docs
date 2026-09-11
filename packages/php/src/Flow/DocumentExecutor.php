<?php

declare(strict_types=1);

namespace ParticleAcademy\GoogleDocs\Flow;

use FancyFlow\Attributes\FlowNode;
use FancyFlow\Contracts\NodeExecutor;
use FancyFlow\Runtime\ExecutionContext;
use FancyFlow\Runtime\Port;
use FancyFlow\Runtime\RunEvent;
use ParticleAcademy\Connectors\ConnectorClient;
use ParticleAcademy\GoogleDocs\Actions\DocumentCreate;
use ParticleAcademy\GoogleDocs\GoogleDocs;

/*
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
 * Google Docs document, run on a fancy-flow-php host.
 *
 * The PHP twin of `googleDocsDocumentExecutor` in
 * @particle-academy/google-docs-js: the same request, built from the node's
 * config by the same `Actions\DocumentCreate` a host would call directly, and
 * the same value on `out` — the client's `{data, mode, connection}`.
 *
 * The client resolves the connection and the estate from the config. With
 * nothing configured that is FAKE, so a node dropped on a canvas runs against
 * the faker rather than Google Docs. To reach a real estate, pass a
 * `ConnectorClient` that knows the host's connections — or bind one in the
 * container, which resolves the constructor by type.
 */
#[FlowNode(
    name: '@particle-academy/google_docs_document',
    aliases: [
        'google_docs_document',
    ],
    category: 'io',
    label: 'Google Docs document',
    description: 'Create a blank Google Docs document.',
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
            'description' => 'The id of the created document.',
        ],
        [
            'path' => 'data.title',
            'type' => 'string',
            'description' => 'The title Google stored.',
        ],
    ],
)]
final class DocumentExecutor implements NodeExecutor
{
    public function __construct(private readonly ?ConnectorClient $client = null) {}

    public function execute(ExecutionContext $ctx): mixed
    {
        $config = $ctx->config();

        $result = ($this->client ?? new ConnectorClient)->call(
            GoogleDocs::descriptor(),
            DocumentCreate::OPERATION,
            $config,
            [
                'method' => DocumentCreate::METHOD,
                'path' => DocumentCreate::PATH,
                'json' => DocumentCreate::body($config),
            ],
            $ctx->input('in'),
        );

        $id = is_array($result->data) ? ($result->data['id'] ?? null) : null;
        $ctx->emit(RunEvent::log(
            'info',
            'google_docs document_create'.(is_scalar($id) ? ' '.$id : '').' ('.$result->mode->value.')',
            $ctx->node->id,
        ));

        return Port::only('out', $result->toArray());
    }
}
