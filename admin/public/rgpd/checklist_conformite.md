# Checklist de conformité RGPD — NeoGTB

**Date** : 24 mars 2026
**Responsable** : Ulrich CALMO

---

## Priorité CRITIQUE — À faire immédiatement

- [ ] **Créer l'adresse email rgpd@neogtb.fr** — Obligatoire pour recevoir les demandes d'exercice de droits. Peut être une redirection vers hello@neogtb.fr dans un premier temps.
- [ ] **Rendre le formulaire RGPD fonctionnel** — Le formulaire /mes-droits-rgpd simule un envoi sans transmettre la demande. Connecter au backend Laravel ou ajouter un fallback `mailto:rgpd@neogtb.fr`.
- [ ] **Ajouter la mention RGPD sur le formulaire de contact** — Texte informatif sous le bouton d'envoi : finalité, base légale, durée, lien vers la politique de confidentialité.
- [ ] **Ajouter le consentement opt-in sur la newsletter** — Case à cocher obligatoire avant inscription. Exigence légale (art. L34-5 CPCE + RGPD).
- [ ] **Documenter la newsletter dans la politique de confidentialité** — Le traitement "newsletter" n'est pas mentionné dans la politique actuelle.
- [ ] **Rendre le formulaire de contact fonctionnel** — Le formulaire simule un envoi (action="#"). Connecter à Formspree, Resend ou au backend Laravel.

---

## Priorité IMPORTANTE — Sous 2 semaines

- [ ] **Vérifier et corriger l'hébergeur dans les mentions légales** — Les mentions indiquent OVHcloud mais le site est hébergé sur Vercel.
- [ ] **Ajouter le capital social dans les mentions légales** — Obligation LCEN pour les sociétés commerciales.
- [ ] **Ajouter un numéro de téléphone dans les mentions légales** — La LCEN exige un moyen de contact rapide et direct.
- [ ] **Ajouter le numéro TVA intracommunautaire** — Obligatoire si assujetti à la TVA.
- [ ] **Choisir et intégrer l'outil analytics** — Plausible recommandé (hébergé UE, pas de cookies, exemption CNIL). Sinon GA4 avec Consent Mode v2.
- [ ] **Mettre à jour la politique de confidentialité** — Refléter l'outil analytics réellement utilisé (pas celui décrit mais non installé).
- [ ] **Ajouter le droit de retrait du consentement** — Art. 7.3 RGPD, manquant dans la politique actuelle.
- [ ] **Ajouter le droit aux directives post-mortem** — Loi Informatique et Libertés art. 85, spécifique au droit français.
- [ ] **Ajouter un lien "En savoir plus" dans le bandeau cookies** — Pointant vers la politique de confidentialité, avant le choix de l'utilisateur.
- [ ] **Corriger la mention "chiffrement" sur le formulaire RGPD** — Ne pas afficher "Votre demande sera chiffrée" si le chiffrement n'est pas effectif. Reformuler en "transmise de manière sécurisée via HTTPS".

---

## Priorité RECOMMANDÉE — Sous 1 mois

- [ ] **Créer le registre des traitements** — Document interne (fichier `registre_traitements.md` fourni dans ce dossier). À compléter avec les informations spécifiques.
- [ ] **Implémenter la procédure d'exercice des droits** — Document `procedure_droits_personnes.md` fourni. À diffuser en interne.
- [ ] **Ajouter un mécanisme anti-spam sur les formulaires** — Honeypot field (invisible, simple) ou hCaptcha / Cloudflare Turnstile.
- [ ] **Mettre en place le double opt-in pour la newsletter** — Email de confirmation avant inscription effective. Bonne pratique recommandée.
- [ ] **Créer une page /politique-cookies dédiée** — Page autonome listant tous les cookies, leurs finalités et durées. Recommandation CNIL.
- [ ] **Documenter les sous-traitants** — Lister les DPA (Data Processing Agreements) signés avec chaque prestataire (Vercel, Formspree/Resend, Plausible).
- [ ] **Mettre en place une procédure de notification de violation** — Modèle de notification CNIL + registre des violations. Délai légal : 72h.
- [ ] **Programmer un audit RGPD annuel** — Vérifier la conformité des traitements, mettre à jour le registre et la politique.

---

## Conformité technique

- [ ] **HTTPS activé sur l'ensemble du site** — Vérifier le certificat SSL sur neogtb.fr et neogtb.com.
- [ ] **Cookie de consentement : durée 13 mois max** — Vérifier que `neogtb_consent` expire bien après 395 jours.
- [ ] **Aucun cookie non essentiel avant consentement** — Vérifier qu'aucun script analytics ne se charge avant acceptation.
- [ ] **Boutons Accepter/Refuser d'égale proéminence** — Conformité CNIL : le refus doit être aussi facile que l'acceptation.
- [ ] **Possibilité de modifier son consentement** — Vérifier que le bouton "Gérer les cookies" dans le footer fonctionne.

---

## Documents du dossier RGPD

| Document | Statut | Fichier |
|----------|--------|---------|
| Registre des traitements | Fourni | `registre_traitements.md` |
| Politique de confidentialité | Fourni | `politique_confidentialite.md` |
| Mentions légales | Fourni | `mentions_legales.md` |
| Procédure droits des personnes | Fourni | `procedure_droits_personnes.md` |
| Checklist conformité | Ce document | `checklist_conformite.md` |

---

*Cette checklist doit être revue trimestriellement et mise à jour après chaque modification significative des traitements de données.*
