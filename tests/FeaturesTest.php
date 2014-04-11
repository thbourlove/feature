<?php
namespace Feature\Tests;

use Feature\Features;

class FeaturesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function testVariant($user, $variations)
    {
        $config = array(
            'featureA' => true,
            'featureB' => function () use ($user) {
                return $user['admin'];
            },
            'featureC' => function () use ($user) {
                return $user['name'] == 'a' ? 'foo' : 'bar';
            },
        );
        $features = new Features($config);
        foreach ($variations as $name => $result) {
            $this->assertEquals($features->variant($name), $result);
        }
    }

    public function provider()
    {
        return array(
            array(
                array(
                    'name' => 'a',
                    'admin' => true,
                ),
                array(
                    'featureA' => true,
                    'featureB' => true,
                    'featureC' => 'foo',
                    'featureD' => false,
                )
            ),
            array(
                array(
                    'name' => 'b',
                    'admin' => false,
                ),
                array(
                    'featureA' => true,
                    'featureB' => false,
                    'featureC' => 'bar',
                    'featureD' => false,
                )
            ),
        );
    }
}
