<?php
namespace Feature;

class Features
{
    private $features = array();
    private $cache = array();

    public function __construct(array $config)
    {
        $this->features = array_merge(array('default' => function () {
            return false;
        }), $config);
    }

    public function variant($name)
    {
        if (array_key_exists($name, $this->cache)) {
            return $this->cache[$name];
        }
        if (!array_key_exists($name, $this->features)) {
            return $this->cache[$name] = $this->features['default']($name);
        }
        $feature = $this->features[$name];
        if (is_callable($feature)) {
            return $this->cache[$name] = $feature();
        } else {
            return $this->cache[$name] = $feature;
        }
    }
}
