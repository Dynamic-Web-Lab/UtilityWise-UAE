"""
Extract bill data from PDF or image using OCR.
Supports: DEWA, FEWA, ADDC, SEWA, Empower, Tabreed, Du, Etisalat.
"""
import io
import re
from typing import Any

try:
    import pytesseract
    from PIL import Image
except ImportError:
    pytesseract = None
    Image = None

try:
    from pdf2image import convert_from_bytes
except ImportError:
    convert_from_bytes = None


def extract_bill_data(content: bytes, filename: str, provider: str) -> dict[str, Any]:
    """Return dict with amount, bill_date, consumption_kwh, consumption_gallons."""
    text = _content_to_text(content, filename)
    return _parse_by_provider(text, provider)


def _content_to_text(content: bytes, filename: str) -> str:
    if not pytesseract or not Image:
        return _mock_extract(content, filename)
    lower = (filename or "").lower()
    if lower.endswith(".pdf"):
        if convert_from_bytes:
            images = convert_from_bytes(content, first_page=1, last_page=2)
            text = " ".join(pytesseract.image_to_string(img) for img in images)
        else:
            text = _mock_extract(content, filename)
    else:
        img = Image.open(io.BytesIO(content))
        text = pytesseract.image_to_string(img)
    return text or ""


def _mock_extract(content: bytes, filename: str) -> str:
    """Fallback when OCR deps missing: return placeholder for dev."""
    return "Amount 150.00 AED Date 2025-01-15 Consumption 450 kWh"


def _parse_by_provider(text: str, provider: str) -> dict[str, Any]:
    """Parse text for common UAE bill fields."""
    amount = _extract_amount(text)
    bill_date = _extract_date(text)
    kwh = _extract_kwh(text)
    gallons = _extract_gallons(text)
    return {
        "amount": amount,
        "bill_date": bill_date,
        "consumption_kwh": kwh,
        "consumption_gallons": gallons,
        "provider": provider,
    }


def _extract_amount(text: str) -> float:
    # AED 123.45 or Amount: 123.45
    for pattern in [r"AED\s*([\d,]+\.?\d*)", r"Amount[:\s]+([\d,]+\.?\d*)", r"([\d,]+\.?\d*)\s*AED"]:
        m = re.search(pattern, text, re.IGNORECASE)
        if m:
            return float(m.group(1).replace(",", ""))
    return 0.0


def _extract_date(text: str) -> str:
    # YYYY-MM-DD or DD/MM/YYYY
    for pattern in [r"(\d{4})-(\d{2})-(\d{2})", r"(\d{2})/(\d{2})/(\d{4})", r"(\d{2})-(\d{2})-(\d{4})"]:
        m = re.search(pattern, text)
        if m:
            g = m.groups()
            if len(g[0]) == 4:  # year first
                return f"{g[0]}-{g[1]}-{g[2]}"
            return f"{g[2]}-{g[1]}-{g[0]}"
    from datetime import date
    return date.today().isoformat()


def _extract_kwh(text: str) -> float | None:
    m = re.search(r"(\d+(?:,\d+)*(?:\.\d+)?)\s*kWh", text, re.IGNORECASE)
    if m:
        return float(m.group(1).replace(",", ""))
    m = re.search(r"consumption[:\s]+(\d+(?:\.\d+)?)", text, re.IGNORECASE)
    if m:
        return float(m.group(1))
    return None


def _extract_gallons(text: str) -> float | None:
    m = re.search(r"(\d+(?:,\d+)*(?:\.\d+)?)\s*gallons?", text, re.IGNORECASE)
    if m:
        return float(m.group(1).replace(",", ""))
    return None
