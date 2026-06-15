# POC EMS NeoGTB — « Vos consommations en temps réel »

Preuve de concept d'un **Energy Management System** minimal, montable en quelques minutes
pour une **démo commerciale** : un compteur → une donnée → un tableau de bord temps réel.

> ⚠️ **C'est une démo, pas un produit.** Voir la section [Ce que ça montre / ne montre pas](#ce-que-ça-montre--ne-montre-pas).
> L'écart entre ce POC et un EMS d'exploitation (fiabilité, multi-protocole, sécurité OT,
> conformité) est volontairement assumé.

---

## Architecture

```
  [ Source de données ]          [ Acquisition ]      [ Stockage ]       [ Visualisation ]
                                                                          
  A1 · Données simulées  ─────►   Telegraf      ─────►  InfluxDB 2.7  ─────►  Grafana
       (par défaut)               (inputs.mock)         (time-series)        (dashboards)
                                                                                  │
  A2/B · Compteur Modbus ─ ─ ─►   Telegraf                                        ▼
       (réel, optionnel)          (inputs.modbus)                          http://localhost:3000
```

100 % open-source, tout en conteneurs Docker. Aucun matériel requis pour la démo par défaut.

| Composant | Image | Rôle |
|---|---|---|
| **InfluxDB** | `influxdb:2.7` | Base de données time-series (stockage des mesures) |
| **Telegraf** | `telegraf:1.30` | Agent de collecte (simulé par défaut, ou Modbus réel) |
| **Grafana** | `grafana/grafana-oss:11.1.0` | Dashboards temps réel |

> Versions épinglées pour la reproductibilité. Ne pas utiliser le tag `latest`
> (le `latest` d'InfluxDB bascule vers la v3, incompatible avec ce POC).

---

## Démarrage rapide

Prérequis : Docker + Docker Compose.

```bash
cd poc-ems
cp .env.example .env          # puis changez les secrets si besoin
docker compose up -d          # télécharge les images et démarre les 3 services
```

Puis ouvrez **http://localhost:3000**
- identifiant / mot de passe : `admin` / `neogtb-poc-2026` (valeurs du `.env`)
- le dashboard **« POC EMS — Consommations temps réel »** est déjà provisionné.

Comptez ~30 s après le `up` pour voir les premiers points (le temps qu'InfluxDB s'initialise
et que Telegraf pousse ses premières mesures, toutes les 5 s).

Arrêt : `docker compose down`
Remise à zéro complète (efface les données) : `docker compose down -v`

---

## Vérifier que tout marche

```bash
docker compose ps           # les 3 services doivent être "running" (influxdb "healthy")
docker compose logs -f telegraf   # doit afficher des écritures vers InfluxDB sans erreur
```

Dans Grafana, la courbe « Puissance active instantanée » doit défiler en continu.

---

## Brancher un compteur réel (scénario A2 / B)

La démo simule les données. Pour lire un **vrai compteur** (ex. Eastron SDM630 en Modbus TCP,
directement ou via une passerelle type Wattsense) :

1. Ouvrez [`telegraf/telegraf.conf`](telegraf/telegraf.conf).
2. **Commentez** le bloc `[[inputs.mock]]` (entrée A1).
3. **Décommentez** le bloc `[[inputs.modbus]]` (entrée A2/B) et renseignez :
   - `controller` = l'IP du compteur ou de la passerelle Modbus TCP ;
   - `slave_id` = l'adresse de l'esclave ;
   - les **adresses de registres**, depuis la **fiche registre de VOTRE compteur**.
4. `docker compose restart telegraf`.

> ⚠️ **Piège n°1 — le mapping Modbus.** Les adresses fournies sont des **exemples** SDM630.
> Elles varient d'un fabricant et d'un modèle à l'autre. Un mauvais mapping affiche des valeurs
> *plausibles mais fausses* — le pire pour une démo d'auditeur. **Validez toujours avec une charge
> connue** (une bouilloire ~2000 W doit afficher ~2000 W ; l'index kWh doit s'incrémenter) avant
> de montrer quoi que ce soit à un client.

---

## Ce que ça montre / ne montre pas

**✅ Ce que la démo prouve**
- La faisabilité de la chaîne : mesure → acquisition → stockage → visualisation temps réel.
- La valeur métier immédiate : voir sa puissance, sa courbe de charge, son index kWh en direct.
- Que NeoGTB maîtrise les briques d'un EMS (time-series, dashboards, Modbus).

**❌ Ce que la démo NE fait PAS (à dire au client, ne pas survendre)**
- **Fiabilité d'exploitation** : pas de haute dispo, ni reprise après coupure réseau.
- **Multi-protocole** : ici un seul flux ; un parc réel mêle BACnet/KNX/M-Bus/LoRaWAN
  (c'est ce qu'absorbe une passerelle du commerce, hors périmètre de ce POC).
- **Sécurité OT** : aucun durcissement. **Ne jamais brancher tel quel sur le réseau d'un client**
  sans VLAN dédié, lecture seule et accord écrit de la DSI.
- **Conformité** : ne produit ni reporting OPERAT, ni preuve de classe EN ISO 52120-1.
- **Métrologie** : un POC mal calibré n'a pas de valeur opposable (facturation → compteurs MID requis).

Formulation honnête suggérée en clientèle :
> « Cette démo prouve que la donnée existe et qu'on sait la rendre lisible. Le passage en
> exploitation suppose sécurisation réseau, fiabilisation, multi-protocole et reporting
> réglementaire — c'est l'objet du pilote / de la phase produit. »

---

## Liste de courses pour passer au compteur réel (indicatif)

| Poste | Exemple | Prix indicatif (à reconfirmer) |
|---|---|---|
| Compteur 3-phasé Modbus | Eastron SDM630-Modbus | ~132 € TTC |
| Convertisseur USB-RS485 | Waveshare USB-to-RS485 | ~15–25 € |
| Mini-PC (hôte Docker) | Beelink N100 ou Raspberry Pi 5 | ~130–250 € |
| (Pilote multi-protocole) | Passerelle Wattsense Bridge | sur devis (ordre de 1 000 €+) |

> Prix indicatifs relevés en juin 2026, **à reconfirmer** par devis/fiche fabricant avant achat.

---

## Structure du projet

```
poc-ems/
├── docker-compose.yml                  # les 3 services
├── .env.example                        # secrets (à copier en .env)
├── telegraf/
│   └── telegraf.conf                   # acquisition (mock par défaut, Modbus en option)
└── grafana/
    ├── provisioning/
    │   ├── datasources/influxdb.yml    # datasource InfluxDB auto-configurée
    │   └── dashboards/dashboards.yml   # chargeur de dashboards
    └── dashboards/
        └── ems-poc.json                # dashboard « Consommations temps réel »
```

## Dépannage

- **Pas de données dans Grafana** : attendez 30 s ; vérifiez `docker compose logs telegraf`
  (erreur de token → le `.env` ne correspond pas à l'init InfluxDB ; faites `docker compose down -v`
  puis `up -d` pour réinitialiser proprement).
- **Datasource en erreur** : le token Grafana est interpolé depuis l'environnement ; assurez-vous
  d'avoir lancé via `docker compose` (et non `docker run`) pour que les variables soient injectées.
- **Port 3000 ou 8086 déjà utilisé** : changez le mapping de ports dans `docker-compose.yml`.
