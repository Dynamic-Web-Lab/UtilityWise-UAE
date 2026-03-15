"""
Placeholder for Phase 2: bill forecasting (ML model).
"""
from typing import Any


def forecast_next_bill(historical_amounts: list[float], **kwargs: Any) -> dict[str, Any]:
    """Predict next month bill. Phase 2: use proper ML + optional weather."""
    if not historical_amounts:
        return {"amount": 0.0, "confidence": 0.0}
    avg = sum(historical_amounts) / len(historical_amounts)
    return {"amount": round(avg, 2), "confidence": 0.5}
