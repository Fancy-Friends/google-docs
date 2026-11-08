<?php

declare(strict_types=1);

namespace ParticleAcademy\GoogleDocs\Flow;

use FancyFlow\Attributes\FlowNode;
use FancyFlow\Contracts\NodeExecutor;
use FancyFlow\Runtime\ExecutionContext;
use FancyFlow\Runtime\Port;
use FancyFlow\Runtime\RunEvent;
use ParticleAcademy\Connectors\ConnectorClient;
use ParticleAcademy\GoogleDocs\Actions\TextReplace;
use ParticleAcademy\GoogleDocs\GoogleDocs;

/*
 * GENERATED FILE — do not edit.
 *
 * Emitted from provider/actions/text-replace.json by weaver's generator.
 * A hand-edit here is destroyed by the next protocol sync, which is worse than
 * being rejected, because it works until it silently does not. Fix
 * provider/actions/text-replace.json (or weaver's template/) and regenerate:
 *
 *     npm run provider -- google_docs
 */
/**
 * Replace text in a Google Doc, run on a fancy-flow-php host.
 *
 * The PHP twin of `googleDocsTextReplaceExecutor` in
 * @particle-academy/google-docs-js: the same request, built from the node's
 * config by the same `Actions\TextReplace` a host would call directly, and the
 * same value on `out` — the client's `{data, mode, connection}`.
 *
 * The client resolves the connection and the estate from the config. With
 * nothing configured that is FAKE, so a node dropped on a canvas runs against
 * the faker rather than Google Docs. To reach a real estate, pass a
 * `ConnectorClient` that knows the host's connections — or bind one in the
 * container, which resolves the constructor by type.
 */
#[FlowNode(
    name: '@particle-academy/google_docs_text_replace',
    aliases: [
        'google_docs_text_replace',
    ],
    category: 'io',
    label: 'Replace text in a Google Doc',
    description: 'Replace every occurrence of a string in a document.',
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
            'description' => 'One reply.',
        ],
        [
            'path' => 'data.replies.0.replaceAllText.occurrencesChanged',
            'type' => 'number',
            'description' => 'How many occurrences were replaced. 0 means the text was not found, which is not an error.',
        ],
        [
            'path' => 'data.writeControl.requiredRevisionId',
            'type' => 'string',
            'description' => 'The document\'s revision after the update.',
        ],
        [
            'path' => 'mode',
            'type' => 'string',
            'description' => 'Which estate this ran against. Google has no sandbox, so: fake or live.',
        ],
    ],
)]
final class TextReplaceExecutor implements NodeExecutor
{
    public function __construct(private readonly ?ConnectorClient $client = null) {}

    public function execute(ExecutionContext $ctx): mixed
    {
        $config = $ctx->config();

        $result = ($this->client ?? new ConnectorClient)->call(
            GoogleDocs::descriptor(),
            TextReplace::OPERATION,
            $config,
            [
                'method' => TextReplace::METHOD,
                'path' => TextReplace::path($config),
                'json' => TextReplace::body($config),
            ],
            $ctx->input('in'),
        );

        $id = is_array($result->data) ? ($result->data['id'] ?? null) : null;
        $ctx->emit(RunEvent::log(
            'info',
            'google_docs text_replace'.(is_scalar($id) ? ' '.$id : '').' ('.$result->mode->value.')',
            $ctx->node->id,
        ));

        return Port::only('out', $result->toArray());
    }
}
