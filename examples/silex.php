<?php

use Silex\Application;
use Feature\Provider\Silex\FeaturesServiceProvider;

require_once(__DIR__.'/../vendor/autoload.php');

$app = new Application();

$app->register(new FeaturesServiceProvider);

$app['features.config'] = array(
    'featureA' => true,
);

echo var_export($app['features']->variant('featureA')), "\n"; // true
