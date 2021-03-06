<?php

use Feature\Features;
use Feature\Provider\Twig\Feature;

require_once(__DIR__.'/../vendor/autoload.php');

$options = getopt('u:');
if (php_sapi_name() === 'cli') {
    $user = isset($options['u']) && $options['u'] === 'admin' ? 'admin' : 'user';
} else {
    $user = isset($_GET['user']) && $_GET['user'] === 'admin' ? 'admin' : 'user';
}

$config = array(
    'foo' => true,
    'bar' => function () use ($user) {
        return $user === 'admin' ? 'admin' : 'user';
    },
    'css' => function () {
        return php_sapi_name() === 'cli' ? false : true;
    }
);
$features = new Features($config);

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader);
$twig->addExtension(new Feature($features));
echo $twig->render('foo.twig');
