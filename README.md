# Inventory System

This is a minimal PHP inventory system skeleton providing:

- Product CRUD with barcode generation and CSV import/export.
- POS checkout that validates stock and records audit logs.
- Purchase (GRN) workflow updating stock and average cost.
- User authentication with role-based JWT tokens and simple audit logging.
- Language files for English and French located in `app/lang`.
- Runtime language can be toggled with the `Lang` helper using `?lang=en` or `?lang=fr`.
- Basic REST API endpoints under `/api`.

This code is intentionally lightweight and uses JSON files in the `data/` directory for persistence. Ensure the `data/` directory is writable by the web server.
