# Soutien aux libertés associatives

Site WordPress qui référence une bibliothèque de ressources (articles, liens externes, vidéos).

Stack : [Bedrock](https://roots.io/bedrock/) · ACF Pro · [Timber 2](https://timber.github.io/docs/v2/) (templates Twig) · [DDEV](https://ddev.com/) en local.

## Prérequis

- Docker Desktop ou OrbStack
- DDEV (`brew install ddev/ddev/ddev`), puis `mkcert -install` une fois pour le HTTPS local
- Une clé de licence ACF Pro

## Installation locale

```bash
# 1. Variables d'environnement
cp .env.example .env
#    puis dans .env :
#    DB_NAME='db'  DB_USER='db'  DB_PASSWORD='db'  DB_HOST='db'
#    WP_HOME="${DDEV_PRIMARY_URL}"
#    et générer les clés : https://roots.io/salts.html

# 2. Accès Composer à ACF Pro (fichier non versionné)
cat > auth.json <<'JSON'
{
  "http-basic": {
    "connect.advancedcustomfields.com": {
      "username": "VOTRE_CLE_ACF_PRO",
      "password": "https://soutient-aux-libertes-associatives.ddev.site"
    }
  }
}
JSON

# 3. Démarrage
ddev start
ddev composer install
ddev wp core install --url="$(ddev exec 'echo $DDEV_PRIMARY_URL')" \
  --title="Soutien aux libertés associatives" \
  --admin_user=admin --admin_password=admin --admin_email=admin@example.test --skip-email
ddev wp language core install fr_FR --activate
ddev wp theme activate libertes-associatives
ddev launch wp/wp-admin
```

## Structure

```
config/                  Configuration WordPress (par environnement)
web/app/themes/libertes-associatives/
  functions.php          Initialisation de Timber, supports du thème
  index.php              Contrôleurs PHP (préparent le contexte)
  templates/             Vues Twig
web/app/plugins/         Plugins installés via Composer (non versionnés)
web/wp/                  Cœur WordPress (non versionné)
```

## Commandes utiles

| Commande | Rôle |
|---|---|
| `ddev composer require wp-plugin/<slug>` | Ajouter un plugin de wordpress.org |
| `ddev wp ...` | WP-CLI |
| `ddev composer lint` | Vérifier le style PHP (Pint) |
| `ddev composer test` | Tests (Pest) |
