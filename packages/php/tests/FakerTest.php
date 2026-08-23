<?php

declare(strict_types=1);

use ParticleAcademy\GoogleDocs\GoogleDocsFaker;
use ParticleAcademy\Connectors\FakeValues;

/*
 * GENERATED FILE — do not edit.
 *
 * Emitted from provider/fixtures/ by weaver's generator.
 * A hand-edit here is destroyed by the next protocol sync, which is worse than
 * being rejected, because it works until it silently does not. Fix
 * provider/fixtures/ (or weaver's template/) and regenerate:
 *
 *     npm run provider -- google_docs
 */
/**
 * The golden fixtures — the SAME values the TypeScript and Python packages
 * assert.
 *
 * Bit-for-bit identical is the claim, and this is what checks it.
 * Cross-runtime drift does not fail loudly on its own: it completes, down one
 * path, with no error.
 */

it('document_create fakes the shape Google Docs publishes', function () {
    $config = [];
    $fake = new FakeValues(FakeValues::seedForCall('google_docs', 'document_create', $config));

    $faked = GoogleDocsFaker::respond('document_create', ['config' => $config, 'fake' => $fake]);

    expect($faked)->toBe([
        'documentId' => '1Doc_fake_b97c96715de6',
        'title' => 'Untitled document',
    ]);
});

it('throws for an operation with no fixture rather than inventing a shape', function () {
    $fake = new FakeValues(FakeValues::seedForCall('google_docs', 'no_such_operation', []));

    expect(fn () => GoogleDocsFaker::respond('no_such_operation', ['config' => [], 'fake' => $fake]))
        ->toThrow(InvalidArgumentException::class);
});
