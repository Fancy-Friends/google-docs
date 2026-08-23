# GENERATED FILE — do not edit.
#
# Emitted from provider/actions/document-create.json by weaver's generator.
# A hand-edit here is destroyed by the next protocol sync, which is worse than
# being rejected, because it works until it silently does not. Fix
# provider/actions/document-create.json (or weaver's template/) and
# regenerate:
#
# npm run provider -- google_docs

"""Create a blank Google Docs document.

POST /v1/documents —
https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/create

This describes the request. `call` resolves the connection, picks the
estate, and either calls Google Docs or calls the faker.
"""

from __future__ import annotations

from typing import Any

from .._runtime import CallResult, ConnectorConfigError, Mode, call
from ..service import descriptor

OPERATION = "document_create"
METHOD = "POST"
PATH = "/v1/documents"
SIDE_EFFECTS = "unsafe-to-replay"


def body(config: dict[str, Any]) -> dict[str, Any]:
    """Build the JSON body for one call, failing loudly and specifically."""
    if config.get("title") is None or config.get("title") == "":
        raise ConnectorConfigError(
            "document_create: \"title\" is required (Title)."
        )

    out: dict[str, Any] = {}
    _value = config.get("title")
    if _value is None or _value == "":
        raise ConnectorConfigError("document_create: \"title\" is required.")

    out["title"] = str(_value)

    return out


def document_create(
    config: dict[str, Any],
    *,
    credentials: dict[str, str | None] | None = None,
    mode: Mode = "auto",
    connection_id: str | None = None,
    attempts: int = 3,
) -> CallResult:
    """Create a blank Google Docs document."""
    return call(
        descriptor(),
        operation=OPERATION,
        method=METHOD,
        path=PATH,
        json_body=body(config),
        config=config,
        credentials=credentials,
        mode=mode,
        connection_id=connection_id,
        attempts=attempts,
    )
