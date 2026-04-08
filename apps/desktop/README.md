# CompoundX Desktop

Electron shell for the admin portal.

## Phase 1 intent

- Windows desktop executable for compound admins
- secure authentication using the same backend APIs as the web admin
- lightweight offline continuity for cached shell and recently viewed data where applicable
- installer packaging at final handover

## Immediate next steps

1. Point the desktop shell to the authenticated admin route.
2. Add secure token persistence using OS keychain APIs.
3. Add update strategy and packaging profiles.
4. Add limited offline cache for read-heavy views only.
