# Privacy guidelines (UtilityWise UAE)

## Principles

1. **Local-first:** Bill data is processed on the user’s machine or self-hosted instance. The open-source core does not send bill content to third parties.
2. **Minimal data:** Only data necessary for analysis (amounts, dates, consumption) is stored; raw PDFs can be discarded after extraction.
3. **Encryption:** Sensitive fields are encrypted at rest where applicable (see app middleware and storage).
4. **No resale:** Bill data is never sold or shared for advertising.

## What we store (self-hosted)

- User account (email, hashed password).
- Extracted bill data: provider, amount, date, consumption (kWh/gallons), and optional reference to stored file path.
- Alerts and preferences.

## What we do not do (core product)

- Send bill PDFs or images to external APIs (other than the user’s own AI service).
- Share or sell user data.
- Use data for advertising or profiling.

## Optional paid services

If we offer managed hosting or cloud features (see [ROADMAP.md](ROADMAP.md)), their privacy terms will be documented separately and require explicit consent.

## Reporting issues

If you believe the software violates these guidelines, please open an issue or contact the maintainers.
