# RSSReader

An ISIMA PHP project for "Objets Avancés" class.

With this reader, a user can simply enter a feed link (Atom or RSS), and the site will show you all the feed contents (at the address `http://localhost:4000/web/index.php/feeds`).
There is a few tasks to do in order to initialize this project.
First of all, you'll have to init your `composer.phar` file with the command `php composer.phar update`. Then you can our project by launching a server with the command `php -S localhost:4000`.


This project is ready to use. To run the tests, you just have to type the following command into a terminal.

```console
phpunit --boostrap vendor/autoload.php tests/*
```

