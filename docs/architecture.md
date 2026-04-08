# CompoundX Architecture Baseline

## 1. Platform shape

CompoundX Phase 1 is a multi-tenant web SaaS platform with three delivery surfaces:

- Laravel 11 backend in `apps/api`
- Vue 3 web application in `apps/web`
- Electron admin desktop wrapper in `apps/desktop`

The backend is the system of record. All business logic lives in backend services and policies. The web and desktop layers consume APIs only.

## 2. High-level modules

### Central platform modules

- Identity and access management
- Tenant lifecycle and plan management
- Branding and white-label management
- Billing and subscription automation
- Platform support ticketing
- Feature flags
- Audit and activity center
- Notification template management
- BI and exports

### Tenant modules

- Compound, building, floor, and unit management
- Unit-user access model with owner, family, tenant, and delegate roles
- Resident onboarding and invitation linking
- Billing, fines, and utilities
- Maintenance, complaints, and work orders
- Marketplace and dispute handling
- Visitor and delivery management
- Amenities booking
- Announcements, emergency broadcast, polls, and community notices
- Vendor management and performance scoring
- AI insights and scheduled reporting

## 3. Core architecture principles

- API-first design with `/api/v1` versioning
- clean architecture boundaries: `Http -> Application -> Domain -> Infrastructure`
- tenant-aware request pipeline
- stateless APIs using JWT and refresh token rotation
- asynchronous jobs for invoices, reports, notifications, retries, imports, backups, and archival
- S3-compatible storage for all files
- Redis-backed cache, sessions, rate limiting, queues, Horizon, and idempotency coordination

## 4. Multi-tenancy strategy

### Central vs tenant data split

Central schema:

- platform operators
- tenants and tenant domains
- billing plans and subscription contracts
- feature flags
- shared notification templates
- lead capture and platform support

Tenant schemas:

- users and profiles
- buildings, units, occupancy data
- invoices, payments, penalties
- tickets, complaints, work orders
- marketplace listings and transactions
- bookings, visitors, polls, announcements
- audit records scoped to the tenant

### Routing model

1. Nginx forwards request host and headers.
2. Laravel middleware resolves tenant from subdomain, custom domain, or signed invitation context.
3. `stancl/tenancy` switches PostgreSQL schema for the request lifecycle.
4. application services operate without custom tenant filters because the connection schema is already isolated.

## 5. Security model

- `php-open-source-saver/jwt-auth` for access tokens and refresh flows
- `spatie/laravel-permission` for RBAC
- per-request audit log with actor, tenant, IP, request id, before, and after state
- rate limiting for public and authenticated APIs
- lockout policy for repeated failed logins
- signed URLs for protected files
- idempotency keys required for all financial and state-changing critical endpoints

## 6. Data and consistency rules

Critical workflows must use atomic transactions:

- resident onboarding and unit linking
- invoice generation and payment posting
- marketplace checkout and commission split
- refunds and dispute state transitions
- admin account creation and permission assignment
- audit writes that belong to a business transaction

Soft delete is default for business entities. Hard delete is restricted to approved maintenance utilities only.

## 7. AI and automation layer

Phase 1 uses rule-based and statistical services:

- predictive maintenance scoring from unit age, complaint density, and seasonal patterns
- complaint clustering by issue type and location
- ticket priority scoring using SLA proximity, severity, and resident history
- vendor composite score from response time, resolution ratio, and rating
- intelligent report summaries with templated language
- anomaly alerts for utility spikes

These services should be implemented as deterministic, testable application services and scheduled jobs so they can later evolve into ML-backed workers without API contract changes.

## 8. Integration boundaries

### Payments

Abstract payment adapters behind a gateway interface:

- Zain Cash
- Qi Card
- Neo Iraq
- future gateways such as Stripe and PayTabs

Every adapter must support:

- payment initialization
- callback and webhook verification
- reconciliation payload normalization
- receipt metadata
- manual refund fallback when automated refunds are unavailable

### Notifications

- email via SMTP provider abstraction
- OTP via SMS or WhatsApp provider abstraction
- in-app notifications via database plus Reverb websockets
- future-ready push payload storage for FCM tokens

## 9. Frontend application split

Public and authenticated experiences share one Vue app with route-level separation:

- guest lead capture and public listings
- resident portal
- compound admin portal
- super admin portal

The Electron app wraps the admin portal only and can cache a small shell plus recent data needed for limited offline continuity.

## 10. Observability

- Laravel Telescope in development
- Sentry in production
- structured logs with request and tenant context
- Horizon dashboard for queue monitoring
- uptime, backup, and job-failure alerts to platform operators

## 11. Testing strategy

- service-layer unit tests with minimum 70 percent coverage
- API integration tests for every endpoint
- automated tenant isolation tests at each milestone
- sandbox-backed payment integration tests
- frontend smoke tests for key resident and admin flows
- performance and load tests before milestone 5 sign-off

## 12. Recommended module delivery order

1. tenancy, auth, roles, shared API conventions
2. compound structure, units, resident onboarding
3. announcements, tickets, maintenance, notifications
4. billing, payments, fines, utilities
5. marketplace, disputes, revenue sharing
6. bookings, visitors, polls, super admin
7. AI rules, reports, performance hardening, desktop packaging
