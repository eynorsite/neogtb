# Procédure de traitement des demandes d'exercice de droits RGPD

**Document interne — NeoGTB / EYNOR**
**Version** : 1.0
**Date** : 24 mars 2026
**Responsable** : Ulrich CALMO, Gérant

---

## 1. Canaux de réception des demandes

Les demandes d'exercice de droits peuvent arriver par :

| Canal | Adresse |
|-------|---------|
| **Email RGPD** | rgpd@neogtb.fr |
| **Formulaire en ligne** | neogtb.fr/mes-droits-rgpd |
| **Courrier postal** | EYNOR — NeoGTB, [À COMPLÉTER], 33320 Eysines |
| **Email général** | contact@neogtb.fr (si le demandeur utilise cette adresse) |

Toute demande reçue sur contact@neogtb.fr et relevant du RGPD doit être transférée immédiatement vers rgpd@neogtb.fr.

---

## 2. Délais légaux

| Étape | Délai |
|-------|-------|
| **Accusé de réception** | 48h ouvrées maximum |
| **Réponse complète** | 1 mois à compter de la réception |
| **Prolongation si complexe** | +2 mois (informer le demandeur dans le délai initial d'un mois) |

Le délai court à compter de la réception de la demande complète (identité vérifiée si nécessaire).

---

## 3. Vérification de l'identité

Avant de traiter une demande, il est nécessaire de s'assurer que le demandeur est bien la personne concernée.

### Cas où la vérification est suffisante :
- La demande provient de l'adresse email déjà connue dans nos systèmes
- Le demandeur fournit des informations cohérentes (nom + email correspondant à nos fichiers)

### Cas où un justificatif est nécessaire :
- Demande provenant d'une adresse email inconnue
- Demande portant sur un volume important de données
- Doute raisonnable sur l'identité

**Justificatif accepté** : copie d'une pièce d'identité (les éléments non nécessaires peuvent être masqués par le demandeur).

**Important** : Le justificatif d'identité doit être supprimé dès que la vérification est effectuée. Ne pas le conserver au-delà.

---

## 4. Traitement par type de droit

### 4.1 Droit d'accès (art. 15)

1. Identifier toutes les données détenues sur la personne
2. Préparer une copie dans un format lisible (PDF ou tableau)
3. Inclure : les données, les finalités, les destinataires, les durées de conservation
4. Envoyer par email sécurisé

### 4.2 Droit de rectification (art. 16)

1. Identifier les données à corriger
2. Effectuer la modification dans tous les systèmes concernés
3. Confirmer au demandeur que la rectification a été effectuée

### 4.3 Droit à l'effacement (art. 17)

1. Vérifier qu'aucune obligation légale n'impose la conservation
2. Supprimer les données de tous les systèmes (formulaires, emails, backups accessibles)
3. Confirmer la suppression au demandeur
4. Si suppression impossible (obligation légale), expliquer le motif

### 4.4 Droit à la limitation (art. 18)

1. Marquer les données concernées comme "limitées"
2. Cesser tout traitement autre que la conservation
3. Informer le demandeur avant toute levée de la limitation

### 4.5 Droit à la portabilité (art. 20)

1. Extraire les données fournies par la personne
2. Les transmettre dans un format structuré, couramment utilisé et lisible par machine (CSV, JSON)
3. Si demandé, transmettre directement à un autre responsable de traitement

### 4.6 Droit d'opposition (art. 21)

1. Cesser le traitement concerné (notamment : newsletter, prospection)
2. Si opposition au traitement fondé sur l'intérêt légitime : évaluer si des motifs légitimes et impérieux prévalent
3. Confirmer la prise en compte

### 4.7 Retrait du consentement (art. 7.3)

1. Retirer la personne du traitement concerné (newsletter, analytics si applicable)
2. Confirmer que le retrait est effectif
3. Conserver la preuve que le consentement initial existait (pour les traitements déjà effectués)

---

## 5. Templates de réponse email

### 5.1 Accusé de réception

```
Objet : Confirmation de réception — Demande RGPD

Bonjour [Prénom],

Nous avons bien reçu votre demande de [type de droit] du [date].

Conformément au RGPD, nous traiterons votre demande dans un délai maximum de 30 jours.

Si nous avons besoin d'informations complémentaires pour vérifier votre identité, nous vous recontacterons dans les meilleurs délais.

Cordialement,
Ulrich CALMO
NeoGTB — EYNOR
rgpd@neogtb.fr
```

### 5.2 Réponse — Droit d'accès

```
Objet : Réponse à votre demande d'accès — RGPD

Bonjour [Prénom],

Suite à votre demande du [date], vous trouverez ci-joint l'ensemble des données personnelles que nous détenons vous concernant.

Détail des traitements :
- [Traitement 1] : [données]
- [Traitement 2] : [données]

Ces données sont conservées pour une durée de [durée] et sont traitées sur la base de [base légale].

Si vous souhaitez exercer un autre droit (rectification, suppression, portabilité), n'hésitez pas à nous écrire.

Cordialement,
Ulrich CALMO
NeoGTB — EYNOR
rgpd@neogtb.fr
```

### 5.3 Réponse — Droit à l'effacement (accepté)

```
Objet : Confirmation de suppression — RGPD

Bonjour [Prénom],

Suite à votre demande du [date], nous confirmons la suppression de l'ensemble de vos données personnelles de nos systèmes.

Les données supprimées concernaient :
- [Liste des données supprimées]

Cette suppression est définitive et effective à la date de ce courrier.

Cordialement,
Ulrich CALMO
NeoGTB — EYNOR
rgpd@neogtb.fr
```

### 5.4 Réponse — Droit à l'effacement (refusé)

```
Objet : Réponse à votre demande de suppression — RGPD

Bonjour [Prénom],

Suite à votre demande du [date], nous ne sommes pas en mesure de procéder à la suppression de [certaines données] pour le motif suivant :

[Obligation légale de conservation / Exercice de droits en justice / Autre motif légitime]

Les données concernées seront conservées jusqu'au [date d'expiration de l'obligation], puis supprimées.

Si vous souhaitez contester cette décision, vous pouvez introduire une réclamation auprès de la CNIL (www.cnil.fr).

Cordialement,
Ulrich CALMO
NeoGTB — EYNOR
rgpd@neogtb.fr
```

### 5.5 Demande de vérification d'identité

```
Objet : Vérification d'identité — Demande RGPD

Bonjour [Prénom],

Nous avons bien reçu votre demande de [type de droit].

Afin de protéger vos données et de nous assurer de votre identité, pourriez-vous nous transmettre une copie d'une pièce d'identité ? Vous pouvez masquer les éléments non nécessaires (photo, numéro de document).

Ce justificatif sera supprimé dès la vérification effectuée et ne sera pas conservé.

Cordialement,
Ulrich CALMO
NeoGTB — EYNOR
rgpd@neogtb.fr
```

---

## 6. Registre des demandes

Chaque demande traitée doit être consignée dans un registre interne contenant :

| Champ | Description |
|-------|------------|
| Date de réception | Date à laquelle la demande a été reçue |
| Identité du demandeur | Nom et email |
| Type de droit exercé | Accès, rectification, effacement, etc. |
| Date de réponse | Date à laquelle la réponse a été envoyée |
| Action effectuée | Description de ce qui a été fait |
| Observations | Difficultés, refus motivé, prolongation |

Ce registre est conservé pendant 5 ans à des fins de preuve de conformité.

---

## 7. Cas particuliers

### Demande d'un tiers (avocat, employeur)
- Exiger une procuration écrite signée par la personne concernée
- Vérifier l'identité du mandataire et du mandant

### Demande manifestement excessive ou infondée (art. 12.5)
- Possibilité de refuser ou de facturer des frais raisonnables
- Motiver le refus par écrit
- Informer le demandeur de son droit de réclamation auprès de la CNIL

### Violation de données (art. 33-34)
En cas de violation de données personnelles :
1. Évaluer le risque pour les personnes concernées
2. Si risque : notifier la CNIL dans les 72 heures (teleservice.cnil.fr)
3. Si risque élevé : informer les personnes concernées sans délai
4. Documenter l'incident dans le registre des violations

---

*Document interne — Ne pas publier sur le site. À conserver et mettre à jour régulièrement.*
