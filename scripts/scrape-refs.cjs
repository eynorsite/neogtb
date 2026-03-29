/**
 * scrape-refs.js — NEOGTB Design Reference Scraper
 *
 * Visite chaque URL de urls.json, extrait le HTML de la section ciblée
 * + les tokens design (couleurs, fonts, spacing) et les sauvegarde dans /design-refs/
 *
 * Usage (dans Claude Code) :
 *   node scripts/scrape-refs.js
 *   node scripts/scrape-refs.js --target sonet-hero   (un seul site)
 *   node scripts/scrape-refs.js --tokens-only          (juste les tokens CSS)
 *
 * Prérequis :
 *   npm install puppeteer fs-extra chalk
 */

const puppeteer = require('puppeteer');
const fs = require('fs-extra');
const path = require('path');

const URLS_FILE = path.join(__dirname, '../design-refs/urls.json');
const OUTPUT_DIR = path.join(__dirname, '../design-refs');
const TOKENS_FILE = path.join(OUTPUT_DIR, '_tokens-all.json');

const args = process.argv.slice(2);
const targetFilter = args.includes('--target') ? args[args.indexOf('--target') + 1] : null;
const tokensOnly = args.includes('--tokens-only');

async function extractSection(page, selector) {
  return await page.evaluate((sel) => {
    const el = document.querySelector(sel);
    if (!el) return null;

    const clone = el.cloneNode(true);

    // Nettoyer les scripts et iframes
    clone.querySelectorAll('script, iframe, noscript').forEach(n => n.remove());

    // Récupérer les styles computés des éléments clés
    const elements = el.querySelectorAll('*');
    const styles = {};
    const important = ['font-family', 'font-size', 'font-weight', 'color',
                       'background-color', 'padding', 'margin', 'border',
                       'border-radius', 'gap', 'display', 'grid-template-columns',
                       'letter-spacing', 'line-height', 'max-width'];

    elements.forEach((node, i) => {
      if (i > 50) return; // Limiter pour les performances
      const computed = window.getComputedStyle(node);
      const tag = node.tagName.toLowerCase();
      if (['div', 'section', 'nav', 'h1', 'h2', 'h3', 'p', 'a', 'button', 'span'].includes(tag)) {
        const relevantStyles = {};
        important.forEach(prop => {
          const val = computed.getPropertyValue(prop);
          if (val && val !== 'normal' && val !== 'auto' && val !== 'none' && val !== '0px') {
            relevantStyles[prop] = val;
          }
        });
        if (Object.keys(relevantStyles).length > 0) {
          styles[`${tag}[${i}]`] = relevantStyles;
        }
      }
    });

    return {
      html: clone.outerHTML,
      styles,
      dimensions: {
        width: el.offsetWidth,
        height: el.offsetHeight,
      }
    };
  }, selector);
}

