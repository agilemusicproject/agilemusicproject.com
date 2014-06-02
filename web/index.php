<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\DependencyInjection\Definition;

$app = new Silex\Application();

$app['debug'] = true;

$app['debug'] = true;
$app['upload_folder'] = __DIR__ . '/images/photos';
$app['config'] = new AMP\Config(__DIR__ . '/../config/amp.ini');

$app->register(new Silex\Provider\FormServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

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

$app->get('/agile', function () use ($app) {
    return $app['twig']->render('agile.twig');
});

$app->get('/photos', function () use ($app) {
    return $app['twig']->render('photos.twig');
});

$app->get('/meettheband', function () use ($app) {
    return $app['twig']->render('meetTheBand.twig');
});

$app->get('/meettheband/update', function () use ($app) {
    $formDefault = array(
        'first_name' => 'first name',
        'last_name' => 'last name',
        'roles' => 'roles',
        'bio' => 'bio'
    );
    $form = $app['form.factory']->createBuilder('form', $formDefault, array('csrf_protection' => false))
        ->add('first_name', 'text', array('required' => 'true'))
        ->add('last_name', 'text', array('required' => 'true'))
        ->add('roles', 'text', array('required' => 'true'))
        ->add('photo', 'file')
        ->add('bio', 'textarea', array('label_attr' => array('style' => 'vertical-align: top;'),
                                           'attr' => array('cols' => '100', 'rows' => '20')))
        ->add('submit', 'submit')
        ->getForm();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $form->submit($request);
        if ($form->isValid()) {
            $formDefault = $form->getData();
            return $app->redirect('/meettheband');
        } else {
            var_dump($form->getErrorsAsString());
        }
    }
    return $app['twig']->render('meetTheBandUpdate.twig', array('form' => $form->createView()));
});

// CHANGE config getting AND data getting
$app->post('/meettheband/update', function(Request $request) use ($app) {
    $file_bag = $request->files;
    if ($file_bag->has('photo')) {
        $image = $file_bag->get('image');
        $image->move($app['upload_folder'], $image->getClientOriginalName());
    }
    try {

        $dsn = 'mysql:host=' . $app['config']->get('host', 'MySQL') .
            '; dbname=' . $app['config']->get('database', 'MySQL');
        $dbh = new PDO($dsn, $app['config']->get('username', 'MySQL'), $app['config']->get('password', 'MySQL'));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO band_members (filename) VALUES (:filename)";
        $stmt = $dbh->prepare($sql);
        $filename = $image->getClientOriginalName();
        $stmt->bindParam(':filename', $filename);
        $stmt->execute();
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    $dbh = null;
    return $app->redirect('/photos');
});

$app->match('/contactus', function (Request $request) use ($app) {
    $formDefault = array(
        'name' => 'Your name',
        'email' => 'Your email',
        'message' => 'Your message'
    );
    $form = $app['form.factory']->createBuilder('form', $formDefault, array('csrf_protection' => false))
        ->add('name')
        ->add('email')
        ->add('message', 'textarea', array('label_attr' => array('style' => 'vertical-align: top;'),
                                           'attr' => array('cols' => '20', 'rows' => '10')))
        ->add('submit', 'submit')
        ->getForm();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $form->submit($request);
        if ($form->isValid()) {
            $formDefault = $form->getData();
            return $app->redirect('/contactus');
        } else {
            var_dump($form->getErrorsAsString());
        }
    }
    return $app['twig']->render('contact.twig', array('form' => $form->createView()));
});

$app->run();
