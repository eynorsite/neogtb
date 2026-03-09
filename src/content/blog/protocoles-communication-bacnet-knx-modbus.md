---
title: "BACnet, KNX, Modbus : les protocoles de la GTB expliqués"
description: "Guide complet des protocoles de communication utilisés en GTB : BACnet, KNX, Modbus et LON. Avantages, inconvénients et cas d'usage."
date: "2026-03-07"
author: "NeoGTB"
category: "Technique"
tags: ["BACnet", "KNX", "Modbus", "protocoles", "IoT"]
---

# BACnet, KNX, Modbus : les protocoles de la GTB expliqués

Les protocoles de communication sont le **langage** que parlent les équipements d'un bâtiment intelligent. Comprendre ces protocoles est essentiel pour concevoir, installer et maintenir un système GTB performant.

## BACnet — Le standard international

**BACnet** (*Building Automation and Control Networks*) est LE protocole de référence pour la GTB.

### Caractéristiques
- **Norme** : ISO 16484-5, ASHRAE 135
- **Médias** : Ethernet/IP, MS/TP (RS-485), LonTalk, ZigBee
- **Topologie** : Client/Serveur
- **Objets** : Entrées analogiques/binaires, sorties, valeurs, programmes

### Avantages
- Standard ouvert et international
- Interopérabilité entre constructeurs
- Riche en fonctionnalités (alarmes, historiques, schedules)
- Évolutif (BACnet/SC pour la cybersécurité)

### Cas d'usage
Idéal pour les **grands bâtiments tertiaires** et les projets multi-lots nécessitant une interopérabilité maximale.

## KNX — Le standard européen

**KNX** est le protocole dominant en Europe pour l'automatisation du bâtiment résidentiel et tertiaire.

### Caractéristiques
- **Norme** : EN 50090, ISO/IEC 14543
- **Médias** : Paire torsadée (TP), courant porteur (PL), radio (RF), IP
- **Topologie** : Bus distribué
- **Communauté** : Plus de 500 fabricants certifiés

### Avantages
- Très fiable (intelligence distribuée)
- Installation simple (bus 2 fils)
- Énorme catalogue de produits compatibles
- Pas besoin de serveur central

### Cas d'usage
Parfait pour l'**éclairage**, les **stores**, le **CVC résidentiel** et les bâtiments tertiaires de taille moyenne.

## Modbus — Le vétéran robuste

**Modbus** est le protocole industriel le plus répandu au monde, largement utilisé en GTB pour les compteurs et équipements techniques.

### Caractéristiques
- **Créé** : 1979 par Modicon (Schneider Electric)
- **Variantes** : RTU (série), ASCII (série), TCP/IP (réseau)
- **Topologie** : Maître/Esclave
- **Registres** : Coils, Discrete Inputs, Holding Registers, Input Registers

### Avantages
- Extrêmement simple à implémenter
- Très robuste et éprouvé
- Compatible avec la quasi-totalité des équipements
- Gratuit et ouvert

### Cas d'usage
Incontournable pour les **compteurs d'énergie**, les **variateurs de vitesse**, les **automates industriels** et les équipements CVC.

## LON — L'intelligence distribuée

**LonWorks** est un protocole de réseau de contrôle où chaque nœud possède sa propre intelligence.

### Caractéristiques
- **Norme** : EN 14908 (ISO/IEC 14908)
- **Créé** : 1988 par Echelon Corporation
- **Topologie** : Peer-to-peer distribué
- **Puce** : Neuron Chip (intelligence locale)

### Avantages
- Très haute fiabilité (pas de point unique de défaillance)
- Intelligence distribuée
- Adapté aux très grandes installations

### Cas d'usage
Grandes installations tertiaires et industrielles, infrastructures critiques (aéroports, hôpitaux).

## Quel protocole choisir ?

| Critère | BACnet | KNX | Modbus | LON |
|---------|--------|-----|--------|-----|
| **GTB complète** | ★★★ | ★★ | ★ | ★★★ |
| **Éclairage** | ★★ | ★★★ | ★ | ★★ |
| **Comptage** | ★★ | ★ | ★★★ | ★ |
| **Interopérabilité** | ★★★ | ★★★ | ★★ | ★★ |
| **Coût** | ★★ | ★★ | ★★★ | ★ |
| **Simplicité** | ★★ | ★★ | ★★★ | ★ |

## La tendance : l'IP et l'IoT

Les protocoles traditionnels convergent vers l'**IP** :
- **BACnet/IP** et **BACnet/SC** (Secure Connect)
- **KNXnet/IP**
- **Modbus TCP/IP**

Parallèlement, les protocoles **IoT** (LoRaWAN, Zigbee, EnOcean, Thread/Matter) viennent compléter le maillage pour les capteurs sans fil.

---

*Découvrez quelle solution technologique est adaptée à votre bâtiment avec notre [audit gratuit](/audit).*
