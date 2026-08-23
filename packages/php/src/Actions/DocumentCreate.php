<?php

declare(strict_types=1);

namespace ParticleAcademy\GoogleDocs\Actions;

use ParticleAcademy\GoogleDocs\GoogleDocs;
use ParticleAcademy\Connectors\ConnectorConfigException;

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
 * Create a blank Google Docs document.
 *
 * POST /v1/documents —
 * https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/create
 *
 * This describes the request. The connector client resolves the connection,
 * picks the estate, and either calls Google Docs or calls the faker.
 */
final class DocumentCreate
{
    public const OPERATION = 'document_create';
    public const METHOD = 'POST';
    public const PATH = '/v1/documents';
    public const SIDE_EFFECTS = 'unsafe-to-replay';

    /**
     * Build the JSON body for one call.
     *
     * Validation fails loudly and specifically here, rather than three frames
     * later as an "invalid request" from Google Docs.
     *
     * @param array<string,mixed> $config
     * @return array<string,scalar>
     */
    public static function body(array $config): array
    {
        if (($config['title'] ?? null) === null || ($config['title'] ?? null) === '') {
            throw new ConnectorConfigException('document_create: "title" is required (Title).');
        }

        $body = [];

        $value = $config['title'] ?? null;
        $body['title'] = (string) $value;

        return $body;
    }
}
