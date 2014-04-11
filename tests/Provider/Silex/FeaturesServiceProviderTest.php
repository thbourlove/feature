<?php

namespace Silex\Tests\Provider;

use Silex\Application;
use Feature\Provider\Silex\FeaturesServiceProvider;

class FeaturesServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $app = new Application();

        $app->register(new FeaturesServiceProvider);

        $this->assertInstanceOf('Feature\Features', $app['features']);
    }

    public function testConfig()
    {
        $app = new Application();

        $app->register(new FeaturesServiceProvider);

        $app['features.config'] = array(
            'featureA' => true,
        );

        $this->assertEquals(true, $app['features']->variant('featureA'));
    }

    public function testConfigAfterLoad()
    {
        $app = new Application();

        $app->register(new FeaturesServiceProvider);

        $this->assertEquals(false, $app['features']->variant('featureA'));

        $app['features.config'] = array(
            'featureA' => true,
        );

        $this->assertEquals(false, $app['features']->variant('featureA'));
    }
}
