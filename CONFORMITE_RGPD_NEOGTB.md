# CONFORMITÉ RGPD — NEOGTB

**Date** : 18 mars 2026
**Statut** : Implémenté (frontend Astro)

---

## Checklist CNIL

### Informations obligatoires
- [x] **Mentions légales** — `/mentions-legales` — Éditeur, hébergeur, propriété intellectuelle, responsabilité
- [x] **Politique de confidentialité** — `/politique-de-confidentialite` — 11 sections RGPD complètes
- [x] **Identité du responsable de traitement** — Déclarée dans mentions légales + politique
- [x] **DPO / Contact RGPD** — Email rgpd@neogtb.fr déclaré
- [x] **Lien CNIL** — Adresse et site de la CNIL mentionnés dans la politique

### Consentement cookies
- [x] **Bandeau cookies** — Affiché après 500ms au premier accès
- [x] **Choix par catégorie** — Essentiels (toujours actifs), Analytics (toggle), Marketing (toggle)
- [x] **Accepter tout** — Bouton dédié
- [x] **Tout refuser** — Bouton dédié (aussi accessible que "Accepter")
- [x] **Personnaliser** — Modal détaillée avec description de chaque catégorie
- [x] **Lien politique cookies** — Renvoi vers politique de confidentialité section cookies
- [x] **Retrait du consentement** — Bouton flottant "Gérer mes cookies" toujours visible
- [x] **Stockage du consentement** — Cookie `neogtb_consent` (durée : 13 mois / 395 jours)
- [x] **Google Consent Mode v2** — Intégré (gtag consent update)
- [x] **Scripts conditionnels** — GA4 ne se charge QUE si consentement analytics = true

### Droits des personnes
- [x] **Droit d'accès** — Formulaire `/mes-droits-rgpd` type "access"
- [x] **Droit de rectification** — Formulaire type "rectification"
- [x] **Droit à l'effacement** — Formulaire type "deletion"
- [x] **Droit à la portabilité** — Formulaire type "portability"
- [x] **Droit d'opposition** — Formulaire type "opposition"
- [x] **Délai de réponse** — 30 jours mentionné
- [x] **Chiffrement annoncé** — Mention que les données sont chiffrées

### Traitements de données
- [x] **Formulaire de contact** — Finalité, base légale, durée documentées
- [x] **Diagnostic GTB** — Traitement local navigateur documenté (aucune donnée serveur)
- [x] **Générateur CEE** — Traitement local navigateur documenté (aucune donnée serveur)
- [x] **Cookies analytiques** — GA4 documenté avec lien politique Google
- [x] **Demandes RGPD** — Traitement documenté (obligation légale)

### Durées de conservation
- [x] Messages de contact : 3 ans
- [x] Consentements cookies : 13 mois
- [x] Demandes RGPD : 3 ans après traitement
- [x] Données analytics : 25 mois

### Transferts hors UE
- [x] Vercel (hébergement) — Clauses contractuelles types mentionnées
- [x] Google Analytics — Data Privacy Framework UE-US mentionné

---

## Architecture technique implémentée

### Frontend (Astro)
```
src/pages/
├── mentions-legales.astro          — Page mentions légales complète
├── politique-de-confidentialite.astro — Politique RGPD 11 sections
└── mes-droits-rgpd.astro           — Formulaire exercice des droits (5 types)

src/layouts/Layout.astro             — Bandeau cookies Alpine.js intégré
                                     — Bouton flottant "Gérer mes cookies"
                                     — Liens légaux dans le footer
```

### Bandeau cookies (Alpine.js)
- Composant `cookieConsent()` dans Layout.astro
- Cookie `neogtb_consent` : JSON `{analytics: bool, marketing: bool}`
- Durée : 395 jours (13 mois CNIL)
- Affichage différé de 500ms
- Google Consent Mode v2 compatible

### À implémenter côté backend (Laravel admin)
Les éléments suivants sont documentés mais nécessitent l'implémentation backend :

1. **Migrations BDD** — `cookie_consents`, `gdpr_requests`, `privacy_policy_versions`
2. **Modèles Laravel** — `CookieConsent`, `GdprRequest`, `PrivacyPolicyVersion`
3. **Contrôleur** — `RgpdConsentController` (POST/GET/DELETE `/rgpd/consent`)
4. **Formulaire droits RGPD** — Actuellement simulé côté client, à connecter au backend
5. **Admin Filament** — Dashboard RGPD, traitement des demandes, export registre
6. **Chiffrement AES-256** — Données personnelles dans `gdpr_requests`
7. **Purge automatique** — Cron pour consentements > 13 mois et demandes > 3 ans
8. **Audit trail** — Logs d'accès aux données personnelles

---

## Points d'attention

| Point | Statut | Action requise |
|-------|--------|---------------|
| Mentions légales : infos société | ⚠️ À compléter | Renseigner SIRET, RCS, capital, adresse |
| DPO : email rgpd@neogtb.fr | ⚠️ À créer | Configurer la boîte email |
| GA4 : tracking ID | ⚠️ À configurer | Ajouter le script GA4 conditionnel |
| Formulaire droits : backend | ⚠️ À implémenter | Connecter au Laravel admin |
| Cookie consent : enregistrement BDD | ⚠️ À implémenter | Route POST `/rgpd/consent` |
| Hébergeur : vérifier Vercel | ✅ OK si Vercel | Adapter si Netlify |

---

*Rapport de conformité RGPD généré le 18 mars 2026*
