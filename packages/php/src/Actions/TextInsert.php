<?php

declare(strict_types=1);

namespace ParticleAcademy\GoogleDocs\Actions;

use ParticleAcademy\GoogleDocs\GoogleDocs;
use ParticleAcademy\Connectors\ConnectorConfigException;

/*
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
 * Insert plain text at a position in an existing document's body.
 *
 * POST /v1/documents/{documentId}:batchUpdate —
 * https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/batchUpdate
 *
 * This describes the request. The connector client resolves the connection,
 * picks the estate, and either calls Google Docs or calls the faker.
 */
final class TextInsert
{
    public const OPERATION = 'text_insert';
    public const METHOD = 'POST';
    public const PATH = '/v1/documents/{documentId}:batchUpdate';
    public const SIDE_EFFECTS = 'unsafe-to-replay';

    /**
     * Build the JSON body for one call.
     *
     * Validation fails loudly and specifically here, rather than three frames
     * later as an "invalid request" from Google Docs.
     *
     * @param array<string,mixed> $config
     * An EMPTY body is `{}`, not `[]` — and PHP cannot tell those apart, because
     * both are `array()` and `json_encode` picks the list. So an empty one is
     * returned as an object. TypeScript and Python have no such ambiguity, which
     * is why this is a difference only the byte-parity suite can see.
     *
     * @return array<string,mixed>|\stdClass
     */
    public static function body(array $config): array|\stdClass
    {
        if (($config['documentId'] ?? null) === null || ($config['documentId'] ?? null) === '') {
            throw new ConnectorConfigException('text_insert: "documentId" is required (Document ID).');
        }

        if (($config['text'] ?? null) === null || ($config['text'] ?? null) === '') {
            throw new ConnectorConfigException('text_insert: "text" is required (Text).');
        }

        $index = $config['index'] ?? null;
        if (! (is_numeric($index) && (float) $index === floor((float) $index) && (float) $index >= 1)) {
            throw new ConnectorConfigException(
                'text_insert: "index" must be a integer, got '.json_encode($index).'.'
            );
        }

        $body = [];

        $value = $config['text'] ?? null;
        $body['requests.0.insertText.text'] = (string) $value;

        $value = $config['index'] ?? null;
        $body['requests.0.insertText.location.index'] = (int) $value;

        $body = self::nestFields($body);
        $body = $body === [] ? new \stdClass() : $body;
        return $body;
    }

    /**
     * The request path, with each config value URL-ENCODED into it.
     *
     * `PATH` above is the TEMPLATE, which is what the descriptor advertises;
     * this is what a caller sends. A value interpolated raw changes which URL
     * is called — a range like `Sheet1!A:B` or a sheet named `Q1/Q2` — and the
     * provider answers 404 about the document rather than about the encoding.
     *
     * @param array<string,mixed> $config
     */
    public static function path(array $config): string
    {
        return '/v1/documents/'.rawurlencode((string) ($config['documentId'] ?? '')).':batchUpdate';
    }

    /**
     * `['properties.email' => x]` -> `['properties' => ['email' => x]]`.
     *
     * A dotted `as` means NESTING, and only a JSON body can nest — in a form
     * body that spelling already means a literal dotted key.
     *
     * @param  array<string,mixed>  $flat
     * @return array<string,mixed>
     */
    private static function nestFields(array $flat): array
    {
        $out = [];

        foreach ($flat as $path => $value) {
            $parts = explode('.', (string) $path);
            $node = &$out;

            while (count($parts) > 1) {
                $key = array_shift($parts);

                if (! isset($node[$key]) || ! is_array($node[$key])) {
                    $node[$key] = [];
                }

                $node = &$node[$key];
            }

            $node[$parts[0]] = $value;
            unset($node);
        }

        return $out;
    }
}
