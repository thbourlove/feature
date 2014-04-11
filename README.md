# Feature
[![Build Status](https://travis-ci.org/thbourlove/feature.png?branch=master)](https://travis-ci.org/thbourlove/feature)

## What?

Feature API used for operational Dark Launching ad A/B Testing.

## How?

### With Composer:

```json
"require": {
    "feature/feature": "dev-master"
}
```

### Example:
```php
<?php

use Feature\Features;

$user = array(
    'name' => 'a',
    'admin' => false,
),
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
$features->variant('featureA'); // true
$features->variant('featureB'); // false
$features->variant('featureC'); // 'foo'
$features->variant('featureD'); // 'd'
$features->variant('featureZ'); // false
```

### With Silex:
```php
<?php

use Silex\Application;
use Feature\Provider\Silex\FeaturesServiceProvider;

$app = new Application();

$app->register(new FeaturesServiceProvider);

$app['features.config'] = array(
    'featureA' => true,
);

$app['features']->variant('featureA'); // true
```
