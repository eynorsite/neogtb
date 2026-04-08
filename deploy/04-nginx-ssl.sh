#!/usr/bin/env bash
# Configure Nginx + Let's Encrypt SSL pour neogtb.fr (Laravel-only)
# Usage : sudo bash 04-nginx-ssl.sh
set -euo pipefail

DOMAIN="neogtb.fr"
ADMIN_DOMAIN="admin.neogtb.fr"
EMAIL="hello@neogtb.fr"
NGINX_CONF="/etc/nginx/sites-available/neogtb"

# Détecte automatiquement la version de PHP-FPM installée (8.3, 8.4, etc.)
PHP_FPM_SOCK=$(ls /run/php/php*-fpm.sock 2>/dev/null | grep -v 'alternatives' | head -1)
if [ -z "$PHP_FPM_SOCK" ]; then
    echo "❌ Aucun socket PHP-FPM trouvé dans /run/php/. Installe PHP-FPM avant de relancer."
    exit 1
fi
echo "==> Socket PHP-FPM détecté : $PHP_FPM_SOCK"

echo "==> [1/5] Écriture config Nginx HTTP-only (étape 1, Certbot ajoutera SSL)"
cat > "$NGINX_CONF" <<NGINXCONF
# NeoGTB — 100% Laravel (front public + admin Filament)
# Étape 1 : HTTP-only pour permettre à Certbot d'obtenir le cert.
# Certbot --nginx ajoutera automatiquement le bloc HTTPS et la redirection.
server {
    listen 80;
    listen [::]:80;
    server_name neogtb.fr www.neogtb.fr;

    root /var/www/neogtb/current/admin/public;
    index index.php index.html;

    # Compression
    gzip on;
    gzip_types text/plain text/css text/xml application/json application/javascript application/xml+rss text/javascript image/svg+xml;
    gzip_min_length 1024;

    # Cache assets statiques (build Vite admin + uploads)
    location ~* \.(webp|jpg|jpeg|png|gif|ico|css|js|woff2?|svg)\$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files \$uri =404;
    }

    # Tout passe par Laravel (front public + admin Filament)
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        fastcgi_pass unix:${PHP_FPM_SOCK};
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
    }

    # Bloquer accès aux fichiers cachés (sauf .well-known pour Certbot)
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Headers sécurité
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Permissions-Policy "geolocation=(), microphone=(), camera=()" always;
}

# admin.neogtb.fr — back-office Filament (meme Laravel que neogtb.fr)
server {
    listen 80;
    listen [::]:80;
    server_name admin.neogtb.fr;

    root /var/www/neogtb/current/admin/public;
    index index.php;

    client_max_body_size 64M;

    gzip on;
    gzip_types text/plain text/css text/xml application/json application/javascript application/xml+rss text/javascript image/svg+xml;
    gzip_min_length 1024;

    location ~* \.(webp|jpg|jpeg|png|gif|ico|css|js|woff2?|svg)\$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files \$uri =404;
    }

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        fastcgi_pass unix:${PHP_FPM_SOCK};
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Permissions-Policy "geolocation=(), microphone=(), camera=()" always;
}
NGINXCONF

echo "==> [2/5] Activation site + désactivation default"
ln -sfn /etc/nginx/sites-available/neogtb /etc/nginx/sites-enabled/neogtb
rm -f /etc/nginx/sites-enabled/default

echo "==> [3/5] Test config Nginx + reload (HTTP-only)"
nginx -t
systemctl reload nginx

echo "==> [4/5] Certificat SSL Let's Encrypt + upgrade Nginx vers HTTPS"
# certbot --nginx :
#   - obtient le cert via HTTP-01 challenge (Nginx HTTP en place)
#   - édite le vhost pour ajouter le bloc 443 ssl + redirection 80→443
#   - reload Nginx automatiquement
certbot --nginx \
    -d "$DOMAIN" -d "www.$DOMAIN" -d "$ADMIN_DOMAIN" \
    --non-interactive --agree-tos \
    -m "$EMAIL" \
    --redirect

echo "==> [5/5] Vérification finale"
nginx -t
systemctl reload nginx

echo ""
echo "✅ Déploiement terminé."
echo ""
echo "Tests :"
echo "  curl -I https://neogtb.fr"
echo "  curl -I https://neogtb.fr/sitemap-index.xml"
echo "  curl -I https://admin.neogtb.fr/admin/login"
