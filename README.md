#RSSReader		
*Tristan CLADET - Anthony BARRIER - ISIMA ZZ3F2 (promo 2015)*
#1- Outils

L'application est basée sur le micro-framework PHP Silex.
La couche *Presentation* repose sur le Framework7 (hybride type iOS).
Ainsi que divers dépendances nous permettant de : 
- gérer la sérialisation des objets (`Symfony Serializer Component`);
- assurer la commande du Worker (`Symfony Console Component`);
- générer les pages (moteur de template `Twig`) ;
- gérer le parsing du flux RSS (`PicoFeed`) ;
- créer les tests fonctionnels (`behat`) ;
- créer les tests unitaires (`phpunit`).

#2- Ce qui a été fait

##Base de données
Nous avons fait le choix de MySQL principalement car nous connaissons bien ce système et que les relations
entre les tables sont facilement configurables (notamment pour le `DELETE CASCADE` des items).
Gestion des dates par un objet `DateManipulator` (Singleton).

##Architecture générale
- Les trois couches du MVC sont gérées.
- Le contrôleur frontal redirige l'ensemble des requêtes sur des contrôleurs spécialisés traitant les différentes demandes.
- L'interface avec la base de données est gérée à l'aide de `Mappers` (Singleton).
- Les requêtes préparées sont générées par un `QueryGenerator` (Singleton).
- Une fois les requêtes bindées avec les paramètres, elles sont exécutées par un
  objet `PDO Connection` (Singleton) et retournera les résultats.
- Les objets tels qu'ils sont définis dans le modèle sont ensuite crées par les `Mappers`.
- Les relations bi-directionnelles sont possibles grâce à une `IdentityMap` (Singleton).

##API REST
Deux fonctionnalités sont disponibles pour l'API REST : 
* La première consiste à retourner l'ensemble des Items (status code 200);
* La deuxième consiste à s'abonner à un nouveau flux :
	* status 200 : abonnement au flux fonctionnel;
	* status 403 : l'abonnement au flux existe déjà;
	* status 404 : le flux n'existe pas.

Cette API retourne les objets sérialisés en `JSON` par un `ObjectSerializer` (Singleton).

##Command Worker
Deux moyens sont disponibles afin de rafraîchir les flux : 
* par l'application : clic sur `Refresh` dans un flux;
* par la commande `rss:refresh` : utilisation via un terminal.

#3- Ce qui n'a pas été fait
* La gestion optionnelle des `Tags`;  
* La gestion du `Content Negotiation`.

#4- Installation et exécution

* Initialisation :
```bash
/RSSReader/>$ php composer.phar update
```
La création de la base de données avec le script **rssreader.sql** fourni dans l'archive.
Veuillez remplir la classe `src/Credentials/Credentials.php` avec vos identifiants en base de données.

* Exécuter l'application Web : 
```bash
/RSSReader/>$ cd web/
/RSSReader/web/>$ php -S localhost:4000
```
Dans un navigateur : [http://localhost:4000/app.php](http://localhost:4000/app.php)

* Exécuter l'application Console :
```bash
/RSSReader/>$ php app/console.php rss:refresh
```

* Effectuer les tests :
    * `behat` : Tests présents dans `features/`.
    * `phpunit` : Tests présents dans `tests/`.
```
/RSSReader/>$ bin/behat
/RSSReader/>$ phpunit --bootstrap vendor/autoload.php
```

