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

$app->get('/blog', function () use ($app) {
    return $app['twig']->render('blog.twig'); 
});

$app->get('/about', function () use ($app) {
    return $app['twig']->render('about.twig'); 
});

$app->get('/music', function () use ($app) {
    return $app['twig']->render('music.twig'); 
});

$app->get('/contactus', function () use ($app) {
    return $app['twig']->render('contact.twig'); 
});

$app->get('/agile', function () use ($app) {
    return $app['twig']->render('agile.twig'); 
});

$app->get('/photos', function () use ($app) {
    return $app['twig']->render('photos.twig'); 
});

$app->get('/meetTheBand', function () use ($app) {
    return $app['twig']->render('meetTheBand.twig'); 
});

$app->run(); 