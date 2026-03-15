# 💡 UtilityWise UAE
### The Open-Source Utility Bill Analyzer & Cost Optimization Platform

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Laravel 11](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel)](https://laravel.com)
[![Python 3.10+](https://img.shields.io/badge/Python-3.10+-3776AB?logo=python)](https://www.python.org)
[![DynamicWebLab](https://img.shields.io/badge/Powered%20By-DynamicWebLab-0073e6)](https://dynamicweblab.com)

> **⚠️ Disclaimer:** This software is for personal tracking and analysis only. It is not affiliated with DEWA, FEWA, ADDC, or any UAE utility provider. Bill data is processed locally and never shared with third parties.
>
> This is a **public open-source repository**. See [CONTRIBUTING.md](CONTRIBUTING.md) and [SECURITY.md](SECURITY.md) for how to contribute or report security issues.

---

## 📖 Table of Contents

- [About](#about)
- [The Problem](#the-problem)
- [Features](#features)
- [Free vs Paid Modules](#free-vs-paid-modules)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Configuration](#configuration)
- [Security & Privacy](#security--privacy)
- [Contributing](#contributing)
- [License](#license)

---

## 📢 About

**UtilityWise UAE** is a privacy-first, open-source platform that helps UAE residents track, analyze, and optimize their utility bills (Electricity, Water, Gas, Internet, AC District Cooling). 

Using AI-powered OCR and anomaly detection, the platform identifies unusual consumption patterns, predicts future bills, and provides actionable savings tips—all while keeping sensitive data under user control.

Built by **DynamicWebLab**, this project addresses the widespread frustration of unexplained bill spikes in the UAE while demonstrating transparent, ethical data handling.

---

## 😣 The Problem

UAE residents face significant challenges with utility bills:

1.  **Unexpected Spikes:** Bills can double without clear explanation (AC issues, leaks, meter errors).
2.  **No Historical Tracking:** Provider portals show limited history, making trend analysis difficult.
3.  **Complex Tariffs:** Time-of-day pricing, slab rates, and seasonal adjustments are hard to understand.
4.  **Privacy Concerns:** Users hesitate to upload bills to closed apps due to address and account number exposure.
5.  **No Community Benchmarking:** Residents don't know if their consumption is normal for their villa/apartment size.

---

## ✨ Features

### 🚀 MVP (Phase 1)
- [x] **Bill Upload & OCR:** Upload PDF/image bills; Python extracts amount, date, consumption units.
- [x] **Consumption Dashboard:** Visual charts showing monthly trends (kWh, gallons, AED).
- [x] **Anomaly Alerts:** Notifications when bill exceeds normal range by X%.
- [x] **Provider Support:** DEWA, FEWA, ADDC, SEWA, Empower, Tabreed, Du, Etisalat.

### 🤖 AI & Advanced (Phase 2)
- [ ] **Bill Forecasting:** ML model predicts next month's bill based on historical data + weather.
- [ ] **Community Benchmarking:** Anonymous comparison with similar properties (same area, type).
- [ ] **Leak Detection Alert:** Flags unusual water consumption patterns suggesting leaks.
- [ ] **Solar ROI Calculator:** Estimates savings if user installs solar panels.

### 🏢 Enterprise (Phase 3)
- [ ] **Landlord Dashboard:** Track multiple property utilities for tenant billing.
- [ ] **Property Management API:** Integrate with building management systems.
- [ ] **White-Label:** Utility companies can use for customer engagement.

---

## 🆓 Free vs Paid Modules

UtilityWise UAE is **open source (MIT)**. The core platform is free and self-hostable:

- **Free (open source):** Bill upload & OCR, consumption dashboard, anomaly alerts, multi-provider support, Docker setup, encryption, and—as we ship them—basic forecasting, leak detection, basic solar ROI, multi-property (single user), and read-only API.

- **Paid (optional):** Managed cloud hosting, community benchmarking service, advanced solar ROI, weather-enhanced forecasting, landlord/property-management features, white-label, and premium/enterprise support. These fund maintenance and keep the core free.

See **[docs/ROADMAP.md](docs/ROADMAP.md)** for the full phased plan and free/paid breakdown.

---

## 🛠 Tech Stack

| Component | Technology | Purpose |
| :--- | :--- | :--- |
| **Backend** | Laravel 11 (PHP 8.3) | Auth, Dashboard, Alerts, Scheduling |
| **AI Service** | Python (FastAPI) | OCR, Anomaly Detection, Forecasting |
| **Frontend** | Blade + Chart.js | Interactive Bill Visualizations |
| **Database** | MySQL 8.0 | Encrypted Bill Data |
| **Queue** | Redis | Async OCR processing |
| **CMS** | WordPress (Headless) | Savings tips, UAE tariff guides, SEO |
| **Hosting** | Docker | Self-hostable for privacy |

---

## 📂 Project Structure

```text
utilitywise-uae/
├── app/                    # Laravel Backend
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BillController.php
│   │   │   ├── DashboardController.php
│   │   │   └── AlertController.php
│   │   └── Middleware/
│   │       └── EncryptBillData.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Bill.php
│   │   └── ConsumptionRecord.php
│   ├── Services/
│   │   ├── BillParsingService.php
│   │   └── AnomalyDetectionService.php
│   └── Jobs/
│       └── ProcessBillOCR.php
├── ai-service/             # Python Microservice
│   ├── main.py
│   ├── ocr_extractor.py
│   ├── anomaly_detector.py
│   ├── forecast_model.py
│   └── requirements.txt
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php
│   │   └── bills.blade.php
│   └── js/
├── tests/                  # PHPUnit & PyTest
├── docker/
│   ├── docker-compose.yml
│   ├── Dockerfile.php
│   └── Dockerfile.python
├── docs/
│   ├── UAE_Utility_Tariffs.md
│   └── Privacy_Guidelines.md
├── .env.example
├── README.md
├── LICENSE
├── CONTRIBUTING.md
└── CODE_OF_CONDUCT.md
```

---

## 🚀 Installation

*(See [docs/ROADMAP.md](docs/ROADMAP.md) for current phase. Full installation steps will be added as the codebase is built.)*

1. Clone the repo and copy `.env.example` to `.env`.
2. Backend: `composer install`, configure DB and app key.
3. AI service: from `ai-service/`, create a venv and `pip install -r requirements.txt`.
4. Optional: use Docker from `docker/` for a full stack.

---

## ⚙️ Configuration

Configure `.env` with your database, Redis, and (if used) AI service URL. Never commit `.env` — it is in `.gitignore`.

---

## 🔒 Security & Privacy

- Bill data is encrypted at rest; processing is local or self-hosted.
- No bill data is sent to third parties by the open-source core.
- See `docs/Privacy_Guidelines.md` (when added) for details.

---

## 🤝 Contributing

Contributions are welcome. Please read [CONTRIBUTING.md](CONTRIBUTING.md) for setup and pull request flow, and [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) for community standards.

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).
