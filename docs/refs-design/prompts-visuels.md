# Prompts de génération d'images — NeoGTB

Ce document fournit des **prompts prêts à copier** pour générer les photos hero et d'ambiance du site NeoGTB avec **Midjourney v6**, **Flux** ou **DALL·E 3**.

## Esprit recherché

On s'inspire du **style** de smt-en.com (photos d'architecture tertiaire très qualitatives, lumière dramatique de golden hour, lignes courbes, ambiance haut de gamme) **sans copier leurs images ni leurs bâtiments**. La différence majeure : NeoGTB veut une ambiance **CLAIRE, lumineuse et aérée** — pas écrasée de noir comme SMT.

### Identité visuelle à respecter dans chaque prompt

- **Tonalité** : claire, lumineuse, institutionnelle. Mots-clés d'ambiance : *clean, trustworthy, expert, independent, calm*.
- **Palette à évoquer** (en lumière et en touches, pas en aplat) :
  - bleu marine `#1B3A5C` (navy blue)
  - vert `#2D8B4E` (green)
  - touches dorées / ambre chaudes `#F59E0B` (warm amber / golden) dans la lumière
  - dominante de blanc et de lumière naturelle
- **Sujets** : architecture tertiaire (bureaux, écoles, hôpitaux, collectivités), façades vitrées, halls, toitures avec équipements techniques (CTA / centrales de traitement d'air), salles techniques GTB propres, capteurs, écrans de supervision, bâtiments « intelligents ».
- **Style photo** : photoréaliste, haute qualité, lumière naturelle douce de golden hour mais image **claire**, profondeur de champ maîtrisée, **espace négatif** préservé pour poser un titre en overlay sur les hero.

### Contraintes RGPD / juridiques (NON NÉGOCIABLES)

- **Aucun visage reconnaissable**, aucune personne identifiable. Silhouettes lointaines et floues tolérées seulement si indispensable, à éviter par défaut.
- **Aucune marque, aucun logo, aucun texte de marque** visible (façades, écrans, vêtements, panneaux).
- **Aucun écran affichant une marque réelle** : les tableaux de bord doivent rester génériques/abstraits.
- **Pas de plagiat** d'un bâtiment réel identifiable.

---

## Tableau récapitulatif des emplacements

| # | Emplacement | Fichier cible | Ratio / dimensions | Sujet |
|---|-------------|---------------|--------------------|-------|
| 1 | Hero accueil | `admin/public/images/hero-neogtb.webp` | 16:9 — 1600×900 | Bâtiment tertiaire intelligent, espace à gauche pour titre |
| 2 | Hero « Nos offres » | `admin/public/images/hero-offres.webp` | ~8:3 — 1600×600 | Bandeau large, façade panoramique, titre centré |
| 3 | Hero GTB | `admin/public/images/hero-gtb.webp` | 16:9 — 1600×900 | Salle de supervision claire + façade |
| 4 | Hero GTC | `admin/public/images/hero-gtc.webp` | 16:9 — 1600×900 | Chaufferie / local CVC propre et lumineux |
| 5 | Hero Solutions / Technologies | `admin/public/images/hero-solutions.webp` | 16:9 — 1600×900 | Capteurs, automates, protocoles |
| 6 | Hero Audit / Pré-diagnostic | `admin/public/images/hero-audit.webp` | 16:9 — 1600×900 | Bâtiment + relevé technique sur site |
| 7 | Hero Réglementation / Décret BACS | `admin/public/images/hero-reglementation.webp` | 16:9 — 1600×900 | Bâtiment public / officiel, sérieux institutionnel |
| 8 | Hero À propos | `admin/public/images/hero-about.webp` | 16:9 — 1600×900 | Bureau lumineux épuré, expertise indépendante |
| 9 | Ambiance — Salle technique GTB | `admin/public/images/ambiance/salle-technique.webp` | 3:2 — 1200×800 | Local technique GTB propre et rangé |
| 10 | Ambiance — Capteurs / IoT | `admin/public/images/ambiance/capteurs-iot.webp` | 3:2 — 1200×800 | Capteurs intelligents dans le bâtiment |
| 11 | Ambiance — Tableau de bord énergétique | `admin/public/images/ambiance/dashboard-energie.webp` | 3:2 — 1200×800 | Écran de supervision énergétique sans marque |

> Le dossier `admin/public/images/ambiance/` est à créer avant import des 3 images d'ambiance.

---

## Prompt de base réutilisable (style anchor)

À combiner avec le sujet de chaque emplacement. Il porte le style commun NeoGTB.

```
photorealistic architectural photography of a modern French tertiary building, bright and airy daylight, soft golden hour light, clean institutional and trustworthy mood, light and luminous atmosphere (NOT dark, NOT moody), abundant natural white light, subtle navy blue (#1B3A5C) and green (#2D8B4E) tones with warm amber (#F59E0B) light accents, curved lines and elegant glass facades, shallow depth of field, high-end real estate quality, generous negative space for text overlay, no people, no faces, no brand, no logo, no readable text, 8k, ultra detailed
```

### Negative prompt commun (Midjourney `--no` / Flux negative / à éviter en DALL·E)

```
dark, moody, low-key, gloomy, night, people, person, human, face, faces, crowd, logo, brand, signage, watermark, text, lettering, captions, ui mockup with brand, distorted, deformed, blurry, low resolution, lowres, oversaturated, HDR halos, fisheye, cartoon, illustration, 3d render look, cluttered, dirty, messy
```

---

## 1. Hero accueil — `hero-neogtb.webp` (16:9, 1600×900)

> Cadrage : sujet décalé à droite, **grand espace négatif clair à gauche** (le hero pose le titre à gauche avec un léger dégradé sombre→clair).

**Midjourney**
```
photorealistic architectural photography, modern intelligent tertiary office building in France, elegant curved glass facade catching soft golden hour light, bright airy luminous atmosphere, clean institutional trustworthy mood, subtle navy and green tones with warm amber light accents, building positioned to the right side, wide empty bright sky and negative space on the left for text, shallow depth of field, high-end architectural quality, no people, no logo, no text --ar 16:9 --style raw --v 6 --no dark, people, faces, logo, text, watermark, distorted, lowres
```

**Flux**
```
A photorealistic wide architectural shot of a modern intelligent tertiary office building in France with an elegant curved glass facade, lit by soft bright golden hour daylight, very luminous and airy atmosphere, clean institutional and trustworthy feeling, subtle navy blue and green tones with warm amber light accents on the glass. The building sits on the right third of the frame, leaving a large bright area of sky and soft negative space on the left for a headline overlay. Shallow depth of field, high-end real estate photography, no people, no visible brand or text, 8k.
```

**DALL·E 3**
```
A bright, airy photorealistic architectural photograph of a modern intelligent office building in France with a curved glass facade glowing in soft golden-hour light. The mood is clean, institutional and trustworthy, with subtle navy-blue and green tones and warm amber light reflections. Place the building on the right side of the image and leave generous empty bright sky and negative space on the left so a headline can be added later. Shallow depth of field, high-end look, no people, no faces, no brand, no logo, no text.
```

---

## 2. Hero « Nos offres » — `hero-offres.webp` (~8:3, 1600×600)

> Cadrage : **bandeau large panoramique**, sujet équilibré, **espace négatif au centre/ciel** pour un titre centré.

**Midjourney**
```
panoramic photorealistic architectural photography, sweeping modern tertiary district facade in France, long curved glass building catching warm golden hour light, bright airy luminous clean institutional mood, subtle navy and green tones with amber light accents, very wide cinematic banner composition, open bright sky in upper center for a centered title, shallow depth of field, high-end quality, no people, no logo, no text --ar 8:3 --style raw --v 6 --no dark, people, faces, logo, text, watermark, distorted, lowres
```

**Flux**
```
An ultra-wide panoramic photorealistic banner of a sweeping modern tertiary district facade in France, a long curved glass building bathed in warm bright golden hour light, very luminous airy and clean institutional atmosphere, subtle navy blue and green tones with amber light accents. Cinematic horizontal banner composition with open bright sky across the upper center, leaving room for a centered headline. Shallow depth of field, high-end architectural photography, no people, no brand, no logo, no text.
```

**DALL·E 3**
```
A very wide panoramic photorealistic banner photograph of a sweeping modern glass tertiary building facade in France lit by warm, bright golden-hour light. Luminous, airy, clean and institutional mood with subtle navy-blue and green tones and amber light accents. Compose it as a wide cinematic banner with open bright sky in the upper-center area so a centered title can be placed there. Shallow depth of field, high-end look, no people, no faces, no brand, no logo, no text.
```

---

## 3. Hero GTB — `hero-gtb.webp` (16:9, 1600×900)

> Sujet : **salle de supervision claire** ouverte sur une façade vitrée (lien GTB ↔ bâtiment piloté).

**Midjourney**
```
photorealistic interior architectural photography, clean modern building management supervision room, large generic monitoring screens showing abstract energy graphs with no brand, big bright glass wall opening on a modern tertiary facade in golden hour light, luminous airy institutional atmosphere, subtle navy and green tones with amber light accents, polished minimalist tech space, negative space on one side for a title, shallow depth of field, no people, no logo, no readable text --ar 16:9 --style raw --v 6 --no dark, people, faces, logo, brand text, watermark, distorted, lowres
```

**Flux**
```
A photorealistic interior shot of a clean modern building management (BMS) supervision room: large generic monitoring screens displaying abstract energy graphs with absolutely no brand or readable text, a big bright glass wall opening onto a modern tertiary facade in golden hour light. Luminous, airy, institutional atmosphere, subtle navy blue and green tones with warm amber light accents, polished minimalist tech space, negative space on one side for a headline. Shallow depth of field, no people, no logo, no readable text, 8k.
```

**DALL·E 3**
```
A bright photorealistic interior photograph of a clean, modern building-management supervision room. Large generic monitoring screens show abstract energy graphs with no brand or readable text. A big glass wall opens onto a modern building facade in soft golden-hour light. Luminous, airy and institutional mood, subtle navy-blue and green tones with warm amber light accents, polished minimalist tech space. Leave negative space on one side for a title. Shallow depth of field, no people, no faces, no brand, no logo, no readable text.
```

---

## 4. Hero GTC — `hero-gtc.webp` (16:9, 1600×900)

> Sujet : **local technique CVC / chaufferie propre** et lumineux (gestion technique centralisée des équipements).

**Midjourney**
```
photorealistic photography of a clean bright modern HVAC plant room in a tertiary building, neatly arranged air handling units and insulated pipes, spotless technical space, bright artificial and natural light, luminous airy institutional mood, subtle navy and green tones with warm amber light accents, organized professional engineering quality, negative space for a title, shallow depth of field, no people, no logo, no text --ar 16:9 --style raw --v 6 --no dark, dirty, messy, people, faces, logo, text, watermark, distorted, lowres
```

**Flux**
```
A photorealistic photograph of a clean, bright, modern HVAC plant room in a tertiary building, with neatly arranged air handling units and insulated pipes, a spotless and organized technical space lit by a mix of bright artificial and natural light. Luminous, airy, institutional mood, subtle navy blue and green tones with warm amber light accents, professional engineering quality. Leave negative space for a headline. Shallow depth of field, no people, no brand, no logo, no text, 8k.
```

**DALL·E 3**
```
A bright, clean photorealistic photograph of a modern HVAC plant room (chaufferie) inside a tertiary building, with neatly arranged air-handling units and insulated pipes. The technical space is spotless, organized and well lit with bright natural and artificial light. Luminous, airy and institutional mood, subtle navy-blue and green tones with warm amber light accents, professional engineering quality. Leave some negative space for a title. Shallow depth of field, no people, no faces, no brand, no logo, no text.
```

---

## 5. Hero Solutions / Technologies — `hero-solutions.webp` (16:9, 1600×900)

> Sujet : **capteurs, automates et protocoles** — détail technologique propre et moderne.

**Midjourney**
```
photorealistic macro and mid-shot photography of modern building automation hardware, sleek wall-mounted IoT sensors and clean DIN-rail automation controllers without any brand, fine network cabling, bright minimalist white technical wall, luminous airy institutional mood, subtle navy and green tones with warm amber light accents, high-tech precision feel, negative space for a title, shallow depth of field, no people, no logo, no text --ar 16:9 --style raw --v 6 --no dark, people, faces, logo, brand text, watermark, distorted, lowres
```

**Flux**
```
A photorealistic close-to-mid shot of modern building automation hardware: sleek wall-mounted IoT sensors and clean DIN-rail automation controllers with no brand at all, fine network cabling, on a bright minimalist white technical wall. Luminous, airy, institutional mood, subtle navy blue and green tones with warm amber light accents, a high-tech precise feeling. Leave negative space for a headline. Shallow depth of field, no people, no logo, no readable text, 8k.
```

**DALL·E 3**
```
A bright photorealistic photograph of modern building-automation hardware: sleek wall-mounted IoT sensors and clean rail-mounted automation controllers with no brand, plus tidy network cabling, on a minimalist white technical wall. Luminous, airy and institutional mood, subtle navy-blue and green tones with warm amber light accents, a high-tech precise feeling. Leave negative space for a title. Shallow depth of field, no people, no faces, no brand, no logo, no text.
```

---

## 6. Hero Audit / Pré-diagnostic — `hero-audit.webp` (16:9, 1600×900)

> Sujet : **relevé technique sur site** — toiture avec équipements (CTA) et bâtiment, geste d'audit suggéré (tablette/plan, sans visage).

**Midjourney**
```
photorealistic photography of a rooftop technical inspection scene on a modern tertiary building, clean air handling units and ducts on a bright rooftop, a generic digital tablet on a ledge showing abstract data with no brand, modern glass facade behind in soft golden hour light, luminous airy institutional mood, subtle navy and green tones with warm amber light accents, professional audit feeling, negative space for a title, shallow depth of field, no people, no faces, no logo, no text --ar 16:9 --style raw --v 6 --no dark, people, faces, logo, brand text, watermark, distorted, lowres
```

**Flux**
```
A photorealistic photograph of a rooftop technical inspection on a modern tertiary building: clean air-handling units and ducts on a bright rooftop, a generic digital tablet resting on a ledge showing abstract data with no brand, a modern glass facade behind in soft golden hour light. Luminous, airy, institutional mood, subtle navy blue and green tones with warm amber light accents, a professional audit feeling. Leave negative space for a headline. Shallow depth of field, no people, no logo, no readable text, 8k.
```

**DALL·E 3**
```
A bright photorealistic photograph of a rooftop technical inspection on a modern tertiary building: clean air-handling units and ducts on a sunny rooftop, with a generic digital tablet resting on a ledge showing abstract data and no brand. A modern glass facade rises behind in soft golden-hour light. Luminous, airy and institutional mood, subtle navy-blue and green tones with warm amber light accents, a professional audit feeling. Leave negative space for a title. Shallow depth of field, no people, no faces, no brand, no logo, no text.
```

---

## 7. Hero Réglementation / Décret BACS — `hero-reglementation.webp` (16:9, 1600×900)

> Sujet : **bâtiment public / officiel** (collectivité, administration) — sérieux institutionnel et conformité.

**Midjourney**
```
photorealistic architectural photography of a dignified modern French public institutional building, clean official architecture with columns or large bright glass entrance, calm bright daylight with soft golden hour warmth, serious trustworthy institutional and regulatory mood, luminous airy atmosphere, subtle navy and green tones with warm amber light accents, low angle conveying authority, negative space for a title, shallow depth of field, no people, no flags with logo, no text --ar 16:9 --style raw --v 6 --no dark, people, faces, logo, brand text, signage, watermark, distorted, lowres
```

**Flux**
```
A photorealistic architectural photograph of a dignified modern French public institutional building (a town hall or administration), clean official architecture with columns or a large bright glass entrance, lit by calm bright daylight with a soft golden hour warmth. Serious, trustworthy, institutional and regulatory mood, luminous and airy atmosphere, subtle navy blue and green tones with warm amber light accents, a low angle conveying authority. Leave negative space for a headline. Shallow depth of field, no people, no brand, no logo, no signage, no text, 8k.
```

**DALL·E 3**
```
A bright photorealistic architectural photograph of a dignified modern French public institutional building, such as a town hall or administration, with clean official architecture, columns or a large glass entrance, lit by calm daylight with soft golden-hour warmth. The mood is serious, trustworthy, institutional and regulatory, yet luminous and airy, with subtle navy-blue and green tones and warm amber light accents. Use a slightly low angle to convey authority and leave negative space for a title. Shallow depth of field, no people, no faces, no brand, no logo, no signage, no text.
```

---

## 8. Hero À propos — `hero-about.webp` (16:9, 1600×900)

> Sujet : **bureau lumineux épuré**, expertise indépendante (espace de travail haut de gamme, vide, sans personne).

**Midjourney**
```
photorealistic interior photography of a calm minimalist high-end consulting office, light wood and white surfaces, large bright window with soft golden hour daylight and a blurred city view, a few clean design objects, luminous airy trustworthy independent-expert mood, subtle navy and green tones with warm amber light accents, empty and serene, negative space for a title, shallow depth of field, no people, no logo, no text --ar 16:9 --style raw --v 6 --no dark, clutter, people, faces, logo, text, watermark, distorted, lowres
```

**Flux**
```
A photorealistic interior photograph of a calm, minimalist, high-end consulting office: light wood and white surfaces, a large bright window with soft golden hour daylight and a blurred city view, a few clean design objects. Luminous, airy, trustworthy independent-expert mood, subtle navy blue and green tones with warm amber light accents, empty and serene. Leave negative space for a headline. Shallow depth of field, no people, no logo, no text, 8k.
```

**DALL·E 3**
```
A bright photorealistic interior photograph of a calm, minimalist, high-end consulting office with light wood and white surfaces, a large window letting in soft golden-hour daylight and a blurred city view, and a few clean design objects. The mood is luminous, airy and trustworthy, evoking independent expertise, with subtle navy-blue and green tones and warm amber light accents. Keep it empty and serene and leave negative space for a title. Shallow depth of field, no people, no faces, no brand, no logo, no text.
```

---

## 9. Ambiance — Salle technique GTB — `ambiance/salle-technique.webp` (3:2, 1200×800)

> Pas d'overlay texte : cadrage libre, sujet bien centré.

**Midjourney**
```
photorealistic photography of a spotless modern building management technical room, clean electrical cabinets and tidy automation panels with no brand, neat cable management, bright even lighting, luminous clean institutional mood, subtle navy and green tones with warm amber light accents, professional engineering quality, shallow depth of field, no people, no logo, no text --ar 3:2 --style raw --v 6 --no dark, dirty, messy, people, faces, logo, text, watermark, distorted, lowres
```

**Flux**
```
A photorealistic photograph of a spotless modern building-management technical room: clean electrical cabinets and tidy automation panels with no brand, neat cable management, bright even lighting. Luminous, clean and institutional mood, subtle navy blue and green tones with warm amber light accents, professional engineering quality. Shallow depth of field, no people, no logo, no text, 8k.
```

**DALL·E 3**
```
A bright, clean photorealistic photograph of a spotless modern building-management technical room, with tidy electrical cabinets and automation panels (no brand), neat cable management and even bright lighting. Luminous, clean and institutional mood, subtle navy-blue and green tones with warm amber light accents, professional engineering quality. Shallow depth of field, no people, no faces, no brand, no logo, no text.
```

---

## 10. Ambiance — Capteurs / IoT — `ambiance/capteurs-iot.webp` (3:2, 1200×800)

**Midjourney**
```
photorealistic close-up photography of a sleek modern building IoT sensor mounted on a clean bright wall, soft natural light, subtle glowing indicator, minimalist high-tech design with no brand, luminous airy institutional mood, subtle navy and green tones with warm amber light accents, shallow depth of field with soft bokeh, no people, no logo, no text --ar 3:2 --style raw --v 6 --no dark, people, faces, logo, brand text, watermark, distorted, lowres
```

**Flux**
```
A photorealistic close-up of a sleek modern building IoT sensor mounted on a clean bright wall, lit by soft natural light, with a subtle glowing indicator, minimalist high-tech design and no brand. Luminous, airy, institutional mood, subtle navy blue and green tones with warm amber light accents, shallow depth of field with soft bokeh. No people, no logo, no readable text, 8k.
```

**DALL·E 3**
```
A bright photorealistic close-up of a sleek modern building IoT sensor mounted on a clean wall, lit by soft natural light with a subtle glowing indicator and a minimalist high-tech design with no brand. Luminous, airy and institutional mood, subtle navy-blue and green tones with warm amber light accents, shallow depth of field with soft bokeh. No people, no faces, no brand, no logo, no text.
```

---

## 11. Ambiance — Tableau de bord énergétique — `ambiance/dashboard-energie.webp` (3:2, 1200×800)

> L'écran doit rester **générique** : graphes abstraits, aucune marque, aucun mot lisible.

**Midjourney**
```
photorealistic photography of a modern energy management dashboard on a clean monitor, abstract generic charts and gauges in navy blue, green and amber with no brand and no readable text, bright minimalist desk in soft daylight, luminous airy institutional mood, warm amber light accents, shallow depth of field, no people, no logo, no readable text --ar 3:2 --style raw --v 6 --no dark, people, faces, logo, brand, readable text, words, watermark, distorted, lowres
```

**Flux**
```
A photorealistic photograph of a modern energy-management dashboard on a clean monitor, showing abstract generic charts and gauges in navy blue, green and amber with no brand and no readable text, on a bright minimalist desk in soft daylight. Luminous, airy, institutional mood, warm amber light accents, shallow depth of field. No people, no logo, no readable text, 8k.
```

**DALL·E 3**
```
A bright photorealistic photograph of a modern energy-management dashboard on a clean monitor, displaying abstract generic charts and gauges in navy-blue, green and amber, with no brand and no readable text or words. It sits on a bright minimalist desk in soft daylight. Luminous, airy and institutional mood, warm amber light accents, shallow depth of field. No people, no faces, no brand, no logo, no readable text.
```

---

## Workflow conseillé

1. **Générer en 16:9** (ou 8:3 pour le bandeau offres, 3:2 pour les ambiances) puis recadrer précisément aux dimensions cibles du tableau.
2. **Vérifier la conformité RGPD** sur chaque rendu : aucun visage net, aucune marque/logo, aucun texte lisible, aucun écran de marque, pas de bâtiment réel reconnaissable. Régénérer si un de ces éléments apparaît.
3. **Convertir en `.webp`** et viser **< 200 Ko** par image (qualité ~80, redimensionnement à la taille cible). Outils : `cwebp`, Squoosh, ou un script de build.
4. **Remplacer** le fichier existant dans `admin/public/images/` (créer le dossier `ambiance/` au préalable) en conservant exactement le même nom de fichier.
5. **Renseigner l'alt text** descriptif et sans marque dans l'admin (ex. « Façade vitrée d'un bâtiment tertiaire en lumière douce »).
6. **Hero avec overlay** : valider sur maquette que le titre reste lisible dans la zone d'espace négatif (gauche pour l'accueil, centre pour les offres) ; ajuster le dégradé si besoin.

## Rappel de droits

Avant tout usage commercial, **vérifier la licence de l'outil de génération utilisé** : les conditions de Midjourney, Flux et DALL·E 3 diffèrent et évoluent (droits d'usage commercial, attribution, plans payants requis selon l'usage). Conserver une trace du prompt et de l'outil pour chaque image publiée.
