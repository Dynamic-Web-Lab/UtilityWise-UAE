# UtilityWise UAE — Development Roadmap

**Open-source core • Optional paid modules • Phased delivery**

This roadmap defines what ships as **free & open source** (MIT) and what is offered as **optional paid modules** for sustainability, while keeping the core platform fully usable without payment.

---

## License & Module Model

| Type | License | Distribution |
|------|--------|--------------|
| **Free / Open Source** | MIT | Public GitHub, self-hostable, no payment required |
| **Paid / Premium** | Commercial | Optional add-ons (plugins, cloud services, support); core remains free |

---

## Phase 1 — MVP (Foundation)

**Goal:** Stable, self-hostable core that anyone can run for personal bill tracking.

### Free (Open Source)

| # | Item | Status | Notes |
|---|------|--------|--------|
| 1 | Bill upload (PDF/image) + Python OCR extraction | ✅ Done | Amount, date, consumption units |
| 2 | Consumption dashboard (charts: kWh, gallons, AED) | ✅ Done | Blade + Chart.js |
| 3 | Anomaly alerts (bill exceeds normal range by X%) | ✅ Done | Notifications |
| 4 | Multi-provider support (DEWA, FEWA, ADDC, SEWA, Empower, Tabreed, Du, Etisalat) | ✅ Done | Parser per provider |
| 5 | Docker setup for self-hosting | ✅ Done | PHP + Python services |
| 6 | Encrypted bill storage & privacy docs | ✅ Done | `EncryptBillData`, docs |
| 7 | Docs: installation, config, UAE tariffs, privacy | ✅ Done | `docs/UAE_Utility_Tariffs.md`, `docs/Privacy_Guidelines.md` |
| 8 | Basic test suite (PHPUnit + PyTest) | ✅ Started | `tests/Unit`, `phpunit.xml` |
| 9 | Contributing guide + code of conduct | ✅ Done | `CONTRIBUTING.md`, `CODE_OF_CONDUCT.md` |

### Paid (Optional add-ons, Phase 1)

| # | Module | Description |
|---|--------|-------------|
| P1.1 | **Managed cloud hosting** | Hosted instance so users don’t self-host (optional) |
| P1.2 | **Priority support** | Email/slack support for organizations |

**Phase 1 exit criteria:** Anyone can clone, build with Docker, upload bills, see dashboard and alerts, and read clear docs — no payment required.

---

## Phase 2 — AI & Advanced Features

**Goal:** Smarter insights (forecasting, benchmarking, leak hints, solar ROI) with a clear free/paid split.

### Free (Open Source)

| # | Item | Status | Notes |
|---|------|--------|--------|
| 1 | **Bill forecasting** | ✅ Done | Weighted-avg forecast; AI `/forecast` + Laravel ForecastService; dashboard widget |
| 2 | **Leak detection alert** | ✅ Done | Heuristic water spike; AI `/leak-check` + LeakDetectionService; alert type `leak` |
| 3 | **Solar ROI calculator (basic)** | ✅ Done | Formula-based; SolarController + views; payback estimate |
| 4 | **Improve OCR accuracy** | ✅ Done | Provider-specific regex for amount, date, kWh, gallons in `ocr_extractor.py` |
| 5 | **Export (CSV/PDF)** | ✅ Done | ExportController: CSV download; PDF = print-friendly HTML |

### Paid (Optional add-ons, Phase 2)

| # | Module | Description |
|---|--------|-------------|
| P2.1 | **Community benchmarking** | Anonymous comparison with similar properties (area, type); requires aggregated, privacy-safe backend service |
| P2.2 | **Advanced solar ROI** | Deeper modeling, panel configs, payback scenarios (premium calculator) |
| P2.3 | **Weather-integrated forecasting** | Uses licensed or premium weather API for better predictions |
| P2.4 | **Premium support & custom integrations** | One-off integrations (e.g. specific building or provider) |

**Phase 2 exit criteria:** Core forecasting, leak alerts, and basic solar ROI are in the open-source repo; advanced benchmarking and premium features are clearly marked as paid.

---

## Phase 3 — Enterprise & Scale

**Goal:** Multi-property and B2B use cases without locking the core.

### Free (Open Source)

| # | Item | Status | Notes |
|---|------|--------|--------|
| 1 | **Multi-property (basic)** | 🔲 Planned | Single user, multiple properties/meters in core app |
| 2 | **REST API (read-only)** | 🔲 Planned | Export/read own data for scripts and dashboards |
| 3 | **Documentation for self-hosted scaling** | 🔲 Planned | DB, queue, caching guidance |

### Paid (Optional add-ons, Phase 3)

| # | Module | Description |
|---|--------|-------------|
| P3.1 | **Landlord dashboard** | Tenant billing, multiple units, access control |
| P3.2 | **Property management API** | Deeper integration with building management systems |
| P3.3 | **White-label** | Rebranding for utilities or property managers |
| P3.4 | **SLA & dedicated support** | Enterprise support and custom deployment help |

**Phase 3 exit criteria:** Core supports multi-property and read API; landlord/property-management and white-label are commercial offerings.

---

## Summary: Free vs Paid

- **Always free (open source):** Bill upload, OCR, dashboard, anomaly alerts, multi-provider, Docker, encryption, basic forecasting, leak alerts, basic solar ROI, multi-property (basic), read API, and all docs in the repo.
- **Paid (optional):** Managed cloud, community benchmarking service, advanced solar ROI, weather-enhanced forecasting, landlord/property-management features, white-label, and premium/enterprise support.

---

## Suggested Timeline (High Level)

| Phase | Focus | Target (example) |
|-------|--------|-------------------|
| **Phase 1** | Harden MVP, docs, tests, open-source release | Q1–Q2 |
| **Phase 2** | Forecasting, leak detection, basic solar ROI (free); benchmarking & premium features (paid) | Q2–Q3 |
| **Phase 3** | Multi-property (free), landlord/API/white-label (paid) | Q3–Q4 |

Adjust dates to your release cycle; the important part is keeping the phased and free/paid split consistent.

---

## For the Public Repo

- **README:** Keep “Disclaimer” and “Privacy-first”; add one short section: “Free core, optional paid modules” with a link to this roadmap.
- **LICENSE:** MIT for the repository; paid modules can live in a separate repo or be clearly gated (e.g. “Premium” in docs/ or a separate product page).
- **CONTRIBUTING.md:** Encourage contributions to the free core; mention that paid modules fund maintenance and hosting.

If you want, next step can be a short “Free vs Paid” section for the main README and a `CONTRIBUTING.md` skeleton.
