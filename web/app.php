<?php

// phpinfo();
// date_default_timezone_set('Europe/Paris');
// web/index.php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/Templates'));

$app['debug'] = true;

$con = new Connection('mysql:host=localhost;dbname=RSSReader', 'root', 'root');

$app->get('/', function() use($app, $con) {
    $entryController = new EntryController(new EntryMapper($con), $app['twig']);
    return $entryController->listAction();
});

$app->get('/menu', function() use($app, $con) {
    $feedController = new FeedController(new FeedMapper($con), $app['twig']);
    return $feedController->menuAction();
})->bind('menu');

$app->get('/feeds/all', function() use($app, $con) {
    $feedController = new FeedController(new FeedMapper($con), $app['twig']);
    return $feedController->listAction();
});

$app->get('/feeds/test', function() use($app) {
    $feedController = new FeedController();
    return $feedController->testPicoFeedAction();
});

$app->get('/feeds/{feedId}', function($feedId) use($app, $con) {
    $feedController = new FeedController(new FeedMapper($con), $app['twig']);
    return $feedController->viewAction($feedId);
});

$app->post('/feeds/insert', function() use($app, $con) {
    $feedController = new FeedController(new FeedMapper($con), $app['twig']);
    return $feedController->insertAction();
});

$app->post('/feeds/update/{feedId}', function($feedId) use($app, $con) {
    $feedController = new FeedController(new FeedMapper($con), $app['twig']);
    return $feedController->updateAction($feedId);
});

$app->get('/feeds/delete/{feedId}', function($feedId) use($app, $con) {
    $feedController = new FeedController(new FeedMapper($con), $app['twig']);
    return $feedController->deleteAction($feedId);
});

$app->run();
