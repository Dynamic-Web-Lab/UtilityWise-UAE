# Contributing to UtilityWise UAE

Thank you for considering contributing. This document explains how to get set up and submit changes.

## Code of Conduct

By participating, you agree to uphold our [Code of Conduct](CODE_OF_CONDUCT.md).

## How to Contribute

- **Bug reports** — Open an issue with steps to reproduce and your environment (OS, PHP/Python versions).
- **Feature ideas** — Open an issue and describe the use case; check [docs/ROADMAP.md](docs/ROADMAP.md) for what’s planned.
- **Code** — Open a pull request from a branch; see below.

## Development Setup

1. **Clone and enter the repo**
   ```bash
   git clone https://github.com/your-org/UtilityWise-UAE.git
   cd UtilityWise-UAE
   ```

2. **Backend (Laravel)**  
   See [README.md](README.md#installation) for PHP/Composer and `.env` setup. Use `.env.example` as a template; never commit `.env`.

3. **AI service (Python)**  
   From `ai-service/` (when present):
   ```bash
   python -m venv .venv
   source .venv/bin/activate   # or `.venv\Scripts\activate` on Windows
   pip install -r requirements.txt
   ```

4. **Docker (optional)**  
   Use the project’s Docker setup for a full stack; see README.

## Pull Request Process

1. Fork the repo and create a branch from `main` (e.g. `fix/ocr-dewa`, `docs/install`).
2. Make your changes; keep scope focused.
3. Run tests if available: `composer test`, `pytest`, etc.
4. Update docs if you change behavior or add options.
5. Push your branch and open a PR. Describe what changed and why.
6. Address review feedback. Maintainers will merge when ready.

## What We Care About

- **Privacy:** No sending bill data off the user’s machine without explicit consent; document any optional external calls.
- **Compatibility:** Support the versions listed in README (e.g. Laravel 11, Python 3.10+).
- **Docs:** Keep README, ROADMAP, and in-repo docs accurate.

## License

Contributions are made under the [MIT License](LICENSE). By submitting a PR, you agree your contributions are licensed under MIT.
