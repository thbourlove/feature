# Feature
[![Build Status](https://travis-ci.org/thbourlove/feature.png?branch=master)](https://travis-ci.org/thbourlove/feature)
[![Coverage Status](https://coveralls.io/repos/thbourlove/feature/badge.png?branch=master)](https://coveralls.io/r/thbourlove/feature?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/3f166f53-7f52-4f66-9ab6-6a2ec36713f7/mini.png)](https://insight.sensiolabs.com/projects/3f166f53-7f52-4f66-9ab6-6a2ec36713f7)

Feature API used for operational Dark Launching ad A/B Testing.

## Install With Composer:

```json
"require": {
    "eleme/feature": "~0.1"
}
```

## Features Example:
```php
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
```

## Service Provider With Silex:
```php
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
```

## Twig Extension:

##### in php:
```php
<?php

use Feature\Features;
use Feature\Provider\Twig\Feature;

require_once(__DIR__.'/../vendor/autoload.php');

$options = getopt('u:');
$user = isset($options['u']) && $options['u'] === 'admin' ? 'admin' : 'user';

$config = array(
    'foo' => true,
    'bar' => function () use ($user) {
        return $user === 'admin' ? 'admin' : 'user';
    },
);
$features = new Features($config);

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);
$twig->addExtension(new Feature($features));
echo $twig->render('foo.twig');
```

##### in twig:
```jinja
{% feature foo %}
foo ok
{% endfeature %}
{% feature bar - admin %}
bar admin
{% endfeature %}
{% feature bar - user %}
bar user
{% endfeature %}
```
