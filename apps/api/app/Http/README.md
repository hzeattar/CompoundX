# Http Layer

Public API boundary:

- controllers stay thin
- validation requests enforce input rules
- middleware resolves tenant, auth, locale, and idempotency
- API resources map outputs to the standard response envelope
