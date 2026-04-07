#!/usr/bin/env bash
# Configure Nginx + Let's Encrypt SSL pour neogtb.fr (Laravel-only)
# Usage : sudo bash 04-nginx-ssl.sh
set -euo pipefail

DOMAIN="neogtb.fr"
EMAIL="hello@neogtb.fr"
NGINX_CONF="/etc/nginx/sites-available/neogtb"

echo "==> [1/4] Écriture config Nginx"
cat > "$NGINX_CONF" <<'NGINXCONF'
# NeoGTB — 100% Laravel (front public + admin Filament)
server {
    listen 80;
    listen [::]:80;
    server_name neogtb.fr www.neogtb.fr;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name neogtb.fr www.neogtb.fr;

    root /var/www/neogtb/current/admin/public;
    index index.php index.html;

    # SSL géré par Certbot (sera ajouté en bas par certbot --nginx)
    # ssl_certificate /etc/letsencrypt/live/neogtb.fr/fullchain.pem;
    # ssl_certificate_key /etc/letsencrypt/live/neogtb.fr/privkey.pem;

    # Compression
    gzip on;
    gzip_types text/plain text/css text/xml application/json application/javascript application/xml+rss text/javascript image/svg+xml;
    gzip_min_length 1024;

    # Cache assets statiques (build Vite admin + uploads)
    location ~* \.(webp|jpg|jpeg|png|gif|ico|css|js|woff2?|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files $uri =404;
    }

    # Tout passe par Laravel (front public + admin Filament)
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTPS on;
    }

    # Bloquer accès aux fichiers cachés
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Headers sécurité
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Permissions-Policy "geolocation=(), microphone=(), camera=()" always;
}
NGINXCONF

echo "==> [2/4] Activation site"
ln -sfn /etc/nginx/sites-available/neogtb /etc/nginx/sites-enabled/neogtb
rm -f /etc/nginx/sites-enabled/default

echo "==> [3/4] Test config Nginx + reload"
nginx -t
systemctl reload nginx

echo "==> [4/4] Certificat SSL Let's Encrypt"
certbot --nginx -d "$DOMAIN" -d "www.$DOMAIN" --non-interactive --agree-tos -m "$EMAIL" --redirect

echo ""
echo "✅ Déploiement terminé."
echo ""
echo "Tests :"
echo "  curl -I https://neogtb.fr"
echo "  curl -I https://neogtb.fr/admin"
echo "  curl -I https://neogtb.fr/sitemap-index.xml"
