// Vercel Serverless Function — Double opt-in Brevo
// POST /api/newsletter { email }
// POST /api/newsletter?action=confirm&token=xxx (confirmation)

import crypto from 'crypto';

const BREVO_HEADERS = (key) => ({
  'api-key': key,
  'Content-Type': 'application/json',
  'Accept': 'application/json',
});

export default async function handler(req, res) {
  // CORS
  res.setHeader('Access-Control-Allow-Origin', 'https://neogtb.fr');
  res.setHeader('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  if (req.method === 'OPTIONS') return res.status(200).end();

  const BREVO_API_KEY = process.env.BREVO_API_KEY;
  if (!BREVO_API_KEY) return res.status(500).json({ error: 'Configuration serveur manquante' });

  // ═══ CONFIRMATION (GET /api/newsletter?action=confirm&token=xxx&email=xxx) ═══
  if (req.method === 'GET' && req.query.action === 'confirm') {
    const { email, token } = req.query;
    if (!email || !token) return res.redirect(302, '/');

    // Vérifier le token
    const expectedToken = crypto.createHmac('sha256', BREVO_API_KEY).update(email.toLowerCase()).digest('hex').slice(0, 16);
    if (token !== expectedToken) return res.redirect(302, '/');

    // Mettre à jour le contact dans Brevo : ajouter à la liste
    await fetch('https://api.brevo.com/v3/contacts', {
      method: 'POST',
      headers: BREVO_HEADERS(BREVO_API_KEY),
      body: JSON.stringify({
        email: email.toLowerCase(),
        listIds: [3],
        updateEnabled: true,
        attributes: { DOI_CONFIRMED: true },
      }),
    });

    return res.redirect(302, '/newsletter-confirmee');
  }

  // ═══ INSCRIPTION (POST /api/newsletter { email }) ═══
  if (req.method !== 'POST') return res.status(405).json({ error: 'Method not allowed' });

  const { email } = req.body || {};

  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    return res.status(400).json({ error: 'Email invalide' });
  }

  const normalizedEmail = email.toLowerCase();

  try {
    // Vérifier si le contact existe déjà dans la liste
    const checkRes = await fetch(`https://api.brevo.com/v3/contacts/${encodeURIComponent(normalizedEmail)}`, {
      headers: BREVO_HEADERS(BREVO_API_KEY),
    });

    if (checkRes.ok) {
      const contact = await checkRes.json();
      if (contact.listIds && contact.listIds.includes(3)) {
        return res.status(200).json({ ok: true, message: 'Déjà inscrit' });
      }
    }

    // Générer un token de confirmation
    const token = crypto.createHmac('sha256', BREVO_API_KEY).update(normalizedEmail).digest('hex').slice(0, 16);
    const confirmUrl = `https://neogtb.fr/api/newsletter?action=confirm&email=${encodeURIComponent(normalizedEmail)}&token=${token}`;

    // Envoyer l'email de confirmation via le template transactionnel
    const sendRes = await fetch('https://api.brevo.com/v3/smtp/email', {
      method: 'POST',
      headers: BREVO_HEADERS(BREVO_API_KEY),
      body: JSON.stringify({
        templateId: 3,
        to: [{ email: normalizedEmail }],
        params: { CONFIRM_URL: confirmUrl },
      }),
    });

    if (sendRes.ok) {
      return res.status(200).json({ ok: true, message: 'Email de confirmation envoyé' });
    }

    const error = await sendRes.json();
    return res.status(500).json({ error: error.message || 'Erreur envoi email' });
  } catch (err) {
    return res.status(500).json({ error: 'Erreur serveur' });
  }
}
