#!/usr/bin/env bash
# Installation des dépendances système sur le VPS (Ubuntu 22.04+ / Debian 12+)
# À lancer en root : sudo bash 01-install-deps.sh
set -euo pipefail

echo "==> [1/6] Mise à jour du système"
apt-get update
apt-get upgrade -y

echo "==> [2/6] Installation Nginx + Certbot"
apt-get install -y nginx certbot python3-certbot-nginx ufw curl git unzip

echo "==> [3/6] Installation PHP 8.3 + extensions"
apt-get install -y software-properties-common
add-apt-repository -y ppa:ondrej/php || true
apt-get update
apt-get install -y \
  php8.3-fpm php8.3-cli php8.3-common \
  php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip \
  php8.3-sqlite3 php8.3-bcmath php8.3-intl php8.3-gd

echo "==> [4/6] Installation Composer"
if ! command -v composer &> /dev/null; then
  curl -sS https://getcomposer.org/installer | php
  mv composer.phar /usr/local/bin/composer
  chmod +x /usr/local/bin/composer
fi

echo "==> [5/6] Installation Node.js 20 LTS"
if ! command -v node &> /dev/null; then
  curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
  apt-get install -y nodejs
fi

echo "==> [6/6] Configuration firewall (UFW)"
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw --force enable

echo ""
echo "✅ Dépendances installées :"
node --version
php --version | head -1
composer --version
nginx -v
echo ""
echo "Prochaine étape : sudo bash 02-clone-code.sh"
