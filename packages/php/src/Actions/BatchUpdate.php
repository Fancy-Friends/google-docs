<?php

declare(strict_types=1);

namespace ParticleAcademy\GoogleDocs\Actions;

use ParticleAcademy\GoogleDocs\GoogleDocs;
use ParticleAcademy\Connectors\ConnectorConfigException;

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
 * Apply a list of Google Doc API requests to a document, all or none.
 *
 * POST /v1/documents/{documentId}:batchUpdate —
 * https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/batchUpdate
 *
 * This describes the request. The connector client resolves the connection,
 * picks the estate, and either calls Google Docs or calls the faker.
 */
final class BatchUpdate
{
    public const OPERATION = 'batch_update';
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
            throw new ConnectorConfigException('batch_update: "documentId" is required (Document ID).');
        }

        $requests = $config['requests'] ?? null;
        if ($requests === null || $requests === '') {
            throw new ConnectorConfigException('batch_update: "requests" is required (Requests).');
        }
        if (is_string($requests) && $requests !== '') {
            try {
                json_decode($requests, false, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                throw new ConnectorConfigException(
                    'batch_update: "requests" must be JSON: '.$e->getMessage(),
                );
            }
        }

        $body = [];

        $value = $config['requests'] ?? null;
        if ($value !== null && $value !== '') {
            $body['requests'] = is_string($value) ? json_decode($value, false, 512, JSON_THROW_ON_ERROR) : $value;
        }

        $value = $config['requiredRevisionId'] ?? null;
        if ($value !== null && $value !== '') {
            $body['writeControl.requiredRevisionId'] = (string) $value;
        }

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
