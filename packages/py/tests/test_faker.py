# GENERATED FILE — do not edit.
#
# Emitted from provider/fixtures/ by weaver's generator.
# A hand-edit here is destroyed by the next protocol sync, which is worse than
# being rejected, because it works until it silently does not. Fix
# provider/fixtures/ (or weaver's template/) and regenerate:
#
# npm run provider -- google_docs

"""The golden fixtures — the SAME values the TypeScript and PHP packages
assert.

Bit-for-bit identical is the claim, and this is what checks it for Python.
Cross-runtime drift does not fail loudly on its own: it completes, down one
path, with no error.
"""

import pytest

from fancy_google_docs._fake import FakeValues, seed_for_call
from fancy_google_docs.faker import respond


def test_document_create_fakes_the_published_shape() -> None:
    config = {}
    fake = FakeValues(seed_for_call("google_docs", "document_create", config))

    faked = respond("document_create", {"config": config, "fake": fake})

    assert faked == {
        "documentId": "1Doc_fake_b97c96715de6",
        "title": "Untitled document",
    }


def test_an_operation_with_no_fixture_raises_rather_than_inventing_a_shape() -> None:
    fake = FakeValues(seed_for_call("google_docs", "no_such_operation", {}))

    with pytest.raises(ValueError, match="no fake response"):
        respond("no_such_operation", {"config": {}, "fake": fake})
