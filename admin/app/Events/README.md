# Domain Events

Events applicatifs NeoGTB.

## Liste

- `ContactMessageSubmitted(ContactMessage $message)` — nouveau message contact
- `AuditLeadCaptured(AuditLead $lead)` — nouveau lead audit
- `CeeLeadCaptured(CeeLead $lead)` — nouveau lead CEE
- `NewsletterConfirmed(NewsletterSubscriber $subscriber)` — abonnement newsletter confirme
- `GdprRequestSubmitted(GdprRequest $request)` — nouvelle demande RGPD

## Brancher un listener

Dans `AppServiceProvider::boot()` :

```php
\Illuminate\Support\Facades\Event::listen(
    \App\Events\ContactMessageSubmitted::class,
    \App\Listeners\MonListener::class,
);
```

## Note importante

Ces events ne sont **PAS encore dispatches** depuis les services applicatifs.
Le branchement (appels `Event::dispatch(...)` dans ContactService, AuditLeadService, etc.)
se fera dans un sprint dedie ou manuellement au moment d'ajouter un listener concret.

## Login tracking

Le listener `App\Listeners\RecordAdminLogin` est branche sur
`Illuminate\Auth\Events\Login` et delegue a `App\Services\Auth\LoginTracker`
pour remplir `admins.last_login_at` / `admins.last_login_ip` (via `saveQuietly`
pour ne pas re-declencher `AdminAuditObserver`).
