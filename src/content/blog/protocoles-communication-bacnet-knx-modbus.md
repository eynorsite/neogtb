---
title: "BACnet, KNX, Modbus : les protocoles de la GTB expliqués"
description: "Guide complet des protocoles de communication utilisés en GTB : BACnet, KNX, Modbus et LON. Avantages, inconvénients et cas d'usage."
date: "2026-03-09"
author: "NeoGTB"
category: "Technologies"
tags: []
featured: false
---

Les protocoles de communication sont le **langage** que parlent les équipements d'un bâtiment intelligent.

BACnet — Le standard international
----------------------------------

**BACnet** (Building Automation and Control Networks) est LE protocole de référence pour la GTB.

- **Norme** : ISO 16484-5, ASHRAE 135
- **Médias** : Ethernet/IP, MS/TP (RS-485), LonTalk, ZigBee
- **Avantages** : standard ouvert, interopérabilité, riche en fonctionnalités, évolutif (BACnet/SC)
- **Cas d'usage** : grands bâtiments tertiaires, projets multi-lots

KNX — Le standard européen
--------------------------

**KNX** est le protocole dominant en Europe pour l'automatisation résidentielle et tertiaire.

- **Norme** : EN 50090, ISO/IEC 14543
- **Médias** : paire torsadée, courant porteur, radio, IP
- **Avantages** : très fiable, installation simple (bus 2 fils), 500+ fabricants certifiés
- **Cas d'usage** : éclairage, stores, CVC résidentiel, bâtiments tertiaires moyens

Modbus — Le vétéran robuste
---------------------------

**Modbus** est le protocole industriel le plus répandu au monde.

- **Créé** : 1979 par Modicon (Schneider Electric)
- **Variantes** : RTU (série), ASCII (série), TCP/IP (réseau)
- **Avantages** : extrêmement simple, très robuste, compatible partout, gratuit
- **Cas d'usage** : compteurs d'énergie, variateurs de vitesse, automates industriels

LON — L'intelligence distribuée
-------------------------------

**LonWorks** est un protocole où chaque nœud possède sa propre intelligence.

- **Norme** : EN 14908
- **Avantages** : très haute fiabilité, intelligence distribuée
- **Cas d'usage** : grandes installations, infrastructures critiques (aéroports, hôpitaux)

Quel protocole choisir ?
------------------------

CritèreBACnetKNXModbusLON**GTB complète**★★★★★★★★★**Éclairage**★★★★★★★★**Comptage**★★★★★★★**Interopérabilité**★★★★★★★★★★**Coût**★★★★★★★★La tendance : l'IP et l'IoT
---------------------------

Les protocoles convergent vers l'**IP** (BACnet/IP, KNXnet/IP, Modbus TCP/IP). Les protocoles **IoT** (LoRaWAN, Zigbee, EnOcean, Thread/Matter) complètent le maillage pour les capteurs sans fil.

*Découvrez quelle solution est adaptée à votre bâtiment avec notre [audit gratuit](/audit).*