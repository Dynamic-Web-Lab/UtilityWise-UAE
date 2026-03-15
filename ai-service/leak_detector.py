"""
Phase 2: Leak detection — heuristic water consumption spike.
No cloud required; runs on historical gallons.
"""
from typing import Any


# Typical threshold: if current month gallons > avg of previous months by this factor, flag possible leak
SPIKE_FACTOR = 1.5  # 50% above average


def check_water_spike(
    current_gallons: float,
    previous_gallons: list[float],
    spike_factor: float = SPIKE_FACTOR,
) -> dict[str, Any]:
    """
    Check if current water consumption suggests a possible leak.
    Returns is_leak, message, current_avg_ratio.
    """
    if current_gallons <= 0 or not previous_gallons:
        return {"is_leak": False, "message": "", "current_avg_ratio": 0.0}

    avg_previous = sum(previous_gallons) / len(previous_gallons)
    if avg_previous <= 0:
        return {"is_leak": False, "message": "", "current_avg_ratio": 0.0}

    ratio = current_gallons / avg_previous
    is_leak = ratio >= spike_factor
    message = (
        f"Water consumption ({current_gallons:.0f} gal) is {ratio:.1f}x your recent average ({avg_previous:.0f} gal). Consider checking for leaks."
        if is_leak
        else ""
    )
    return {
        "is_leak": is_leak,
        "message": message,
        "current_avg_ratio": round(ratio, 2),
        "average_previous": round(avg_previous, 2),
    }
