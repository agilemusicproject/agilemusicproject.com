<?php
require_once __DIR__.'/../vendor/autoload.php'; 

use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application(); 

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html'); 
});

$app->get('/blog.html', function () use ($app) {
    return $app['twig']->render('blog.twig'); 
});

$app->get('/music.html', function () use ($app) {
    return $app['twig']->render('music.twig'); 
});

$app->get('/contactus.html', function () use ($app) {
    return $app['twig']->render('contact.twig'); 
});

$app->get('/agile.html', function () use ($app) {
    return $app['twig']->render('agile.twig'); 
});

$app->get('/photos.html', function () use ($app) {
    return $app['twig']->render('photos.twig'); 
});

$app->get('/meetTheBand.html', function () use ($app) {
    return $app['twig']->render('meetTheBand.twig'); 
});

$app->run(); 