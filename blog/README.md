Télécharger le projet
git clone bllablabla

-------------------------

Mettre à jour les packages
composer update

-------------------------
Importer la base de données
php bin/console doctrine:schema:create

------------------------
Mettre à jour la base de données
php bin/console doctrine:schema:update --force

------------------------
Importer les fixtures
php bin/console doctrine:fixtures:LoadAllData

------------------------
Lancer le serveur
php bin/console server:run

------------------------
Accéder à l'url: http://localhost:8000
Vous disposez de trois comptes utilisateurs
un utilisateur basic (login: user, mdp:user) qui permet :
- de suivre des utilisateurs qui postent les articles
- de recevoir des notifications des derniers article (si créateur suivi)

un utilisateur qui a le role de rédacteur (login: redacteur, mdp:redacteur) qui permet:
- l'acces à un back-office
- la gestion des catégories et des articles

un utilisateur qui a le role admin (login: admin, mdp:admin) qui permet:
- hérites des role précédents
- accéde à la gestion des utilisateurs
