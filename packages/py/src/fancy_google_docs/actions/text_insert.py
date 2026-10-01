# GENERATED FILE — do not edit.
#
# Emitted from provider/actions/text-insert.json by weaver's generator.
# A hand-edit here is destroyed by the next protocol sync, which is worse than
# being rejected, because it works until it silently does not. Fix
# provider/actions/text-insert.json (or weaver's template/) and regenerate:
#
# npm run provider -- google_docs

"""Insert plain text at a position in an existing document's body.

POST /v1/documents/{documentId}:batchUpdate —
https://developers.google.com/workspace/docs/api/reference/rest/v1/documents/batchUpdate

This describes the request. `call` resolves the connection, picks the
estate, and either calls Google Docs or calls the faker.
"""

from __future__ import annotations

from typing import Any
from urllib.parse import quote

from .._runtime import CallResult, ConnectorConfigError, Mode, call
from ..service import descriptor

OPERATION = "text_insert"
METHOD = "POST"
PATH = "/v1/documents/{documentId}:batchUpdate"
SIDE_EFFECTS = "unsafe-to-replay"


def body(config: dict[str, Any]) -> dict[str, Any]:
    """Build the JSON body for one call, failing loudly and specifically."""
    if config.get("documentId") is None or config.get("documentId") == "":
        raise ConnectorConfigError(
            "text_insert: \"documentId\" is required (Document ID)."
        )

    if config.get("text") is None or config.get("text") == "":
        raise ConnectorConfigError(
            "text_insert: \"text\" is required (Text)."
        )

    index = config.get("index")
    if index is not None and index != "":
        try:
            _n = float(index)
        except (TypeError, ValueError):
            _n = None
        if _n is None or _n != int(_n) or _n < 1:
            raise ConnectorConfigError(
                "text_insert: \"index\" must be a integer, got "
                f"{index!r}."
            )
    else:
        raise ConnectorConfigError(
            "text_insert: \"index\" is required (Insert at index)."
        )

    out: dict[str, Any] = {}
    _value = config.get("text")
    if _value is None or _value == "":
        raise ConnectorConfigError("text_insert: \"text\" is required.")

    out["requests.0.insertText.text"] = str(_value)
    _value = config.get("index")
    if _value is None or _value == "":
        raise ConnectorConfigError("text_insert: \"index\" is required.")

    out["requests.0.insertText.location.index"] = int(float(_value))

    return _nest_fields(out)



def path(config: dict[str, Any]) -> str:
    """The request path, with each config value URL-ENCODED into it.

    `PATH` above is the TEMPLATE, which is what the descriptor advertises;
    this is what a caller sends. A value interpolated raw changes WHICH URL is
    called — a range like `Sheet1!A:B`, or a sheet named `Q1/Q2` — and the
    provider answers 404 about the document rather than about the encoding.
    """
    return (
        "/v1/documents/"
        + quote(str(config.get("documentId") or ""), safe="")
        + ":batchUpdate"
    )

def text_insert(
    config: dict[str, Any],
    *,
    credentials: dict[str, str | None] | None = None,
    mode: Mode = "auto",
    connection_id: str | None = None,
    attempts: int = 3,
) -> CallResult:
    """Insert plain text at a position in an existing document's body."""
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



def _nest_fields(flat: dict[str, Any]) -> dict[str, Any]:
    """`{"properties.email": x}` -> `{"properties": {"email": x}}`.

    A dotted `as` means NESTING, and only a JSON body can nest -- in a form body
    that spelling already means a literal dotted key.
    """
    out: dict[str, Any] = {}

    for path, value in flat.items():
        parts = path.split(".")
        node = out

        for key in parts[:-1]:
            found = node.get(key)
            if not isinstance(found, dict):
                found = {}
                node[key] = found
            node = found

        node[parts[-1]] = value

    # The ROOT is always an object -- a JSON body's top level is never a list
    # -- so only its VALUES are converted. That also keeps the return type
    # honest: `_listify` returns Any, and returning it directly is a
    # no-any-return error under mypy --strict.
    return {key: _listify(value) for key, value in out.items()}


def _listify(node: Any) -> Any:
    """A mapping whose keys are 0, 1, 2 ... is an ARRAY, not an object.

    `dateRanges.0.startDate` has to become `[{...}]`. PHP produced the list by
    accident -- its integer-keyed arrays serialise as JSON arrays -- while
    TypeScript and Python produced `{"0": {...}}`, which the provider refuses
    as the wrong type. The parity suite is what caught the disagreement, and
    converting at the END keeps the walk above simple.
    """
    if not isinstance(node, dict):
        return node

    walked = {key: _listify(value) for key, value in node.items()}
    wanted = [str(index) for index in range(len(walked))]

    if walked and list(walked.keys()) == wanted:
        return [walked[key] for key in wanted]

    return walked