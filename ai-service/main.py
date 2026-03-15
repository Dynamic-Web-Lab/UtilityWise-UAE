"""
UtilityWise UAE — AI service (OCR + anomaly detection).
Phase 1: /extract (bill OCR), /anomaly (optional).
"""
from fastapi import FastAPI, File, Form, UploadFile, HTTPException
from pydantic import BaseModel

from ocr_extractor import extract_bill_data
from anomaly_detector import check_anomaly
from forecast_model import forecast_next_bill
from leak_detector import check_water_spike

app = FastAPI(title="UtilityWise AI Service", version="0.2.0")


class AnomalyRequest(BaseModel):
    user_id: int
    bill_id: int
    amount: float
    provider: str


@app.get("/health")
def health():
    return {"status": "ok"}


@app.post("/extract")
async def extract(
    file: UploadFile = File(...),
    provider: str = Form(...),
):
    """Extract bill amount, date, consumption from PDF/image. Provider: dewa, fewa, addc, sewa, empower, tabreed, du, etisalat."""
    if not file.filename:
        raise HTTPException(400, "No file")
    content = await file.read()
    try:
        data = extract_bill_data(content, file.filename or "bill", provider)
        return data
    except Exception as e:
        raise HTTPException(422, str(e))


@app.post("/anomaly")
async def anomaly(req: AnomalyRequest):
    """Check if bill amount is anomalous (Phase 1: simple threshold)."""
    result = check_anomaly(req.amount, req.provider)
    return result


class ForecastRequest(BaseModel):
    amounts: list[float]
    provider: str | None = None


@app.post("/forecast")
async def forecast(req: ForecastRequest):
    """Phase 2: Predict next month bill from historical amounts (weighted avg)."""
    return forecast_next_bill(req.amounts, provider=req.provider)


class LeakCheckRequest(BaseModel):
    current_gallons: float
    previous_gallons: list[float]
    spike_factor: float = 1.5


@app.post("/leak-check")
async def leak_check(req: LeakCheckRequest):
    """Phase 2: Heuristic water spike detection (possible leak)."""
    return check_water_spike(req.current_gallons, req.previous_gallons, req.spike_factor)
