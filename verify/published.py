"""
Google Docs — the published PyPI wheel.

GENERATED — do not edit. Fix weaver's template/ and regenerate.

Runs against the PUBLISHED wheel, installed by name into a fresh venv.
Every other test here imports from ../src and cannot see the packaging —
a missing py.typed or an unshipped module passes there and breaks for
every user.
"""

from importlib.metadata import requires

from fancy_google_docs._fake import FakeValues, seed_for_call
from fancy_google_docs.faker import respond

GOLDENS = [
    {
        "operation": "batch_update",
        "config": {},
        "expected": {
            "documentId": "1Doc_fake_b17d7d2cc5c6",
            "replies": [
                {},
            ],
            "writeControl": {
                "requiredRevisionId": "4358d3e77da7f1d5",
            },
        },
    },
    {
        "operation": "document_create",
        "config": {},
        "expected": {
            "documentId": "1Doc_fake_b97c96715de6",
            "title": "Untitled document",
        },
    },
    {
        "operation": "text_insert",
        "config": {},
        "expected": {
            "documentId": "1Doc_fake_2a078907bfc7",
            "replies": [
                {},
            ],
        },
    },
    {
        "operation": "text_replace",
        "config": {},
        "expected": {
            "documentId": "1Doc_fake_97719d3c3e1f",
            "replies": [
                {
                    "replaceAllText": {
                        "occurrencesChanged": 6,
                    },
                },
            ],
            "writeControl": {
                "requiredRevisionId": "3bb5512da3878545",
            },
        },
    },
]


def main() -> None:
    # Zero runtime dependencies is a design constraint, checked on the
    # INSTALLED distribution rather than on the pyproject that claimed it.
    declared = requires("fancy-google-docs")
    assert not declared, f"expected no runtime dependencies, got {declared}"
    print("  ok   zero runtime dependencies on the installed distribution")

    for golden in GOLDENS:
        operation, config = golden["operation"], golden["config"]
        fake = FakeValues(seed_for_call("google_docs", operation, config))
        faked = respond(operation, {"config": config, "fake": fake})

        assert faked == golden["expected"], (
            f"the PUBLISHED wheel produced different bytes for {operation} than the repo does"
        )
        print(f"  ok   {operation}")

    print(f"\n  {len(GOLDENS)} operations verified against the published wheel.")


if __name__ == "__main__":
    main()
