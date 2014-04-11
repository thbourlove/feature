<?php
namespace Feature\Tests\Provider\Twig;

use Feature\Provider\Twig\Feature;
use Feature\Features;

class FeatureIntegrationTest extends \Twig_Test_IntegrationTestCase
{
    public function getExtensions()
    {
        $config = array(
            'foo' => true,
            'bar' => function () {
                return 'b';
            },
        );
        $features = new Features($config);
        return array(new Feature($features));
    }

    public function getFixturesDir()
    {
        return dirname(__FILE__).'/Fixtures/';
    }
}
