<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Knp\Provider\ConsoleServiceProvider;
use My\Command\MyCommand;

set_time_limit(0);

$app = new Silex\Application();
$app->register(new ConsoleServiceProvider(), array(
    'console.name'              => 'RSSReader',
    'console.version'           => '1.0.0',
    'console.project_directory' => __DIR__.'/..'
));

$application = $app['console'];
$application->add(new RefreshCommand());
$application->run();
