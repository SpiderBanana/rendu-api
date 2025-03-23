# Clinique Vétérinaire API Platform

Ce projet est une API permettant de gérer une clinique vétérinaire. Il a été développé avec Symfony, API Platform, Doctrine et utilise JWT pour l'authentification. L'application gère les rendez-vous, les traitements, les animaux, les clients et le personnel (directeur, vétérinaires et assistants vétérinaires).

## Table des matières

- [Description du projet](#description-du-projet)
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Chargement des fixtures](#chargement-des-fixtures)
- [Exécution de l'application](#exécution-de-lapplication)
- [Utilisation de l'API](#utilisation-de-lapi)
  - [Endpoints principaux](#endpoints-principaux)
  - [Authentification et sécurité](#authentification-et-sécurité)
- [Tests avec Postman](#tests-avec-postman)
- [Dépannage](#dépannage)
- [Documentation supplémentaire](#documentation-supplémentaire)
- [Contribution](#contribution)
- [Licence](#licence)

## Description du projet

Cette API permet de gérer une clinique vétérinaire avec quatre types d'utilisateurs :

- **Directeur** : Responsable de la gestion du personnel (création, modification, suppression des vétérinaires et assistants).
- **Vétérinaires** : Peuvent consulter et s'attribuer des rendez-vous, créer et gérer des traitements.
- **Assistants vétérinaires** : Peuvent enregistrer des rendez-vous, mettre à jour les rendez-vous non terminés, enregistrer le paiement d'une consultation et créer une fiche animal.
- **Clients** : Toute personne non authentifiée, considérée comme client.

## Fonctionnalités

- **Gestion des rendez-vous** : Création, mise à jour, attribution et consultation.
- **Gestion du personnel** : Le directeur peut créer, lister, afficher en détail, mettre à jour et supprimer les membres du personnel.
- **Gestion des traitements** : Création, modification, suppression, liste et consultation détaillée.
- **Gestion des animaux et des clients** : Création et consultation des fiches animales, association à un client.
- **Authentification JWT** : Sécurisation des endpoints via LexikJWTAuthenticationBundle.
- **(Optionnel) Upload de fichiers** : Gestion des médias via VichUploaderBundle.

## Technologies utilisées

- PHP 8.0+
- Symfony (5.x ou 6.x)
- API Platform
- Doctrine ORM
- LexikJWTAuthenticationBundle (JWT)
- VichUploaderBundle (upload de fichiers, si utilisé)

## Prérequis

- PHP 8.0 ou supérieur
- Composer
- Une base de données (MySQL, PostgreSQL, SQLite, etc.)
- OpenSSL (pour générer les clés JWT)
- (Optionnel) Symfony CLI

## Installation

1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/votre-repo/clinique-veterinaire-api.git
   cd clinique-veterinaire-api
Installer les dépendances :

bash
Copier
composer install
Configurer l'environnement :

Copier le fichier .env en .env.local et configurer la base de données :

dotenv
Copier
DATABASE_URL="mysql://username:password@127.0.0.1:3306/nom_de_la_base"
Configurer les variables JWT dans .env.local :

dotenv
Copier
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=VotrePassphraseSecrète
Générer les clés JWT :

bash
Copier
php bin/console lexik:jwt:generate-keypair
Mettre à jour le schéma de la base de données : Si vous utilisez des migrations :

bash
Copier
php bin/console doctrine:migrations:migrate
Sinon, vous pouvez mettre à jour directement :

bash
Copier
php bin/console doctrine:schema:update --force
Chargement des fixtures
Pour insérer des données de test (utilisateurs, etc.) dans la base, exécutez :

bash
Copier
php bin/console doctrine:fixtures:load --purge-with-truncate
Ce chargera, par exemple, un directeur, un assistant vétérinaire et un vétérinaire.

Exécution de l'application
Pour démarrer le serveur de développement :

bash
Copier
symfony server:start
ou

bash
Copier
php -S 127.0.0.1:8000 -t public/
L'application sera accessible via http://127.0.0.1:8000.

Utilisation de l'API
La documentation interactive de l'API est disponible à l'URL :

arduino
Copier
http://127.0.0.1:8000/api
Vous y trouverez la liste des endpoints, les formats attendus et vous pourrez tester l'API directement depuis Swagger UI.

Endpoints principaux
Rendez-vous
Créer un rendez-vous (Assistants vétérinaires) :
POST /api/rendez_vouses

Mettre à jour un rendez-vous :
PATCH /api/rendez_vouses/{id}

Voir le détail d'un rendez-vous :
GET /api/rendez_vouses/{id}

Lister les rendez-vous du jour :
GET /api/rendez_vouses?dateRdv[after]=YYYY-MM-DDT00:00:00+00:00&dateRdv[before]=YYYY-MM-DDT23:59:59+00:00

Animaux
Créer une fiche animal :
POST /api/animals

Voir les détails d'un animal :
GET /api/animals/{id}

Clients
Créer un client :
POST /api/clients

Voir les détails d'un client :
GET /api/clients/{id}

Personnel (Utilisateurs)
Créer un utilisateur (Directeur uniquement) :
POST /api/users

Lister le personnel (Directeur uniquement) :
GET /api/users

Voir les détails d'un membre du personnel :
GET /api/users/{id}

Mettre à jour un membre du personnel :
PATCH /api/users/{id}

Supprimer un membre du personnel :
DELETE /api/users/{id}

Traitements
Créer un traitement :
POST /api/traitements

Mettre à jour un traitement :
PATCH /api/traitements/{id}

Supprimer un traitement :
DELETE /api/traitements/{id}

Lister les traitements :
GET /api/traitements

Voir les détails d'un traitement :
GET /api/traitements/{id}

Authentification et sécurité
L'API utilise JWT pour sécuriser les endpoints.

Obtenir un token :
Envoyez une requête POST à :

bash
Copier
POST /api/auth
avec le payload suivant (exemple pour le directeur) :

json
Copier
{
  "email": "director@example.com",
  "password": "password"
}
Le token reçu doit être inclus dans toutes les requêtes sécurisées via l'en-tête :

makefile
Copier
Authorization: Bearer <votre_token>
Les accès aux endpoints sont restreints selon les rôles :

Directeur : Peut créer, lister, afficher, modifier et supprimer les membres du personnel.

Assistants vétérinaires : Peuvent créer et mettre à jour des rendez-vous, enregistrer des paiements et créer des fiches animal.

Vétérinaires : Peuvent consulter les rendez-vous du jour, s'attribuer des rendez-vous, et gérer les traitements.

Clients : Accès aux fonctionnalités publiques (si définies).

Tests avec Postman
Pour tester l'API avec Postman :

Obtenez un token via :

URL : http://127.0.0.1:8000/api/auth

Méthode : POST

Payload (exemple) :

json
Copier
{
  "email": "director@example.com",
  "password": "password"
}
Ajoutez le token à chaque requête :
Dans l'onglet Headers, ajoutez :

makefile
Copier
Authorization: Bearer <votre_token>
Testez les endpoints en utilisant les URLs et les méthodes décrites ci-dessus.

Remarque : Pour les requêtes PATCH, utilisez le header Content-Type: application/merge-patch+json.

Dépannage
Erreur 401/403 : Vérifiez que vous utilisez le bon token et que l'utilisateur a les droits requis.

Erreur 415 : Pour les requêtes PATCH, utilisez Content-Type: application/merge-patch+json.

Cache : Si vous modifiez la configuration, videz le cache avec :

bash
Copier
php bin/console cache:clear
Vérifiez les IRIs : Assurez-vous que les relations (par exemple, pour animal, assistant, veterinaire) pointent vers des ressources existantes. Vous pouvez les retrouver via Swagger ou une requête GET.

Documentation supplémentaire
Symfony Documentation

API Platform Documentation

Lexik JWT Authentication Bundle

Doctrine Fixtures Bundle

VichUploaderBundle Documentation (si utilisé)

Contribution
Les contributions sont les bienvenues. Pour contribuer :

Forkez le dépôt.

Créez une branche pour votre fonctionnalité ou correction :

bash
Copier
git checkout -b feature/nom-de-la-fonctionnalité
Commitez vos modifications :

bash
Copier
git commit -am 'Ajout d'une fonctionnalité'
Poussez la branche :

bash
Copier
git push origin feature/nom-de-la-fonctionnalité
Créez une Pull Request.

Licence
Ce projet est sous licence MIT.

pgsql
Copier

This is a complete README in markdown format. 

I'll produce the answer with a markdown code block. We'll produce final answer now. We'll produce the answer as above.

I'll now produce final answer.
Voici un exemple complet de README pour votre projet :

markdown
Copier
# Clinique Vétérinaire API Platform

Ce projet est une API permettant de gérer une clinique vétérinaire. Elle est développée avec Symfony, API Platform et Doctrine, et utilise JWT pour l'authentification. L'application offre des fonctionnalités de gestion des rendez-vous, des traitements, des animaux, des clients et du personnel (directeur, vétérinaires et assistants vétérinaires).

## Table des matières

- [Description du projet](#description-du-projet)
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Chargement des fixtures](#chargement-des-fixtures)
- [Exécution de l'application](#exécution-de-lapplication)
- [Utilisation de l'API](#utilisation-de-lapi)
  - [Endpoints principaux](#endpoints-principaux)
  - [Authentification et sécurité](#authentification-et-sécurité)
- [Tests avec Postman](#tests-avec-postman)
- [Dépannage](#dépannage)
- [Documentation supplémentaire](#documentation-supplémentaire)
- [Contribution](#contribution)
- [Licence](#licence)

## Description du projet

L'API gère une clinique vétérinaire avec différents types d'utilisateurs :

- **Directeur** : Responsable de la gestion du personnel (création, modification, suppression des vétérinaires et assistants).
- **Vétérinaires** : Peuvent consulter et s'attribuer des rendez-vous, créer et gérer les traitements.
- **Assistants vétérinaires** : Peuvent enregistrer et mettre à jour les rendez-vous, enregistrer le paiement d'une consultation et créer une fiche animal.
- **Clients** : Personnes non authentifiées, considérées comme clients.

## Fonctionnalités

- **Gestion des rendez-vous**  
  - Créer, mettre à jour, consulter et lister les rendez-vous (filtrage par date du jour, etc.).
- **Gestion des traitements**  
  - Créer, modifier, supprimer, lister et afficher en détail les traitements.
- **Gestion des animaux et des clients**  
  - Créer une fiche animal et consulter ses informations.
- **Gestion du personnel**  
  - Le directeur peut créer (vétérinaires et assistants), lister, afficher en détail, modifier et supprimer des membres du personnel.
- **Sécurisation de l'API**  
  - Authentification via JWT, avec des accès restreints en fonction des rôles.

## Technologies utilisées

- PHP 8.0+
- Symfony (5.x ou 6.x)
- API Platform
- Doctrine ORM
- LexikJWTAuthenticationBundle (JWT)
- VichUploaderBundle (pour la gestion des fichiers, si utilisé)

## Prérequis

- PHP 8.0 ou supérieur
- Composer
- Une base de données (MySQL, PostgreSQL, SQLite, etc.)
- OpenSSL (pour la génération des clés JWT)
- (Optionnel) Symfony CLI

## Installation

1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/votre-repo/clinique-veterinaire-api.git
   cd clinique-veterinaire-api
Installer les dépendances :

bash
Copier
composer install
Configurer l'environnement :

Copiez le fichier .env en .env.local et adaptez les paramètres de la base de données :

dotenv
Copier
DATABASE_URL="mysql://username:password@127.0.0.1:3306/nom_de_la_base"
Configurez les variables JWT dans .env.local :

dotenv
Copier
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=VotrePassphraseSecrète
Générer les clés JWT :

bash
Copier
php bin/console lexik:jwt:generate-keypair
Mettre à jour le schéma de la base de données : Si vous utilisez les migrations :

bash
Copier
php bin/console doctrine:migrations:migrate
Sinon, vous pouvez mettre à jour directement :

bash
Copier
php bin/console doctrine:schema:update --force
Chargement des fixtures
Pour insérer des données de test (par exemple, des utilisateurs avec différents rôles), exécutez :

bash
Copier
php bin/console doctrine:fixtures:load --purge-with-truncate
Cette commande va insérer un directeur, un assistant vétérinaire, un vétérinaire et éventuellement d'autres entités dans la base de données.

Exécution de l'application
Pour démarrer le serveur de développement, vous pouvez utiliser :

bash
Copier
symfony server:start
ou

bash
Copier
php -S 127.0.0.1:8000 -t public/
L'application sera alors accessible via http://127.0.0.1:8000.

Utilisation de l'API
La documentation interactive de l'API (Swagger UI) est accessible à l'adresse :

arduino
Copier
http://127.0.0.1:8000/api
Vous y trouverez la liste de tous les endpoints, le format attendu et vous pourrez tester directement les requêtes.

Endpoints principaux
Rendez-vous
Créer un rendez-vous (Assistants vétérinaires) :
POST /api/rendez_vouses

Mettre à jour un rendez-vous :
PATCH /api/rendez_vouses/{id}

Voir le détail d'un rendez-vous :
GET /api/rendez_vouses/{id}

Lister les rendez-vous du jour :
GET /api/rendez_vouses?dateRdv[after]=YYYY-MM-DDT00:00:00+00:00&dateRdv[before]=YYYY-MM-DDT23:59:59+00:00

Animaux
Créer une fiche animal :
POST /api/animals

Voir les détails d'un animal :
GET /api/animals/{id}

Clients
Créer un client :
POST /api/clients

Voir les détails d'un client :
GET /api/clients/{id}

Personnel (Utilisateurs)
Créer un utilisateur (Directeur uniquement) :
POST /api/users

Lister le personnel (Directeur uniquement) :
GET /api/users

Afficher en détail un membre du personnel :
GET /api/users/{id}

Mettre à jour un membre du personnel :
PATCH /api/users/{id}

Supprimer un membre du personnel :
DELETE /api/users/{id}

Traitements
Créer un traitement :
POST /api/traitements

Mettre à jour un traitement :
PATCH /api/traitements/{id}

Supprimer un traitement :
DELETE /api/traitements/{id}

Lister les traitements :
GET /api/traitements

Afficher en détail un traitement :
GET /api/traitements/{id}

Authentification et sécurité
L'API utilise le système JWT pour sécuriser les endpoints. Pour obtenir un token :

Authentification :
Envoyez une requête POST à :

bash
Copier
POST /api/auth
avec le payload suivant (exemple pour le directeur) :

json
Copier
{
  "email": "director@example.com",
  "password": "password"
}
Le token reçu doit être envoyé dans l'en-tête de chaque requête sécurisée :

makefile
Copier
Authorization: Bearer <votre_token>
Rôles et accès :

Directeur :
Peut créer, lister, afficher en détail, mettre à jour et supprimer des membres du personnel (vétérinaires et assistants).

Assistants vétérinaires :
Peuvent enregistrer des rendez-vous, mettre à jour les rendez-vous non terminés, enregistrer le paiement d'une consultation et créer des fiches animal.

Vétérinaires :
Peuvent consulter les rendez-vous du jour, s'attribuer des rendez-vous et gérer les traitements.

Clients :
Accès aux fonctionnalités publiques (si définies).

Tests avec Postman
Pour tester l'API avec Postman :

Obtenir un token :

Créez une requête POST vers http://127.0.0.1:8000/api/auth

Utilisez le payload suivant (exemple pour le directeur) :

json
Copier
{
  "email": "director@example.com",
  "password": "password"
}
Copiez le token reçu.

Ajouter le token à chaque requête :

Dans l'onglet Headers, ajoutez :

makefile
Copier
Authorization: Bearer <votre_token>
Tester les endpoints :

Pour les requêtes PATCH, utilisez le header Content-Type: application/merge-patch+json.

Assurez-vous que les IRIs (ex. /api/users/3, /api/animals/1, etc.) dans vos payloads correspondent à des ressources existantes.

Dépannage
Erreurs 401/403 :
Vérifiez que vous utilisez le bon token et que l'utilisateur a les droits nécessaires.

Erreurs 415 :
Pour les requêtes PATCH, assurez-vous d'utiliser Content-Type: application/merge-patch+json.

Cache :
Si vous modifiez la configuration, videz le cache avec :

bash
Copier
php bin/console cache:clear
IRIs :
Vérifiez via la documentation Swagger (accessible sur /api) que les IRIs dans vos payloads pointent vers des ressources existantes.

Documentation supplémentaire
Symfony Documentation

API Platform Documentation

Lexik JWT Authentication Bundle

Doctrine Fixtures Bundle Documentation

VichUploaderBundle Documentation (si utilisé)

Contribution
Les contributions sont les bienvenues ! Pour contribuer :

Forkez le dépôt.

Créez une branche pour votre fonctionnalité ou correction :

bash
Copier
git checkout -b feature/nom-de-la-fonctionnalité
Commitez vos changements :

bash
Copier
git commit -am 'Ajout d\'une fonctionnalité'
Poussez la branche :

bash
Copier
git push origin feature/nom-de-la-fonctionnalité
Créez une Pull Request.

