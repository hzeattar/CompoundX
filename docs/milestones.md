# CompoundX Proposed 16-Week Delivery Plan

## Schedule assumption

This plan assumes project kickoff on **April 13, 2026** and a 16-week execution window ending **July 31, 2026**.

The source scope has a commercial inconsistency around milestone count and final payment percentage. This plan keeps the technical work split into six milestones so it can be mapped to the final contract without losing delivery clarity.

## Milestone 1: Foundation and Tenancy PoC

Dates: **April 13, 2026 - May 1, 2026**

Deliverables:

- monorepo setup, branching rules, CI scaffold, Docker baseline
- Laravel 11 backend bootstrap
- central and tenant schema design draft
- `stancl/tenancy` schema-per-tenant PoC
- tenant A and tenant B isolation demo
- automated isolation test
- base JWT auth and RBAC skeleton
- architecture and deployment baseline docs

Acceptance gate:

- zero cross-tenant data access verified
- working tenant resolution by host or mapped domain

## Milestone 2: Core Admin and Resident Structure

Dates: **May 4, 2026 - May 29, 2026**

Deliverables:

- compound, building, floor, and unit management
- resident profiles and multi-user per unit model
- invitation code and unit-link onboarding flow
- admin user management and role assignment
- branding bootstrap per tenant
- announcements base module
- audit log framework

Acceptance gate:

- live demo of admin creating compound structures and linking users to units

## Milestone 3: Resident Operations and Communication

Dates: **June 1, 2026 - June 26, 2026**

Deliverables:

- resident portal shell
- complaints and suggestions
- maintenance requests and work order lifecycle
- community notices and emergency broadcast
- polls and resident voting
- visitor and delivery pre-registration
- amenities booking with slot conflict prevention
- Arabic, English, and Kurdish UI pass for resident flows

Acceptance gate:

- resident can authenticate, view dashboard, submit service requests, and receive notifications

## Milestone 4: Financials, Marketplace, and Imports

Dates: **June 29, 2026 - July 17, 2026**

Deliverables:

- invoicing, penalties, utility dashboard, and collections
- idempotent payment workflows and gateway adapter framework
- marketplace listings, approvals, disputes, and manual refund path
- commission split configuration per tenant
- import tooling for residents, units, invoices, and vendors
- PDF generation and branded documents

Acceptance gate:

- billing and marketplace transactions run end-to-end with audit trail and idempotency

## Milestone 5: Super Admin, AI Rules, Performance, and Desktop

Dates: **July 20, 2026 - July 31, 2026**

Deliverables:

- super admin dashboards and tenant lifecycle controls
- feature flags and dynamic content management
- AI insights layer rules and scheduled reports
- vendor scoring and anomaly detection
- load testing package and optimization pass
- Electron admin desktop packaging prep
- backup validation and restore drill

Acceptance gate:

- AI rules functional and testable
- load test evidence for platform and per-tenant concurrency targets

## Milestone 6: UAT, Hardening, and Handover

Dates: **August 3, 2026 - August 14, 2026**

Deliverables:

- client UAT support and bug-fix sprint
- production deployment and staging validation
- full API documentation and handover package
- final backup and restore documentation
- credential handover checklist
- recorded or documented knowledge transfer session
- Windows installer delivery for admin desktop

Acceptance gate:

- zero critical issues
- written final acceptance

## Cross-milestone workstreams

- testing and QA reports produced at every milestone
- documentation updated continuously, not deferred to the end
- security review and RBAC verification repeated after each new module
- translation completeness tracked from Milestone 2 onward
