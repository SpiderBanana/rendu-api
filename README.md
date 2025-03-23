CLINIQUE VÉTÉRINAIRE API PLATFORM (Version courte)

DESCRIPTION GLOBALE

API Symfony/API Platform gérant les rendez-vous, les traitements, les animaux, les clients et le personnel (directeur, vétérinaires, assistants).

TECHNOLOGIES

PHP 8.0+

Symfony 5/6, API Platform, Doctrine ORM

LexikJWTAuthenticationBundle (gestion JWT)

VichUploaderBundle (optionnel, pour l’upload de fichiers)

PRÉREQUIS

PHP >= 8.0

Composer

Base de données (MySQL, PostgreSQL, etc.)

OpenSSL (pour clés JWT)

(Optionnel) Symfony CLI

INSTALLATION / CONFIGURATION

Cloner le dépôt : git clone https://github.com/mon-repo/clinique-veterinaire-api.git cd clinique-veterinaire-api

Installer les dépendances : composer install

Configurer la base de données (fichier .env.local), exemple : DATABASE_URL="mysql://user:password@127.0.0.1:3306/nom_de_la_base"

Configurer JWT dans .env.local : 
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem 
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem 
JWT_PASSPHRASE=MaPassphrase

Générer les clés JWT : php bin/console lexik:jwt:generate-keypair

Mettre à jour la base : php bin/console doctrine:migrations:migrate (ou php bin/console doctrine:schema:update --force)

CHARGEMENT DE FIXTURES (optionnel) php bin/console doctrine:fixtures:load --purge-with-truncate

LANCER L’APPLICATION 
symfony server:start (ou php -S 127.0.0.1:8000 -t public/)

L’API est accessible sur http://127.0.0.1:8000/api 
La documentation Swagger (interactive) est aussi disponible à /api

AUTHENTIFICATION (JWT)

Obtenir un token : POST /api/auth 
Exemple de payload : { "email": "director@example.com", "password": "password" }

Utiliser le token dans chaque requête : Authorization: Bearer <token>

IMPORT DES REQUÊTES POSTMAN 

Utiliser le fichier de l'export de mes requêtes POSTMAN pour tester l'application, voici le chemin : 
rendu-api/export-postman/rendu-api.postman_collection.json

ROLES ET FONCTIONNALITÉS

Directeur : gère le personnel (création, liste, suppression)

Vétérinaires : peuvent consulter/s’attribuer des rendez-vous, gérer les traitements

Assistants : créent/modifient rendez-vous, enregistrent paiement, créent fiches animal

Clients : utilisateurs non authentifiés (accès public si défini)

POINTS CLÉS DE L’API

POST /api/rendez_vouses (Créer rendez-vous)

PATCH /api/rendez_vouses/{id} (Mettre à jour)

GET /api/rendez_vouses/{id} (Détail)

GET /api/rendez_vouses (Filtrable sur la date)

POST /api/users (Créer personnel, rôle directeur)

GET /api/users (Liste, rôle directeur)

PATCH /api/users/{id} (Mise à jour)

DELETE /api/users/{id} (Suppression)

TEST AVEC POSTMAN

Faire POST /api/auth (payload avec email/password)

Récupérer token, l'ajouter à "Authorization: Bearer <token>" dans chaque requête

Pour PATCH, utiliser "Content-Type: application/merge-patch+json"