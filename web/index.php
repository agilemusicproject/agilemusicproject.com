<?php
require_once __DIR__.'/../vendor/autoload.php'; 

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

$app = new Silex\Application(); 

$app['debug'] = true;
$app['upload_folder']=__DIR__ . '/images/photos';

$ini_array = parse_ini_file("../config/amp.ini", true);

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

$app->get('/meettheband', function () use ($app) {
    return $app['twig']->render('meetTheBand.twig'); 
});

$app->get('/bandmembers', function () use ($app) {
    return $app['twig']->render('bandMembers.twig'); 
});

$app->get( '/upload', function() {
    $upload_form = <<<EOF
<html>
<body>
<form enctype="multipart/form-data" action="" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="52428800" />
    Upload this file:
<br><br>
<input name="image" type="file" />
<br><br>
    <input type="submit" value="Send File" />
</form>
</body>
</html>
EOF;
    return $upload_form;
});

$app->post('/upload', function( Request $request ) use ( $app ) {
    $file_bag = $request->files;

    if ( $file_bag->has('image') )
    {
        $image = $file_bag->get('image');
        $image->move(
            $app['upload_folder'], 
            tempnam($app['upload_folder'],'img_') . '.png'
        );
    }

    // This is just temporary.
    // Replace with a RedirectResponse to Gallery
    return print_r( $request->files, true );
});

$app->run(); 