async function extractDesignTokens(page, url) {
  return await page.evaluate(() => {
    const tokens = {
      colors: new Set(),
      fonts: new Set(),
      fontSizes: new Set(),
      fontWeights: new Set(),
      borderRadius: new Set(),
      spacing: new Set(),
    };

    document.querySelectorAll('*').forEach(el => {
      const computed = window.getComputedStyle(el);

      const color = computed.color;
      const bg = computed.backgroundColor;
      if (color && color !== 'rgb(0, 0, 0)') tokens.colors.add(color);
      if (bg && bg !== 'rgba(0, 0, 0, 0)' && bg !== 'rgb(255, 255, 255)') tokens.colors.add(bg);

      const font = computed.fontFamily;
      if (font) tokens.fonts.add(font.split(',')[0].replace(/['"]/g, '').trim());

      const size = computed.fontSize;
      if (size && !['0px'].includes(size)) tokens.fontSizes.add(size);

      const weight = computed.fontWeight;
      if (weight) tokens.fontWeights.add(weight);

      const radius = computed.borderRadius;
      if (radius && radius !== '0px') tokens.borderRadius.add(radius);
    });

    // CSS custom properties
    const cssVars = {};
    const sheets = Array.from(document.styleSheets);
    sheets.forEach(sheet => {
      try {
        const rules = Array.from(sheet.cssRules || []);
        rules.forEach(rule => {
          if (rule.selectorText === ':root' || rule.selectorText === 'html') {
            const text = rule.cssText;
            const matches = text.matchAll(/--([\w-]+):\s*([^;]+)/g);
            for (const match of matches) {
              cssVars[`--${match[1]}`] = match[2].trim();
            }
          }
        });
      } catch (e) {}
    });

    return {
      colors: [...tokens.colors].slice(0, 20),
      fonts: [...tokens.fonts],
      fontSizes: [...tokens.fontSizes].sort((a, b) => parseFloat(a) - parseFloat(b)),
      fontWeights: [...tokens.fontWeights],
      borderRadius: [...tokens.borderRadius],
      cssCustomProperties: cssVars,
    };
  });
}

async function formatOutput(target, result, tokens) {
  const timestamp = new Date().toISOString().split('T')[0];

  const comment = `<!--
  SOURCE  : ${target.url}
  SECTION : ${target.selector}
  LABEL   : ${target.label}
  SCRAPED : ${timestamp}

  USAGE POUR CLAUDE CODE :
  Ce fichier contient du HTML réel extrait de ${new URL(target.url).hostname}.
  S'en inspirer pour les patterns, la structure des classes, les proportions.
  Ne pas copier tel quel — adapter au design system NEOGTB.

  TOKENS EXTRAITS :
  Fonts       : ${tokens?.fonts?.slice(0, 3).join(' · ') || 'N/A'}
  Couleurs    : ${tokens?.colors?.slice(0, 4).join(' · ') || 'N/A'}
  Border-r    : ${tokens?.borderRadius?.slice(0, 3).join(' · ') || 'N/A'}
-->

`;

  const stylesBlock = result.styles && Object.keys(result.styles).length > 0
    ? `\n<!-- COMPUTED STYLES (principaux éléments) :
${JSON.stringify(result.styles, null, 2)}
-->\n`
    : '';

  return comment + stylesBlock + result.html;
}

async function scrapeTarget(browser, target) {
  const page = await browser.newPage();

  await page.setViewport({ width: 1440, height: 900 });
  await page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36');

  console.log(`  → Visite de ${target.url}`);

  try {
    await page.goto(target.url, {
      waitUntil: 'networkidle2',
      timeout: 30000,
    });

    // Attendre que la page soit vraiment prête
    await new Promise(resolve => setTimeout(resolve, 2000));

    const result = await extractSection(page, target.selector);
    const tokens = await extractDesignTokens(page, target.url);

    if (!result) {
      console.log(`  ⚠️  Sélecteur "${target.selector}" non trouvé sur ${target.url}`);
      await page.close();
      return { success: false, tokens: null };
    }

    const html = await formatOutput(target, result, tokens);
    const outputPath = path.join(OUTPUT_DIR, `${target.name}.html`);
    await fs.writeFile(outputPath, html, 'utf8');

    console.log(`  ✓ ${target.name}.html (${Math.round(html.length / 1024)}kb)`);

    await page.close();
    return { success: true, tokens };

  } catch (err) {
    console.log(`  ✗ Erreur : ${err.message}`);
    await page.close();
    return { success: false, tokens: null };
  }
}

async function generateSummary(results) {
  const summary = {
    generated: new Date().toISOString(),
    total: results.length,
    success: results.filter(r => r.success).length,
    files: results.filter(r => r.success).map(r => `${r.name}.html`),
    usage: `
    COMMENT UTILISER CES FICHIERS AVEC CLAUDE CODE :

    1. Claude Code lit automatiquement tous les fichiers du projet
    2. Pour demander de l'inspiration : "Crée un hero similaire à design-refs/sonet-hero.html mais adapté au design system NEOGTB"
    3. Pour analyser : "Analyse les patterns CSS de design-refs/mckinsey-nav.html et explique ce qui renforce l'autorité"
    4. Pour un nouveau composant : "Crée une section témoignages en t'inspirant de design-refs/loom-testimonials.html"

    RÈGLE : Ces fichiers sont des références, pas des templates.
    Claude Code doit adapter, pas copier.
    Toujours respecter les variables CSS du design system NEOGTB dans CLAUDE.md.
    `,
  };

  await fs.writeJson(path.join(OUTPUT_DIR, '_summary.json'), summary, { spaces: 2 });
}

async function run() {
  console.log('\n🎨 NEOGTB Design Reference Scraper\n');

  await fs.ensureDir(OUTPUT_DIR);

  const { targets } = await fs.readJson(URLS_FILE);

  const toScrape = targetFilter
    ? targets.filter(t => t.name === targetFilter)
    : targets;

  if (toScrape.length === 0) {
    console.log(`Cible "${targetFilter}" non trouvée dans urls.json`);
    process.exit(1);
  }

  console.log(`📋 ${toScrape.length} cible(s) à scraper\n`);

  const browser = await puppeteer.launch({
    headless: 'new',
    args: ['--no-sandbox', '--disable-setuid-sandbox'],
  });

  const results = [];
  const allTokens = {};

  for (const target of toScrape) {
    console.log(`[${target.name}] ${target.label}`);
    const { success, tokens } = await scrapeTarget(browser, target);
    results.push({ name: target.name, success });
    if (tokens) allTokens[target.name] = tokens;

    // Pause courte entre chaque site pour éviter le rate limiting
    await new Promise(r => setTimeout(r, 1500));
  }

  await browser.close();

  // Sauvegarder tous les tokens dans un fichier consolidé
  await fs.writeJson(TOKENS_FILE, allTokens, { spaces: 2 });

  await generateSummary(results);

  const ok = results.filter(r => r.success).length;
  console.log(`\n✅ ${ok}/${toScrape.length} fichiers générés dans /design-refs/`);
  console.log(`📊 Tokens CSS consolidés → design-refs/_tokens-all.json`);
  console.log(`\nProchaine étape : demande à Claude Code de lire ces fichiers pour s'en inspirer.\n`);
}

run().catch(err => {
  console.error('Erreur fatale :', err);
  process.exit(1);
});
