<?php

namespace Feature\Tests\Provider\Silex;

use Silex\Application;
use Feature\Provider\Silex\FeaturesServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class FeaturesServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $app = new Application();
        $app->register(new FeaturesServiceProvider);

        $app->get('/', function () {
        });
        $request = Request::create('/');
        $app->handle($request);

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
