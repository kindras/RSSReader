<?php

// phpinfo();
// date_default_timezone_set('Europe/Paris');

// web/index.php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$con = new Connection('mysql:host=localhost;dbname=RSSReader', 'root', 'root');

$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader);


$app->get('/feeds', function() use($app,$twig,$con) {
	$feedController = new FeedController(new DatabaseFeed($con), $twig);
	return $feedController->listAction();
});
$app->get('/', function() use($app) {
	return "Hello toto";
});

$app->run();
