# Registre des activités de traitement

**Responsable de traitement** : EYNOR (EURL) — Marque NeoGTB
**Représentant** : Ulrich CALMO, Gérant
**Date de création** : 24 mars 2026
**Dernière mise à jour** : 7 avril 2026

---

## 1. Formulaire de contact

| Champ | Détail |
|-------|--------|
| **Finalité** | Répondre aux demandes d'information des visiteurs du site |
| **Base légale** | Intérêt légitime (art. 6.1.f RGPD) — répondre aux sollicitations |
| **Catégories de données** | Nom, prénom, adresse email, entreprise (optionnel), objet de la demande, message |
| **Personnes concernées** | Visiteurs du site neogtb.fr / neogtb.com |
| **Destinataires** | Ulrich CALMO (gérant EYNOR), Brevo (Sendinblue SAS, France) pour l'envoi SMTP des réponses |
| **Transferts hors UE** | Aucun (Brevo hébergé en UE) |
| **Durée de conservation** | 3 ans à compter du dernier contact |
| **Mesures de sécurité** | HTTPS (TLS 1.3), stockage en base PostgreSQL chiffrée, accès restreint au gérant, suppression après expiration |

---

## 2. Newsletter / Veille GTB mensuelle

| Champ | Détail |
|-------|--------|
| **Finalité** | Envoi de la veille technique mensuelle sur la GTB/GTC |
| **Base légale** | Consentement explicite (art. 6.1.a RGPD + art. L34-5 CPCE) |
| **Catégories de données** | Adresse email |
| **Personnes concernées** | Abonnés à la newsletter via le site |
| **Destinataires** | Ulrich CALMO (gérant), Brevo (Sendinblue SAS, France) pour l'envoi |
| **Transferts hors UE** | Aucun (Brevo hébergé en UE) |
| **Durée de conservation** | Jusqu'au désabonnement + 3 ans d'archivage de la preuve de consentement |
| **Mesures de sécurité** | HTTPS, lien de désabonnement dans chaque email, double opt-in recommandé |

---

## 3. Diagnostic GTB en ligne

| Champ | Détail |
|-------|--------|
| **Finalité** | Fournir un diagnostic de maturité GTB et envoyer le rapport par email à l'utilisateur (lead qualification) |
| **Base légale** | Consentement (art. 6.1.a RGPD) — l'utilisateur saisit volontairement son email pour recevoir le rapport |
| **Catégories de données** | Email, nom (optionnel), entreprise (optionnel), réponses au questionnaire (type de bâtiment, surface), score calculé |
| **Personnes concernées** | Visiteurs utilisant l'outil et soumettant leur email |
| **Destinataires** | Ulrich CALMO (gérant EYNOR). Stockage : table `audit_leads` (Laravel/PostgreSQL) |
| **Transferts hors UE** | Aucun |
| **Durée de conservation** | 3 ans à compter de la soumission (prospection commerciale) |
| **Mesures de sécurité** | HTTPS (TLS 1.3), email/nom/entreprise chiffrés en base (Laravel encrypted casts), CSRF, rate-limiting 5/min |

---

## 4. Générateur de dossier CEE

| Champ | Détail |
|-------|--------|
| **Finalité** | Estimer les Certificats d'Économies d'Énergie et envoyer l'estimation par email à l'utilisateur |
| **Base légale** | Consentement (art. 6.1.a RGPD) — l'utilisateur saisit volontairement son email pour recevoir l'estimation |
| **Catégories de données** | Email, données techniques du bâtiment (secteur, surface, zone climatique, calcul TH-116) |
| **Personnes concernées** | Visiteurs utilisant l'outil et soumettant leur email |
| **Destinataires** | Ulrich CALMO (gérant EYNOR). Stockage : table `cee_leads` (Laravel/PostgreSQL) |
| **Transferts hors UE** | Aucun |
| **Durée de conservation** | 3 ans à compter de la soumission (prospection commerciale) |
| **Mesures de sécurité** | HTTPS (TLS 1.3), email chiffré en base (Laravel encrypted casts), CSRF, rate-limiting 5/min |

