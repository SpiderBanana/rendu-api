# CLINIQUE VÉTÉRINAIRE API PLATFORM

## DESCRIPTION GLOBALE

API Symfony/API Platform gérant les rendez-vous, traitements, animaux, clients et personnel (directeur, vétérinaires, assistants).

## TECHNOLOGIES

- PHP 8.0+
- Symfony 5/6, API Platform, Doctrine ORM
- LexikJWTAuthenticationBundle (JWT)
- VichUploaderBundle (optionnel, upload de fichiers)

## PRÉREQUIS

- PHP >= 8.0
- Composer
- Base de données (MySQL, PostgreSQL, etc.)
- OpenSSL (pour JWT)
- Symfony CLI (optionnel)

## INSTALLATION / CONFIGURATION

```bash
git clone https://github.com/SpiderBanana/rendu-api.git
cd rendu-api

composer install
```

Configurer la base (`.env.local`) :

```env
DATABASE_URL="mysql://user:password@127.0.0.1:3306/nom_de_la_base"

JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=MaPassphrase
```

Générer clés JWT :
```bash
php bin/console lexik:jwt:generate-keypair
```

Migrations base de données :
```bash
php bin/console doctrine:migrations:migrate
# ou
php bin/console doctrine:schema:update --force
```

Fixtures (optionnel) :
```bash
php bin/console doctrine:fixtures:load --purge-with-truncate
```

## LANCER L’APPLICATION

```bash
symfony server:start
# ou
php -S 127.0.0.1:8000 -t public/
```

API accessible sur : [http://127.0.0.1:8000/api](http://127.0.0.1:8000/api)  
Documentation Swagger interactive : `/api`

## AUTHENTIFICATION (JWT)

Obtenir token : `POST /api/auth`

Payload exemple :
```json
{"email": "director@example.com", "password": "password"}
```

Ajouter token à chaque requête :
```
Authorization: Bearer <token>
```

## IMPORT DES REQUÊTES POSTMAN

Fichier collection Postman :
```
rendu-api/export-postman/rendu-api.postman_collection.json
```

## RÔLES ET FONCTIONNALITÉS

- **Directeur** : gère personnel (création, liste, suppression)
- **Vétérinaires** : consultent/s'attribuent rendez-vous, gèrent traitements
- **Assistants** : gèrent rendez-vous, paiement, fiches animaux
- **Clients** : accès public (non authentifié si défini)

## POINTS CLÉS DE L’API

- `POST /api/rendez_vouses` (Créer rendez-vous)
- `PATCH /api/rendez_vouses/{id}` (Mise à jour)
- `GET /api/rendez_vouses/{id}` (Détail)
- `GET /api/rendez_vouses` (Liste filtrable par date)
- `POST /api/users` (Créer personnel, directeur)
- `GET /api/users` (Liste personnel, directeur)
- `PATCH /api/users/{id}` (Mise à jour)
- `DELETE /api/users/{id}` (Suppression)

## TEST AVEC POSTMAN

- Faire `POST /api/auth` (payload email/password)
- Ajouter token reçu dans `Authorization: Bearer <token>` à chaque requête
- Pour `PATCH`, utiliser `Content-Type: application/merge-patch+json`
