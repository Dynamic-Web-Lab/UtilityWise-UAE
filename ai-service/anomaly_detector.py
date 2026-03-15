"""
Simple anomaly detection: compare amount to a fixed threshold per provider.
Phase 2 can replace with ML model or call to historical averages.
"""
from typing import Any

# Placeholder thresholds (AED) per provider for demo; in production use user history.
DEFAULT_AVG = 400.0
THRESHOLD_PERCENT = 30.0


def check_anomaly(amount: float, provider: str) -> dict[str, Any]:
    """Return is_anomaly, message, threshold_percent."""
    avg = DEFAULT_AVG
    if amount <= 0:
        return {"is_anomaly": False, "message": "", "threshold_percent": None}
    percent = ((amount - avg) / avg) * 100
    is_anomaly = percent > THRESHOLD_PERCENT
    message = (
        f"Bill amount (AED {amount:.2f}) is {percent:.1f}% above reference for {provider}."
        if is_anomaly
        else ""
    )
    return {
        "is_anomaly": is_anomaly,
        "message": message,
        "threshold_percent": THRESHOLD_PERCENT,
    }
