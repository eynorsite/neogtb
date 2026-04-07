# Sécurité - Actions manuelles requises

## URGENT - À faire MANUELLEMENT
1. Révoquer la clé Brevo : https://app.brevo.com/settings/keys/api
2. Régénérer une nouvelle clé Brevo
3. Mettre la nouvelle clé dans .env (jamais committer .env)
4. Régénérer APP_KEY : `php artisan key:generate`
5. Forcer le logout de toutes les sessions admin existantes
6. Vérifier que .env n'est pas dans l'historique git public
