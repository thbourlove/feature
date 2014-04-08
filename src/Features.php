<?php
namespace Feature;

class Features
{
    private $features = [];

    public function __construct(array $config)
    {
        $this->features = array_merge($config, array('default' => function ($name) {
            return false;
        }));
    }

    public function variant($name)
    {
        if (!array_key_exists($name, $this->features)) {
            return $this->features['default']($name);
        }
        $feature = $this->features[$name];
        if (is_bool($feature)) {
            return $feature;
        } elseif (is_callable($feature)) {
            return $feature();
        }
        return false;
    }
}
