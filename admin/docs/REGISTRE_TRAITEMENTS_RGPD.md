# Registre des traitements de données personnelles
**Responsable de traitement** : EYNOR (EURL) — marque NeoGTB
**Siège** : Rue Aimé Césaire, 33320 Eysines, France
**SIREN** : 989 322 144
**Contact RGPD** : rgpd@neogtb.fr
**Dernière mise à jour** : 29 mars 2026

---

## 1. Formulaire de contact

| Champ | Détail |
|-------|--------|
| **Finalité** | Répondre aux demandes de contact des visiteurs |
| **Base légale** | Intérêt légitime (art. 6.1.f RGPD) |
| **Données collectées** | Nom, email, entreprise (optionnel), sujet, message |
| **Données techniques** | Adresse IP (hashée), page source |
| **Destinataires** | Équipe NeoGTB uniquement |
| **Sous-traitant** | FormSubmit.co (transmission), OVHcloud (hébergement BDD) |
| **Durée de conservation** | 3 ans |
| **Mécanisme de purge** | Commande artisan `purge:data` — scheduler mensuel |

## 2. Newsletter

| Champ | Détail |
|-------|--------|
| **Finalité** | Envoi de la veille GTB mensuelle |
| **Base légale** | Consentement explicite (art. 6.1.a RGPD) |
| **Données collectées** | Email |
| **Destinataires** | Équipe NeoGTB uniquement |
| **Sous-traitant** | FormSubmit.co (transmission), Brevo (envoi email) |
| **Durée de conservation** | Jusqu'au désabonnement |
| **Consentement** | Checkbox obligatoire avant inscription |

## 3. Demandes d'exercice de droits RGPD

| Champ | Détail |
|-------|--------|
| **Finalité** | Traiter les demandes d'exercice de droits (accès, rectification, suppression, portabilité, opposition) |
| **Base légale** | Obligation légale (art. 6.1.c RGPD) |
| **Données collectées** | Nom, email, type de demande, message (chiffrés en base) |
| **Destinataires** | Équipe NeoGTB uniquement |
| **Sous-traitant** | OVHcloud (hébergement BDD) |
| **Durée de conservation** | 3 ans après traitement |
| **Mécanisme de purge** | Commande artisan `purge:data` — scheduler mensuel |
| **Sécurité** | Chiffrement des champs sensibles (email, nom, message) |

## 4. Consentements cookies

| Champ | Détail |
|-------|--------|
| **Finalité** | Preuve de consentement cookies (conformité CNIL) |
| **Base légale** | Obligation légale (art. 7 RGPD) |
| **Données collectées** | Identifiant visiteur (UUID), hash IP, choix de consentement |
| **Destinataires** | Équipe NeoGTB uniquement |
| **Sous-traitant** | OVHcloud (hébergement BDD) |
| **Durée de conservation** | 13 mois |
| **Mécanisme de purge** | Commande artisan `purge:data` — scheduler mensuel |

## 5. Mesure d'audience

| Champ | Détail |
|-------|--------|
| **Finalité** | Statistiques de fréquentation du site |
| **Base légale** | Intérêt légitime (art. 6.1.f RGPD) — outil exempté de consentement |
| **Outil** | Plausible Analytics |
| **Données collectées** | Aucune donnée personnelle (pas de cookies, pas d'IP) |
| **Hébergement** | Allemagne (UE) |
| **Durée de conservation** | Données agrégées uniquement, non identifiantes |

## 6. Administration du site (back-office)

| Champ | Détail |
|-------|--------|
| **Finalité** | Gestion des contenus, articles, pages du site |
| **Base légale** | Intérêt légitime (art. 6.1.f RGPD) |
| **Données collectées** | Nom, email, mot de passe (hashé) des administrateurs |
| **Destinataires** | Administrateurs NeoGTB uniquement |
| **Sous-traitant** | OVHcloud (hébergement BDD) |
| **Durée de conservation** | Durée du compte administrateur |

---

## Mesures de sécurité techniques

- Chiffrement des données sensibles en base (champs RGPD)
- Hashage des mots de passe (bcrypt, 12 rounds)
- Sessions chiffrées et cookies sécurisés (Secure, SameSite=Lax)
- HTTPS obligatoire (certificat Let's Encrypt)
- Headers de sécurité : CSP, X-Frame-Options DENY, X-Content-Type-Options nosniff
- Rate limiting sur les routes sensibles (contact, RGPD)
- Soft delete sur les messages de contact (traçabilité)
- Audit log sur les actions admin

## Sous-traitants

| Sous-traitant | Pays | Rôle | Garanties |
|---------------|------|------|-----------|
| OVHcloud | France | Hébergement serveur + BDD | Données UE, certifié ISO 27001 |
| Plausible | Allemagne | Analytics | Sans cookies, sans données personnelles |
| FormSubmit.co | — | Transmission formulaires | HTTPS, pas de stockage long terme |
| Brevo | France | Envoi emails transactionnels | Données UE, conforme RGPD |
