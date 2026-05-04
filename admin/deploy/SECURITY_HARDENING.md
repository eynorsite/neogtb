# Hardening sécurité neogtb.fr — patch à appliquer

Audit du 4 mai 2026. Trois zones à modifier : **nginx**, **DNS (OVH)**, **fichier statique**.

---

## 1. Nginx — headers sécurité + masquage `.DS_Store`

Ouvrir le vhost (généralement `/etc/nginx/sites-available/neogtb` ou `/etc/nginx/conf.d/neogtb.conf`) et, dans le bloc `server { listen 443 ssl; server_name www.neogtb.fr neogtb.fr; ... }`, ajouter :

```nginx
# --- Sécurité headers ---
add_header Strict-Transport-Security "max-age=63072000; includeSubDomains; preload" always;
add_header Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data: https:; connect-src 'self' https://api.brevo.com; frame-ancestors 'self'; base-uri 'self'; form-action 'self';" always;
add_header Cross-Origin-Opener-Policy "same-origin" always;
add_header Cross-Origin-Resource-Policy "same-site" always;
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-Content-Type-Options "nosniff" always;
add_header Referrer-Policy "strict-origin-when-cross-origin" always;
add_header Permissions-Policy "geolocation=(), microphone=(), camera=()" always;

# --- Masquer fichiers cachés (renvoyer 404 plutôt que 403) ---
location ~ /\.(?!well-known) {
    access_log off;
    log_not_found off;
    return 404;
}

# --- Masquer le header Server (optionnel) ---
server_tokens off;
```

> ⚠️ La CSP ci-dessus est conservatrice. Teste en console navigateur — si du JS/CSS externe casse, ajoute le domaine dans la directive correspondante. Tu peux aussi commencer en mode `Content-Security-Policy-Report-Only` pendant 1-2 semaines.

Tester puis recharger :

```bash
sudo nginx -t && sudo systemctl reload nginx
```

---

## 2. DNS (OVH) — CAA, durcir DMARC, nettoyer TXT

Dans OVH > Zone DNS de **neogtb.fr** :

### 2.1 Ajouter records CAA (limite quelles CA peuvent émettre des certs)

```
neogtb.fr.    CAA    0 issue "letsencrypt.org"
neogtb.fr.    CAA    0 iodef "mailto:contact@neogtb.fr"
```

> Adapte l'email iodef à une adresse que tu surveilles.

### 2.2 Durcir DMARC

Remplacer le record `_dmarc.neogtb.fr` actuel :

```
_dmarc.neogtb.fr.    TXT    "v=DMARC1; p=quarantine; rua=mailto:rua@dmarc.brevo.com; ruf=mailto:rua@dmarc.brevo.com; fo=1; pct=100; adkim=s; aspf=s"
```

> Reste 2-4 semaines en `p=quarantine`, puis passe à `p=reject` une fois sûr.

### 2.3 Vérifier le TXT bizarre

Le record TXT `"1|www.neogtb.fr"` ressemble à un token de validation oublié (Microsoft 365, Atlassian, ou similaire). À retirer si plus utilisé — sinon documenter d'où il vient.

---

## 3. security.txt — bonne pratique signalement vulnérabilités

Créer le fichier **`public/.well-known/security.txt`** dans le repo Astro :

```
Contact: mailto:security@neogtb.fr
Expires: 2027-05-04T00:00:00.000Z
Preferred-Languages: fr, en
Canonical: https://www.neogtb.fr/.well-known/security.txt
```

Puis redéployer (`./deploy.sh`).

---

## Vérification post-déploiement

```bash
# Headers
curl -sI https://www.neogtb.fr/ | grep -iE "strict-transport|content-security|cross-origin|x-frame|x-content|referrer|permissions"

# CAA
dig +short neogtb.fr CAA

# DMARC
dig +short _dmarc.neogtb.fr TXT

# security.txt
curl -s https://www.neogtb.fr/.well-known/security.txt

# Score général
# https://securityheaders.com/?q=www.neogtb.fr
# https://www.ssllabs.com/ssltest/analyze.html?d=www.neogtb.fr
```

Cible : **A+ sur securityheaders.com** et **A+ sur SSL Labs**.
