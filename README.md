# CompoundX

Monorepo foundation for the CompoundX Phase 1 delivery:

- `apps/api`: Laravel 11 API-first backend, multi-tenant by schema
- `apps/web`: Vue 3 resident and public web portals
- `apps/desktop`: Electron admin desktop shell
- `docs`: architecture, milestones, and technical decisions
- `infrastructure`: local infrastructure configs

## Phase 1 goals

- Production-ready web SaaS for compounds, towers, and facility operators
- API-first backend that remains mobile-ready for Flutter Phase 2
- True schema-per-tenant isolation using PostgreSQL and `stancl/tenancy`
- White-label branding, payments, marketplace, AI rules, super admin, and admin desktop

## Current repository baseline

This repository starts with an execution-ready foundation rather than a throwaway prototype:

- architecture and delivery docs derived from the provided scope
- initial backend dependency manifest for Laravel 11 and required packages
- web portal starter built with Vue 3, Pinia, Tailwind CSS, and Vue I18n
- Electron desktop shell starter for admin workflows
- local infrastructure services for PostgreSQL, Redis, object storage, and mail testing
- CI scaffold to validate manifests and the frontend build

## Recommended local toolchain

- PHP 8.3+
- Composer 2.7+
- Node.js 20 LTS+
- npm 10+ or pnpm 9+
- Docker Desktop 26+

## Repository structure

```text
.
|-- apps
|   |-- api
|   |-- desktop
|   `-- web
|-- docs
|-- infrastructure
`-- docker-compose.yml
```

## Key technical decisions

- API versioning under `/api/v1`
- all critical financial and onboarding flows wrapped in atomic transactions
- soft delete as default deletion model for business entities
- Redis mandatory for queues, cache, rate limiting, idempotency coordination, and Horizon
- S3-compatible object storage for all tenant media and generated files
- structured audit logging with tenant and request context

## Delivery planning

The execution plan and milestone mapping live in:

- `docs/architecture.md`
- `docs/milestones.md`
- `docs/multitenancy-poc.md`
- `docs/openapi/api.v1.yaml`

## Immediate next build steps

1. Install PHP, Composer, Node.js 20, and Docker locally.
2. Generate the full Laravel 11 application inside `apps/api`.
3. Install frontend and desktop dependencies.
4. Wire tenant-aware authentication, branding bootstrap, and core admin domain modules.
5. Stand up CI, test database, and tenant isolation PoC before business feature work.