---

## 5. Exercice des droits RGPD

| Champ | Détail |
|-------|--------|
| **Finalité** | Traiter les demandes d'exercice de droits des personnes concernées |
| **Base légale** | Obligation légale (art. 6.1.c RGPD — articles 15 à 21) |
| **Catégories de données** | Nom, adresse email, type de demande, justificatif d'identité éventuel |
| **Personnes concernées** | Toute personne exerçant ses droits |
| **Destinataires** | Ulrich CALMO (gérant EYNOR) |
| **Transferts hors UE** | Aucun |
| **Durée de conservation** | 5 ans à compter du traitement de la demande (preuve de conformité) |
| **Mesures de sécurité** | HTTPS, accès restreint au gérant, suppression des justificatifs d'identité après vérification |

---

## 6. Mesure d'audience (Analytics)

| Champ | Détail |
|-------|--------|
| **Finalité** | Mesurer la fréquentation du site et améliorer l'expérience utilisateur |
| **Base légale** | Exemption de consentement (si outil conforme aux recommandations CNIL — Plausible Analytics recommandé) ou Consentement (art. 6.1.a) si Google Analytics |
| **Catégories de données** | Adresse IP anonymisée, pages visitées, durée de session, type de navigateur, source de trafic |
| **Personnes concernées** | Tous les visiteurs du site |
| **Destinataires** | Plausible Analytics OÜ (Estonie, UE) ou Google LLC (USA) |
| **Transferts hors UE** | Aucun si Plausible. Si GA4 : transfert vers USA couvert par Data Privacy Framework |
| **Durée de conservation** | 25 mois maximum (recommandation CNIL) |
| **Mesures de sécurité** | Anonymisation IP, pas de cookies (Plausible) ou consentement préalable (GA4) |

---

## 7. Cookies et préférences

| Champ | Détail |
|-------|--------|
| **Finalité** | Stocker les préférences de consentement de l'utilisateur |
| **Base légale** | Exemption de consentement (cookies strictement nécessaires — art. 82 loi Informatique et Libertés) |
| **Catégories de données** | Identifiant de consentement (cookie `neogtb_consent`) |
| **Personnes concernées** | Tous les visiteurs du site |
| **Destinataires** | Aucun — stockage local uniquement |
| **Transferts hors UE** | Aucun |
| **Durée de conservation** | 13 mois (395 jours) — conforme recommandation CNIL |
| **Mesures de sécurité** | Cookie SameSite=Lax, Secure (HTTPS uniquement), valeurs distinctes `accepted` / `refused` |

---

## 8. Administration du site (back-office Laravel)

| Champ | Détail |
|-------|--------|
| **Finalité** | Gérer le contenu du site (pages, articles de blog, paramètres) |
| **Base légale** | Intérêt légitime (art. 6.1.f) — administration du site |
| **Catégories de données** | Identifiants de connexion administrateur (email, mot de passe hashé) |
| **Personnes concernées** | Administrateurs du site (Ulrich CALMO) |
| **Destinataires** | Aucun |
| **Transferts hors UE** | Aucun |
| **Durée de conservation** | Durée de vie du compte administrateur |
| **Mesures de sécurité** | Mot de passe hashé (bcrypt), HTTPS, sessions sécurisées, accès restreint |

---

## 9. Sous-traitants (récapitulatif)

| Sous-traitant | Rôle | Localisation | DPA / Garanties |
|---|---|---|---|
| **Brevo (Sendinblue SAS)** | Envoi SMTP des emails (contact, RGPD, réponses) | France (UE) | DPA Brevo standard, RGPD-compliant |
| **Hébergeur VPS** | Hébergement serveur (Laravel + PostgreSQL) | UE | Contrat d'hébergement, données chiffrées au repos |
| **Plausible Analytics OÜ** | Mesure d'audience (cookieless) | Estonie (UE) | RGPD-compliant, pas de cookies, IP anonymisée |

---

*Ce registre est tenu conformément à l'article 30 du Règlement (UE) 2016/679. Il est mis à jour à chaque nouveau traitement ou modification significative.*
