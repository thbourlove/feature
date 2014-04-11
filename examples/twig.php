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
