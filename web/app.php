<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/Templates'));

$app['debug'] = true;

// API REST
$app->get('/rest/feeds/all', function() use($app) {
    $feedController = new FeedController($app);
    return $feedController->REST_listAction();
});

$app->post('/rest/feeds/subscribe', function(Request $request) use($app) {
    $feedController = new FeedController($app);
    return $feedController->REST_subscribeAction($request);
});

// Application standard
$app->get('/', function() use($app) {
    $entryController = new EntryController($app);
    return $entryController->listAction();
});

$app->get('/entry/{entryId}', function($entryId) use($app) {
    $entryController = new EntryController($app);
    return $entryController->viewAction($entryId);
});

$app->get('/feeds/all', function() use($app) {
    $feedController = new FeedController($app);
    return $feedController->listAction();
});

$app->get('/feeds/manage', function() use($app) {
    $feedController = new FeedController($app);
    return $feedController->manageAction();
});

$app->post('/feeds/subscribe', function(Request $request) use($app) {
    $feedController = new FeedController($app);
    return $feedController->subscribeAction($request);
});

$app->put('/feeds/refresh/{feedId}', function($feedId) use($app) {
    $feedController = new FeedController($app);
    return $feedController->refreshAction($feedId);
});

$app->get('/feeds/{feedId}', function($feedId) use($app) {
    $feedController = new FeedController($app);
    return $feedController->viewAction($feedId);
});

$app->delete('/feeds/{feedId}', function($feedId) use($app) {
    $feedController = new FeedController($app);
    return $feedController->deleteAction($feedId);
});

$app->run();
