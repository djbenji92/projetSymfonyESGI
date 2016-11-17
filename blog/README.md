Projet ESGI : Blog Symfony
========================

#Mettre à jour les packages
```Shell
composer update
```

#Importer la base de données
```Shell
php bin/console doctrine:schema:create
```

#Mettre à jour la base de données
```Shell
php bin/console doctrine:schema:update --force
```

#Importer les fixtures
```Shell
php bin/console doctrine:fixtures:LoadAllData
```

#Lancer le serveur
```Shell
php bin/console server:run
```

#Parametres

###Accéder au site:
http://localhost:8000

###Comptes utilisateur:

#####Un utilisateur basic
* Username: user
* Password: user

* Droits:
Suivre des utilisateurs qui postent les articles
Recevoir des notifications des derniers article (si créateur suivi)

#####Un utilisateur rédacteur
* Username: redacteur
* Password: redacteur

* Droits:
Hérite des droits du rôle basic
Accéde à un back-office
Gestion des catégories et des articles

#####Un utilisateur admin
* Username: admin
* Password: admin

* Droit:
Hérite des deux rôles précedents
Accéde à la gestion des utilisateurs
