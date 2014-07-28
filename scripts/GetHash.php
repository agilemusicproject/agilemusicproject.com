<?php 
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\SecurityServiceProvider());
if (key_exists(1, $argv)) {
    $thingToHash = $argv[1];
    echo $app['security.encoder.digest']->encodePassword($thingToHash, '');
} else {
    echo "You must supply something to hash.";
}
