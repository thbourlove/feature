<?php

use Feature\Features;

require_once(__DIR__.'/../vendor/autoload.php');

$user = array(
    'name' => 'a',
    'admin' => false,
);
$config = array(
    'featureA' => true,
    'featureB' => function () use ($user) {
        return $user['admin'];
    },
    'featureC' => function () use ($user) {
        return $user['name'] == 'a' ? 'foo' : 'bar';
    },
    'featureD' => 'd',
);
$features = new Features($config);
echo var_export($features->variant('featureA')), "\n"; // true
echo var_export($features->variant('featureB')), "\n"; // false
echo var_export($features->variant('featureC')), "\n"; // 'foo'
echo var_export($features->variant('featureD')), "\n"; // 'd'
echo var_export($features->variant('featureZ')), "\n"; // false
