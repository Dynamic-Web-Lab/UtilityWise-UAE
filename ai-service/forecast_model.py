"""
Phase 2: Bill forecasting — weighted moving average.
Runs on user's machine / self-hosted; no cloud required.
"""
from typing import Any


def forecast_next_bill(
    historical_amounts: list[float],
    provider: str | None = None,
    **kwargs: Any,
) -> dict[str, Any]:
    """Predict next month bill from historical amounts."""
    if not historical_amounts:
        return {"amount": 0.0, "confidence": 0.0, "method": "none"}

    n = len(historical_amounts)
    if n <= 3:
        amount = sum(historical_amounts) / n
        confidence = 0.4 + 0.1 * n
    else:
        weights = [0.5 + 0.5 * (i / 3) for i in range(min(4, n))]
        weights = weights[:n]
        total_w = sum(weights)
        amount = sum(a * w for a, w in zip(historical_amounts[-len(weights):], weights)) / total_w
        confidence = min(0.85, 0.5 + 0.05 * n)

    return {
        "amount": round(float(amount), 2),
        "confidence": round(confidence, 2),
        "method": "weighted_avg",
        "sample_size": n,
    }
