<?php
namespace Feature\Provider\Silex;

use Silex\ServiceProviderInterface;
use Silex\Application;
use Feature\Features;

class FeaturesServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['features'] = $app->share(function ($app) {
            return new Features($app['features.config']);
        });
        $app['features.config'] = [];
    }

    public function boot(Application $app)
    {
    }
}
