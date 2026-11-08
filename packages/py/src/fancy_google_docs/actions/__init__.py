# GENERATED FILE — do not edit.
#
# Emitted from provider/actions/ by weaver's generator.
# A hand-edit here is destroyed by the next protocol sync, which is worse than
# being rejected, because it works until it silently does not. Fix
# provider/actions/ (or weaver's template/) and regenerate:
#
# npm run provider -- google_docs

from .batch_update import batch_update
from .document_create import document_create
from .text_insert import text_insert
from .text_replace import text_replace

__all__ = [
    "batch_update",
    "document_create",
    "text_insert",
    "text_replace",
]
