<?php
namespace Feature\Provider\Twig;

use Feature\Features;

class Feature extends \Twig_Extension
{
    private $features;

    public function __construct(Features $features)
    {
        $this->features = $features;
    }

    public function getName()
    {
        return 'feature';
    }

    public function getTokenParsers()
    {
        return array(new TokenParser);
    }

    public function getGlobals()
    {
        return array('features' => $this->features);
    }
}
